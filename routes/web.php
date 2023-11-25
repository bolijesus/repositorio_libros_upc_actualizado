<?php

use App\Http\Controllers\AutorController;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\RevistaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TesisController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Bibliografia;
use App\Models\Libro;
use App\Models\Revista;
use App\Models\Role;
use App\Models\Tesis;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('test', function(){
    $admins = Role::where('id','1')->first()->usuarios;
    dd($admins);
    foreach ($admins->usuarios as $admin) {
        dd($admin);
    }
});

// DB::listen(function($query){
//     echo "<h1><pre>{$query->sql}<pre></h1>";
// });

Route::get('/demo',function ()
{
    return view('demo');
});

Route::get('/', function () {
    return redirect()->route('index_front');
});

Route::get('/inicio', function () {
    $libros = Libro::all()->load(['bibliografia', 'bibliografia.usuario']);
    $revistas = Revista::all()->load(['bibliografia', 'bibliografia.usuario']);
    $tesis = Tesis::all()->load(['bibliografia', 'bibliografia.usuario']);
    
    return view('frontoffice.templates.index', compact('libros','revistas','tesis'));
})->name('index_front');

Route::get('search',function ()
{
    if (request()->get('buscar')) {
        $titulo = request()->get('buscar');
        $bibliografias = Bibliografia::where('titulo','like','%'.$titulo.'%')->where('revisado',3)->get();
        return view('frontoffice.templates.content_search',compact('bibliografias'));
    }

    return response(view('errors.404'),404);
});

//BACK OFFICE
Route::name('backoffice.')->middleware(['auth','userVerified'])->group(function (){

    Route::resource('/role', RoleController::class);
    Route::resource('/user', UserController::class);
    Route::get('/activate/{user}',[UserController::class,'activeUser'])->name('activeUser');

    Route::post('/notificacion',[NotificationController::class, 'read'])->name('notification.read');

    Route::resource('/autor', AutorController::class);
    Route::resource('/genero', GeneroController::class);
    Route::get('/index',[ReporteController::class, 'reportes'])->name('index');

    Route::resource('/libro', LibroController::class);
    Route::get('/libro/download/{libro}',[LibroController::class,'download'])->name('libro.download');
    Route::post('/libro/revision/{libro}', [LibroController::class,'revision'])->name('libro.revision');
    
    Route::resource('/revista', RevistaController::class);
    Route::get('/revista/download/{revista}',[RevistaController::class , 'download'])->name('revista.download');
    Route::post('/revista/revision/{revista}', [RevistaController::class , 'revision'])->name('revista.revision');
    
    Route::resource('/tesis', TesisController::class);
    Route::get('/tesis/download/{tesis}',[TesisController::class, 'download'])->name('tesis.download');
    Route::post('/tesis/revision/{tesis}', [TesisController::class, 'revision'])->name('tesis.revision');
    
    Route::post('/puntos', [LibroController::class,'puntosActuales']);
});
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
