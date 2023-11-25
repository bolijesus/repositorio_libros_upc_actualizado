<?php

namespace App\Http\Controllers;

use App\Models\Tesis;
use App\Models\Autor;
use App\Models\Bibliografia;
use App\Models\Genero;
use App\Http\Requests\Tesis\UpdateRequest;
use App\Http\Requests\Tesis\StoreRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate as FacadesGate;
use Illuminate\Support\Facades\Storage;

class TesisController extends Controller
{
    private $path='public/tesis/';
    private $default_portada='public/portada.png';
    private $path_image = 'public/imagenes/tesis/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = \auth()->user();        
        if ($usuario->isAdmin()) {            
            $tesis = Tesis::all()->load(['bibliografia','bibliografia.usuario','bibliografia.autores']);
        }else {
            $bibliografias_tesis = $usuario->bibliografias->where('bibliografiable_type',Tesis::class);
            $tesis = \getChildModel($bibliografias_tesis)->load(['bibliografia','bibliografia.usuario','bibliografia.autores']);
        }
        return \view('models.tesis.index',\compact('tesis'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $autores = Autor::all();
        $generos = Genero::all();
        return \view('models.tesis.create',['tesis' => new Tesis(), 'autores' => $autores, 'generos' => $generos]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {   
        $tesis=$request->only(['publicadores']);                
        $bibliografia = $this->storeFile($request);
        $autores = $request->autores;
        $generos = $request->generos;
        
        try {
            DB::transaction(function()use($bibliografia, $tesis, $autores, $generos){
                $tesis = Tesis::create($tesis);
                $bibliografia = $this->storeImage($bibliografia, Auth::user());
                $bibliografia=$bibliografia->except(['publicadores', '_archivo']);
                
                $bibliografia = $tesis->bibliografia()->create($bibliografia);
                $bibliografia->autores()->sync($autores);
                $bibliografia->generos()->sync($generos);
                \notificarAdministradores($tesis,'Se ha subido una nueva tesis.');
            },5);
        } catch (\Throwable $th) {
            dd($th);
            return \redirect()->route('backoffice.tesis.index')->with('alert',swal(
                "'ERROR en el sistema',
                'No se pudo subir su archivo, por favor intente mas tarde',
                'error'"
            ));
        }
        return \redirect()->route('backoffice.tesis.index')
        ->with('alert', \swal("
            'Archivo Subido!',
            'El archivo fue Cargado con exito',
            'success'
        "));
        //TODO:: hacer un campo en la tabla donde se especifique el titulo$titulo original del archivo para relacionarlo con el titulo$titulo que se le dara
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tesis  $tesis
     * @return \Illuminate\Http\Response
     */
    public function show(Tesis $tesis)
    {
        if (Auth::user()->id != $tesis->bibliografia->usuario->id) {
            if ($tesis->bibliografia->reporte == null) {
                $tesis->bibliografia->reporte()->create(['vistas' => 1]);            
            }else{
               $vistas = $tesis->bibliografia->reporte->vistas; 
               $vistas++;
               $tesis->bibliografia->reporte()->update(['vistas' => $vistas]);
               
            }
        }
        $tesis = $tesis->load(['bibliografia', 'bibliografia.autores']);
        return \view('models.tesis.show',\compact('tesis'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tesis  $tesis
     * @return \Illuminate\Http\Response
     */
    public function edit(Tesis $tesis)
    {
        FacadesGate::authorize('editar-tesis', $tesis);
        $autores = Autor::all();
        $generos = Genero::all();
        
        return \view('models.tesis.edit',\compact('autores','tesis','generos') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tesis  $tesis
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Tesis $tesis)
    {
        FacadesGate::authorize('editar-tesis', $tesis);
        $usuario = $tesis->bibliografia->usuario;
        $tesis = $tesis->load(['bibliografia','bibliografia.autores']);
        $bibliografia = $tesis->bibliografia;
        if (\request()->has('_portada') && !($bibliografia->portada === $this->default_portada)) {
            Storage::delete($bibliografia->portada);
        }
        $request = $this->storeImage($request, $usuario);
        $autores = $request->autores;
        $generos = $request->generos;
        try {
            DB::transaction(function () use ($request, $tesis, $autores, $generos)
            {
                $enRevision=1;
                $noAceptado=2;

                if (request()->has('_archivo')) {
                    Storage::delete($tesis->bibliografia->archivo);               
                    $request = $this->updateFile($request, $tesis);
                }  

                if ( !Auth::user()->isAdmin() && $tesis->bibliografia->revisado != $enRevision ) {
                    $request = Arr::add($request,'revisado',$enRevision);
                }

                if ($tesis->bibliografia->revisado == $noAceptado ) {
                    \notificarAdministradores($tesis,'Tesis actualizada para revision','update','bg-orange');
                }

                $tesis->bibliografia->update($request->except(['publicadores']));                    
                $tesis->update($request->only(['publicadores']));
                $tesis->bibliografia->autores()->sync($autores);
                $tesis->bibliografia->generos()->sync($generos);
            },5);

            // TODO::ordenar si en una funcion para guardar archivos y mensajes de swerAler
            return \redirect()->route('backoffice.tesis.index')->with('alert',\swal("
                'tesis Atualizado',
                'Se actualizo la tesis satisfactoriamente',
                'success'
            "));
            
        } catch (Throwable $th) {
            return \redirect()->route('backoffice.tesis.index')->with('alert',\swal("
                'tesis NO Atualizado',
                '(ERROR DEL SISTEMA) intentelo nuevamente',
                'error'
            "));
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tesis  $tesis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tesis $tesis)
    {
        $tesis = $tesis->load(['bibliografia']);
        if (\request()->ajax()) {
            try {
                Storage::delete($tesis->bibliografia->archivo);
                if ($tesis->bibliografia->portada != $this->default_portada) {
                    Storage::delete($tesis->bibliografia->portada);
                }
                // $tesis->bibliografia->user_id = null;
                // $tesis->bibliografia->save();
                $tesis->bibliografia->delete();
                $tesis->delete();
                
                return \json_encode(['respuesta'=>true]);
            } catch (\Throwable $th) {
                return \json_encode(['respuesta'=>false]);
            }
        }
    }

    //METODOS PROPIOS
    private function storeFile(Request $request)
    {   
        $id_usuario = Auth::user()->id;

        $request = $this->setFile($request, $id_usuario);

        $request = Arr::add($request, 'user_id', $id_usuario);
        
        
        return $request;
        
    }

    private function updateFile(Request $request, $tesis)
    {   
        $id_usuario = $tesis->bibliografia->usuario->id;
        $request = $this->setFile($request, $id_usuario);        
        
        return $request;
        
    }

    private function setFile(Request $request, $id_usuario)
    {
        $archivo = $request->file('_archivo');
        $extencion = $archivo->clientExtension();        
        $rutaTesis = $this->path.$id_usuario;
        $nombre_a_guardar = str_replace(['-',' ',':'],'',Carbon::now());
        \crearDirectorio($rutaTesis);
        
        
        $rutaGuardado = $request->file('_archivo')->storeAs($rutaTesis,$nombre_a_guardar.'.'.$extencion);
        $request = Arr::add($request, 'archivo', $rutaGuardado);

        return $request;
    }

    private function storeImage($request, $usuario){
        
        if ($request->has('_portada')) {
            $rutaImagen = $this->path_image.$usuario->id;
            \crearDirectorio($rutaImagen);
            $rutaGuardado = $request->file('_portada')->store($rutaImagen);
            $request = Arr::add($request, 'portada', $rutaGuardado);
           
        }

        return $request;
    }

    public function download($bibliografia)
    {
        $bibliografia = Bibliografia::findOrFail($bibliografia);
        if (Auth::user()->id != $bibliografia->usuario->id) {
            if ($bibliografia->reporte == null) {
                $bibliografia->reporte()->create(['descarga' => 1]);            
            }else{
               $descarga = $bibliografia->reporte->descarga; 
               $descarga++;
               $bibliografia->reporte()->update(['descarga' => $descarga]);
               
            }
        }
        $usuario = Auth::user();
        $puntosDescargaActuales = $usuario->puntos_descarga;
        if ($puntosDescargaActuales<=0) {
            return \redirect()->back()->with('alert',swal(
                "'Usted tiene 0 puntos de descarga',
                'No se puede descargar el archivo, porfavor espere 1 dia.',
                'error'"
            ));
        }
        if (!$usuario->isAdmin()) {
            
            $usuario->puntos_descarga = --$puntosDescargaActuales;
          
            $usuario->save();
        }
        return Storage::download($bibliografia->archivo);
    }

    public function revision(Request $request, Tesis $tesis)
    {
        if ($request->revisado != 3) {
            $request->validate([
                'contenido' => 'required'
            ],
            [
                'contenido.required' => 'Porfavor especifique porque rechazo la bibliografia en el sistema'
            ]);
        }
        
        $revision = $request->revisado;
        $mensajeRevision = $request->contenido;
        
        $bibliografia = $tesis->bibliografia;
        $enRevison = 1;
        $noAceptado = 2;
        $revisado = 3;
        $mensaje = "'Ha ocurrido un Error', 'Intentelo nuevamente', 'error'";
 
        if ($revision == $noAceptado) {
            $bibliografia->revisado = $noAceptado;
            $mensaje = "'Archivo No aceptado', 'El archivo no se acepto en la plataforma', 'warning'";
            if ($bibliografia->mensaje == null) {
                $bibliografia->mensaje()->create([
                    'emisor' => Auth::user()->id,
                    'receptor' => $bibliografia->usuario->id,
                    'contenido' => $mensajeRevision
                    ]);
                    
            } else {
                $bibliografia->mensaje->update([
                    'contenido' => $mensajeRevision
                ]);
            }
            \notificarUsuarios($tesis,'Tesis no aceptada','close','bg-red');
        }elseif ($revision == $revisado) {
            $bibliografia->revisado = $revisado;
            \asignarPuntos($tesis->bibliografia);
            $mensaje = "'Archivo aceptado', 'El archivo se acepto en la plataforma', 'success'";
            \notificarUsuarios($tesis,'Tesis aceptada en el sistema','check','bg-green');
        } else {
            $bibliografia->revisado = $enRevison;
        }
        
        $bibliografia->save();
        return \redirect()->route('backoffice.tesis.index')->with('alert',swal($mensaje));
    }

    public function puntosActuales($bibliografia)
    {
        $bibliografia = Bibliografia::findOrFail($bibliografia);
        if (\request()->ajax()) {
            return Auth::user()->puntos_actuales;
        }
    }
}
