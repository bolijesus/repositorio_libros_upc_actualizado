<?php

namespace App\Http\Controllers;

use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function read()
    {
        if (\request()->ajax()) {
            $idNotification = \request()->id_notificacion;
            $notificacion = DatabaseNotification::find($idNotification);
            if ($notificacion != null) {
                $notificacion->markAsRead();
                return json_encode(['respuesta' => true]);
            }
        }
        return json_encode(['respuesta' => false]);;
    }
}
