<?php
namespace App\Http\Controllers;

use App\Models\Autor;
use App\Models\Bibliografia;
use App\Models\Genero;
use App\Http\Requests\Libro\StoreRequest;
use App\Http\Requests\Libro\UpdateRequest;
use App\Models\Libro;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate as FacadesGate;
use Illuminate\Support\Facades\Storage;

class LibroController extends Controller
{
    private $path='public/libros/';
    private $default_portada='public/portada.png';
    private $path_image = 'public/imagenes/libros/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = \auth()->user();        
        if ($usuario->isAdmin()) {            
            $libros = Libro::all()->load(['bibliografia','bibliografia.usuario','bibliografia.autores']);
        }else {
            $bibliografias_libros = $usuario->bibliografias->where('bibliografiable_type',Libro::class);
            $libros = \getChildModel($bibliografias_libros)->load(['bibliografia','bibliografia.usuario','bibliografia.autores']);
        }
        return \view('models.libro.index',\compact('libros'));
        
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
        return \view('models.libro.create',['libro' => new Libro(), 'autores' => $autores, 'generos' => $generos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {   
        
        $libro=$request->only(['editorial', 'isbn']);                
        $bibliografia = $this->storeFile($request);
        $autores = $request->autores;
        $generos = $request->generos;
        try {
            DB::transaction(function()use($bibliografia, $libro, $autores, $generos){
                $libro = Libro::create($libro);
                $bibliografia = $this->storeImage($bibliografia, Auth::user());
                $bibliografia=$bibliografia->except(['editorial', 'isbn', '_archivo']);
                
                $bibliografia = $libro->bibliografia()->create($bibliografia);
                $bibliografia->autores()->sync($autores);
                $bibliografia->generos()->sync($generos);

                \notificarAdministradores($libro,'Se ha subido un nuevo libro.');
                
            },5);
            
        } catch (\Throwable $th) {
            dd($th);
            return \redirect()->route('backoffice.libro.index')->with('alert',swal(
                "'ERROR en el sistema',
                'No se pudo subir su archivo, por favor intente mas tarde',
                'error'"
            ));
        }
        return \redirect()->route('backoffice.libro.index')
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
     * @param  \App\Libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function show(Libro $libro)
    {
        $libro = $libro->load(['bibliografia', 'bibliografia.autores']);
        if (Auth::user()->id != $libro->bibliografia->usuario->id) {
        
            if ($libro->bibliografia->reporte == null) {
                $libro->bibliografia->reporte()->create(['vistas' => 1]);            
            }else{
               $vistas = $libro->bibliografia->reporte->vistas; 
               $vistas++;
               $libro->bibliografia->reporte()->update(['vistas' => $vistas]);
               
            }
        }
        return \view('models.libro.show',\compact('libro'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function edit(Libro $libro)
    {
        FacadesGate::authorize('editar-libros', $libro);
        $autores = Autor::all();
        $generos = Genero::all();

        

        return \view('models.libro.edit',\compact('autores','libro','generos') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Libro $libro)
    {
        FacadesGate::authorize('editar-libros', $libro);
        $usuario = $libro->bibliografia->usuario;
        $libro = $libro->load(['bibliografia','bibliografia.autores']);
        $bibliografia = $libro->bibliografia;
        if (\request()->has('_portada') && !($bibliografia->portada === $this->default_portada)) {
            Storage::disk('s3')->delete($bibliografia->portada);
        }
        $request = $this->storeImage($request, $usuario);
        $autores = $request->autores;
        $generos = $request->generos;
        try {
            DB::transaction(function () use ($request, $libro, $autores, $generos)
            {
                $enRevision=1;
                $noAceptado=2;
                if (request()->has('_archivo')) {
                    Storage::disk('s3')->delete($libro->bibliografia->archivo);               
                    $request = $this->updateFile($request, $libro);
                }  

                if ( !Auth::user()->isAdmin() && $libro->bibliografia->revisado != $enRevision ) {
                    $request = Arr::add($request,'revisado',$enRevision);
                }

                if ($libro->bibliografia->revisado == $noAceptado ) {
                    \notificarAdministradores($libro,'Libro actualizado para revision','update','bg-orange');
                }
                  
                $libro->bibliografia->update($request->except(['editorial','isbn']));                    
                $libro->update($request->only(['editorial','isbn']));
                $libro->bibliografia->autores()->sync($autores);
                $libro->bibliografia->generos()->sync($generos);
            },5);

            // TODO::ordenar si en una funcion para guardar archivos y mensajes de swerAler
            return \redirect()->route('backoffice.libro.index')->with('alert',\swal("
                'Libro Atualizado',
                'Se actualizo el libro satisfactoriamente',
                'success'
            "));
            
        } catch (Throwable $th) {
            return \redirect()->route('backoffice.libro.index')->with('alert',\swal("
                'Libro NO Atualizado',
                '(ERROR DEL SISTEMA) intentelo nuevamente',
                'error'
            "));
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Libro $libro)
    {
        $libro = $libro->load(['bibliografia']);
        if (\request()->ajax()) {
            try {
                Storage::disk('s3')->delete($libro->bibliografia->archivo);
                if ($libro->bibliografia->portada != $this->default_portada) {
                    Storage::disk('s3')->delete($libro->bibliografia->portada);
                }
                // $libro->bibliografia->user_id = null;
                // $libro->bibliografia->save();
                $libro->bibliografia->delete();
                $libro->delete();
                
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

    private function updateFile(Request $request, $libro)
    {   
        $id_usuario = $libro->bibliografia->usuario->id;
        $request = $this->setFile($request, $id_usuario);        
        
        return $request;
        
    }

    private function setFile(Request $request, $id_usuario)
    {
        $archivo = $request->file('_archivo');
        $extencion = $archivo->clientExtension();        
        $rutaLibro = $this->path.$id_usuario;
        $nombre_a_guardar = str_replace(['-',' ',':'],'',Carbon::now());
        \crearDirectorio($rutaLibro);
        
        
        $rutaGuardado = $request->file('_archivo')->storeAs($rutaLibro,$nombre_a_guardar.'.'.$extencion, ['disk' => 's3']);
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

    public function revision(Request $request, Libro $libro)
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
        
        $bibliografia = $libro->bibliografia;
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
            \notificarUsuarios($libro,'Libro no aceptado','close','bg-red');
        }elseif ($revision == $revisado) {
            $bibliografia->revisado = $revisado;
            \asignarPuntos($libro->bibliografia);
            $mensaje = "'Archivo aceptado', 'El archivo se acepto en la plataforma', 'success'";
            \notificarUsuarios($libro,'Libro aceptado en el sistema','check','bg-green');
        } else {
            $bibliografia->revisado = $enRevison;
        }
        
        $bibliografia->save();
        return \redirect()->route('backoffice.libro.index')->with('alert',swal($mensaje));
    }

    public function puntosActuales()
    {       
        if (\request()->ajax()) {
            return Auth::user()->puntos_descarga;
        }
    }
     
}
