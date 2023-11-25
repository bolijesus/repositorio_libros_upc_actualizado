<?php

namespace App\Http\Controllers;

use App\Models\Bibliografia;
use App\Models\Libro;
use App\Models\Revista;
use App\Models\Tesis;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ReporteController extends Controller
{
    public function reportes()
    {
        if (Auth::user()->isAdmin()) {
            $bibliografias = Bibliografia::all();
        }else{
            $bibliografias = Auth::user()->bibliografias;
        }
        
        $vistas = $this->getVistasTotales($bibliografias);
        $descargas = $this->getDescargasTotales($bibliografias);

        $aceptados = $bibliografias->load('reporte')->where('revisado', '=', 3)->count();
        $rechazados = $bibliografias->load('reporte')->where('revisado', '=', 2)->count();
        $revision = $bibliografias->load('reporte')->where('revisado', '=', 1)->count();
        
        $libros = new Collection([
            'cantidad' => $bibliografias->where('bibliografiable_type', '=', Libro::class)->count(),
            'aceptado' => $bibliografias->where('bibliografiable_type', '=', Libro::class)->where('revisado', '=', 3)->count(),
            'rechazado' => $bibliografias->where('bibliografiable_type', '=', Libro::class)->where('revisado', '=', 2)->count(),
            'revision' => $bibliografias->where('bibliografiable_type', '=', Libro::class)->where('revisado', '=', 1)->count(),
            'vistas' => $this->getVistasLibros($bibliografias),
            'descargas' => $this->getDescargasLibros($bibliografias)    
        ]);

        $revistas = new Collection([
            'cantidad' => $bibliografias->where('bibliografiable_type', '=', Revista::class)->count(),
            'aceptado' => $bibliografias->where('bibliografiable_type', '=', Revista::class)->where('revisado', '=', 3)->count(),
            'rechazado' => $bibliografias->where('bibliografiable_type', '=', Revista::class)->where('revisado', '=', 2)->count(),
            'revision' => $bibliografias->where('bibliografiable_type', '=', Revista::class)->where('revisado', '=', 1)->count(),
            'vistas' => $this->getVistasRevistas($bibliografias),
            'descargas' => $this->getDescargasRevistas($bibliografias)    
        ]);

        $tesis = new Collection([
            'cantidad' => $bibliografias->where('bibliografiable_type', '=', Tesis::class)->count(),
            'aceptado' => $bibliografias->where('bibliografiable_type', '=', Tesis::class)->where('revisado', '=', 3)->count(),
            'rechazado' => $bibliografias->where('bibliografiable_type', '=', Tesis::class)->where('revisado', '=', 2)->count(),
            'revision' => $bibliografias->where('bibliografiable_type', '=', Tesis::class)->where('revisado', '=', 1)->count(),
            'vistas' => $this->getVistasTesis($bibliografias),
            'descargas' => $this->getDescargasTesis($bibliografias)    
        ]);

        return \view('index',\compact(
            'vistas', 'descargas', 'libros', 'revistas', 
            'tesis','aceptados', 'rechazados', 'revision',
        ));
    }

    private function getVistasTotales($bibliografias)
    {   
        $bibliografias = $bibliografias->load('reporte');
        $vistasTotales = 0;   

        foreach ($bibliografias as $bibliografia) {
            $vistasTotales += $bibliografia->reporte['vistas'];
        }

        return $vistasTotales;
    }

    private function getDescargasTotales($bibliografias)
    {   
        $bibliografias = $bibliografias->load('reporte');
        $descargasTotales = 0;   

        foreach ($bibliografias as $bibliografia) {
            $descargasTotales += $bibliografia->reporte['descarga'];
        }

        return $descargasTotales;
    }

    private function getVistasLibros($bibliografias)
    {
        $bibliografias = $bibliografias->load('reporte')->where('bibliografiable_type', '=', Libro::class);
        $vistasBilbiografia = 0;
        foreach ($bibliografias as $bibliografia) {
            $vistasBilbiografia +=  $bibliografia->reporte['vistas'];
        }

        return $vistasBilbiografia;
    }

    private function getDescargasLibros($bibliografias)
    {   
        $bibliografias = $bibliografias->load('reporte')->where('bibliografiable_type', '=', Libro::class);;
        $descargasTotales = 0;   

        foreach ($bibliografias as $bibliografia) {
            $descargasTotales += $bibliografia->reporte['descarga'];
        }

        return $descargasTotales;
    }

    private function getVistasRevistas($bibliografias)
    {
        $bibliografias = $bibliografias->load('reporte')->where('bibliografiable_type', '=', Revista::class);
        $vistasBilbiografia = 0;
        foreach ($bibliografias as $bibliografia) {
            $vistasBilbiografia +=  $bibliografia->reporte['vistas'];
        }

        return $vistasBilbiografia;
    }

    private function getDescargasRevistas($bibliografias)
    {   
        $bibliografias = $bibliografias->load('reporte')->where('bibliografiable_type', '=', Revista::class);;
        $descargasTotales = 0;   

        foreach ($bibliografias as $bibliografia) {
            $descargasTotales += $bibliografia->reporte['descarga'];
        }

        return $descargasTotales;
    }

    private function getVistasTesis($bibliografias)
    {
        $bibliografias = $bibliografias->load('reporte')->where('bibliografiable_type', '=', Tesis::class);
        $vistasBilbiografia = 0;
        foreach ($bibliografias as $bibliografia) {
            $vistasBilbiografia +=  $bibliografia->reporte['vistas'];
        }

        return $vistasBilbiografia;
    }

    private function getDescargasTesis($bibliografias)
    {   
        $bibliografias = $bibliografias->load('reporte')->where('bibliografiable_type', '=', Tesis::class);;
        $descargasTotales = 0;   

        foreach ($bibliografias as $bibliografia) {
            $descargasTotales += $bibliografia->reporte['descarga'];
        }

        return $descargasTotales;
    }
   

    
}
