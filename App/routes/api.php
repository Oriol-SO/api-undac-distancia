<?php

use App\HTTP\Controllers\AlumnoController;
use Klein\Klein;

$klein = new Klein();

$klein->respond(function ($request, $response) {
    // Configuración de encabezados CORS
    $response->header('Access-Control-Allow-Origin', '*');
    $response->header('Access-Control-Allow-Methods', 'GET','OPTIONS');
    $response->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    $response->header('Access-Control-Allow-Credentials', 'true');
    $response->header('Access-Control-Max-Age', '86400');

    if ($request->method() === 'OPTIONS') {
        $response->status(200);
        $response->send();
        exit;
    }

});

/*
$klein->with('/head', function () use ($klein) {
    $klein->respond('GET', '/?', function ($request, $response) {
         $all_headers = $response->headers()->all();
         return $response->json($all_headers) ;
    });
 });*/

function invoke($class){
    if(class_exists($class)){
        $instancia= new $class();
        return $instancia;
    }
}

$klein->respond('GET','/api/alumno/[:codigo]',function ($req,$res) {
    return invoke(AlumnoController::class)->getAlumno($req,$res);
});

return $klein;
