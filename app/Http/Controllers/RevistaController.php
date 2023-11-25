<?php

namespace App\Http\Controllers;

use App\Models\Revista;
use App\Models\Autor;
use App\Models\Bibliografia;
use App\Models\Genero;
use App\Http\Requests\Revista\UpdateRequest;
use App\Http\Requests\Revista\StoreRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate as FacadesGate;
use Illuminate\Support\Facades\Storage;

class RevistaController extends Controller
{
    private $path='public/revistas/';
    private $default_portada='public/portada.png';
    private $path_image = 'public/imagenes/revistas/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = \auth()->user();        
        if ($usuario->isAdmin()) {            
            $revistas = Revista::all()->load(['bibliografia','bibliografia.usuario','bibliografia.autores']);
        }else {
            $bibliografias_revistas = $usuario->bibliografias->where('bibliografiable_type',Revista::class);
            $revistas = \getChildModel($bibliografias_revistas)->load(['bibliografia','bibliografia.usuario','bibliografia.autores']);
        }
        return \view('models.revista.index',\compact('revistas'));

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
        return \view('models.revista.create',['revista' => new Revista(), 'autores' => $autores, 'generos' => $generos]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {   
        $revista=$request->only(['publicador']);                
        $bibliografia = $this->storeFile($request);
        $autores = $request->autores;
        $generos = $request->generos;
        
        try {
            DB::transaction(function()use($bibliografia, $revista, $autores, $generos){
                $revista = Revista::create($revista);
                $bibliografia = $this->storeImage($bibliografia, Auth::user());
                $bibliografia=$bibliografia->except(['publicador', '_archivo']);
                
                $bibliografia = $revista->bibliografia()->create($bibliografia);
                $bibliografia->autores()->sync($autores);
                $bibliografia->generos()->sync($generos);
                \notificarAdministradores($revista,'Se ha subido una nueva revista.');
            },5);
        } catch (\Throwable $th) {
            dd($th);
            return \redirect()->route('backoffice.revista.index')->with('alert',swal(
                "'ERROR en el sistema',
                'No se pudo subir su archivo, por favor intente mas tarde',
                'error'"
            ));
        }
        return \redirect()->route('backoffice.revista.index')
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
     * @param  \App\Revista  $revista
     * @return \Illuminate\Http\Response
     */
    public function show(Revista $revista)
    {
        if (Auth::user()->id != $revista->bibliografia->usuario->id) {
            if ($revista->bibliografia->reporte == null) {
                $revista->bibliografia->reporte()->create(['vistas' => 1]);            
            }else{
               $vistas = $revista->bibliografia->reporte->vistas; 
               $vistas++;
               $revista->bibliografia->reporte()->update(['vistas' => $vistas]);
               
            }
        }
        $revista = $revista->load(['bibliografia', 'bibliografia.autores']);
        return \view('models.revista.show',\compact('revista'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Revista  $revista
     * @return \Illuminate\Http\Response
     */
    public function edit(Revista $revista)
    {
        FacadesGate::authorize('editar-revistas', $revista);
        $autores = Autor::all();
        $generos = Genero::all();
        
        return \view('models.revista.edit',\compact('autores','revista','generos') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Revista  $revista
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Revista $revista)
    {
        FacadesGate::authorize('editar-revistas', $revista);
        $usuario = $revista->bibliografia->usuario;
        $revista = $revista->load(['bibliografia','bibliografia.autores']);
        $bibliografia = $revista->bibliografia;
        if (\request()->has('_portada') && !($bibliografia->portada === $this->default_portada)) {
            Storage::disk('s3')->delete($bibliografia->portada);
        }
        $request = $this->storeImage($request, $usuario);
        $autores = $request->autores;
        $generos = $request->generos;
        try {
            DB::transaction(function () use ($request, $revista, $autores, $generos)
            {
                $enRevision=1;
                $noAceptado=2;
                if (request()->has('_archivo')) {
                    Storage::disk('s3')->delete($revista->bibliografia->archivo);               
                    $request = $this->updateFile($request, $revista);
                }  

                if ( !Auth::user()->isAdmin() && $revista->bibliografia->revisado != $enRevision ) {
                    $request = Arr::add($request,'revisado',$enRevision);
                }

                if ($revista->bibliografia->revisado == $noAceptado ) {
                    \notificarAdministradores($revista,'Revista actualizada para revision','update','bg-orange');
                } 
                $revista->bibliografia->update($request->except(['publicador']));                    
                $revista->update($request->only(['publicador']));
                $revista->bibliografia->autores()->sync($autores);
                $revista->bibliografia->generos()->sync($generos);
            },5);

            // TODO::ordenar si en una funcion para guardar archivos y mensajes de swerAler
            return \redirect()->route('backoffice.revista.index')->with('alert',\swal("
                'revista Atualizado',
                'Se actualizo la revista satisfactoriamente',
                'success'
            "));
            
        } catch (Throwable $th) {
            return \redirect()->route('backoffice.revista.index')->with('alert',\swal("
                'revista NO Atualizado',
                '(ERROR DEL SISTEMA) intentelo nuevamente',
                'error'
            "));
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Revista  $revista
     * @return \Illuminate\Http\Response
     */
    public function destroy(Revista $revista)
    {
        $revista = $revista->load(['bibliografia']);
        if (\request()->ajax()) {
            try {
                Storage::disk('s3')->delete($revista->bibliografia->archivo);
                if ($revista->bibliografia->portada != $this->default_portada) {
                    Storage::disk('s3')->delete($revista->bibliografia->portada);
                }
                // $revista->bibliografia->user_id = null;
                // $revista->bibliografia->save();
                $revista->bibliografia->delete();
                $revista->delete();
                
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

    private function updateFile(Request $request, $revista)
    {   
        $id_usuario = $revista->bibliografia->usuario->id;
        $request = $this->setFile($request, $id_usuario);        
        
        return $request;
        
    }

    private function setFile(Request $request, $id_usuario)
    {
        $archivo = $request->file('_archivo');
        $extencion = $archivo->clientExtension();        
        $rutaRevista = $this->path.$id_usuario;
        $nombre_a_guardar = str_replace(['-',' ',':'],'',Carbon::now());
        \crearDirectorio($rutaRevista);
        
        
        $rutaGuardado = $request->file('_archivo')->storeAs($rutaRevista,$nombre_a_guardar.'.'.$extencion, ['disk' => 's3']);
        $request = Arr::add($request, 'archivo', $rutaGuardado);

        return $request;
    }

    private function storeImage($request, $usuario){
        
        if ($request->has('_portada')) {
            $rutaImagen = $this->path_image.$usuario->id;
            \crearDirectorio($rutaImagen);
            $rutaGuardado = $request->file('_portada')->store($rutaImagen, ['disk' => 's3']);
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
        return Storage::disk('s3')->download($bibliografia->archivo);
    }

    public function revision(Request $request, Revista $revista)
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
        
        $bibliografia = $revista->bibliografia;
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

            \notificarUsuarios($revista,'Revista no aceptada','close','bg-red');

        }elseif ($revision == $revisado) {
            $bibliografia->revisado = $revisado;
            \asignarPuntos($revista->bibliografia);
            $mensaje = "'Archivo aceptado', 'El archivo se acepto en la plataforma', 'success'";
            \notificarUsuarios($revista,'Revista aceptada en el sistema','check','bg-green');
        } else {
            $bibliografia->revisado = $enRevison;
        }
        
        $bibliografia->save();
        return \redirect()->route('backoffice.revista.index')->with('alert',swal($mensaje));
    }

    public function puntosActuales($bibliografia)
    {
        $bibliografia = Bibliografia::findOrFail($bibliografia);
        if (\request()->ajax()) {
            return Auth::user()->puntos_actuales;
        }
    }
}
