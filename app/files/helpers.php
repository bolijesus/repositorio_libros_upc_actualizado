<?php

use App\Models\Bibliografia;
use App\Models\Role;
use App\Notifications\MessageSetn;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

if (!function_exists('active')) {
    function active($routeName){
        return request()->routeIs($routeName) ? 'active' : '';
    }
}
if (!function_exists('creadaHace')) {
    function creadaHace($date){
        
        return Carbon::createFromTimeString($date)->diffForHumans();
    }
}
if (!function_exists('notificarAdministradores')) {
    function notificarAdministradores($bibliografiable,$mensaje,$icono='file_upload',$color='bg-light-green')
    {
      
        $modelo =  strtolower(class_basename($bibliografiable)); 
        $mensajeNotificacion = [
            'icon' => $icono,
            'color'=> $color,
            'mensaje'=>$mensaje,
            'route'=> \route('backoffice.'.$modelo.'.show',$bibliografiable),
            'time' => Carbon::now()
        ];

        $admins = Role::where('id','1')->first()->usuarios;
        foreach ($admins as $admin) {
            $admin->notify(new MessageSetn($mensajeNotificacion));
        }
    }
}
if (!function_exists('notificarUsuarios')) {
    function notificarUsuarios($bibliografiable,$mensaje,$icono='file_upload',$color='bg-light-green')
    {
      
        $modelo =  strtolower(class_basename($bibliografiable)); 
        $mensajeNotificacion = [
            'icon' => $icono,
            'color'=> $color,
            'mensaje'=>$mensaje,
            'route'=> \route('backoffice.'.$modelo.'.show',$bibliografiable),
            'time' => Carbon::now()
        ];
        $bibliografiable->bibliografia->usuario->notify(new MessageSetn($mensajeNotificacion));
    }
}
if (!function_exists('swal')) {
    function swal($mensaje){
        return new HtmlString($mensaje);
    }
}
if (!function_exists('crearDirectorio')) {
    function crearDirectorio($paht)
    {
       
        if (Storage::allFiles($paht) == null) {
            
            Storage::makeDirectory($paht);
            
        }
        
    }
}
if (!function_exists('getChildModel')) {
    function getChildModel($bibliografias)
    {       
        $bibliografias = $bibliografias;
        $model = new Collection();
        foreach ($bibliografias as $bibliografia) {
            $model->push($bibliografia->bibliografiable);
        }

        return $model;
    }
}
if (!function_exists('asignarPuntos')) {
    function asignarPuntos(Bibliografia $bibliografia)
    { 
        $user = $bibliografia->usuario;

        if ($user->puntos_descarga < 99) {
            
            $user->puntos_descarga++;
            $user->save();
        }
    
        
    }
}
