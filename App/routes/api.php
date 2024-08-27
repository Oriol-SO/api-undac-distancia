<?php

use App\HTTP\Controllers\PruebaController;
use Klein\Klein;
//use App\HTTP\Controllers\PruebaController;

$klein = new Klein();


// Middleware para manejar encabezados CORS
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

$klein->respond('GET','/[:codigo]',function ($req,$res) {
    return invoke(PruebaController::class)->prueba($req,$res);
});



/*
// Ruta para obtener todos los usuarios
$klein->respond('GET', '/users', [UserController::class, 'getAllUsers']);

// Ruta para obtener un usuario por ID
$klein->respond('GET', '/users/[i:id]', [UserController::class, 'getUserById']);

// Ruta para crear un nuevo usuario
$klein->respond('POST', '/users', [UserController::class, 'createUser']);

// Ruta para actualizar un usuario por ID
$klein->respond('PUT', '/users/[i:id]', [UserController::class, 'updateUser']);

// Ruta para eliminar un usuario por ID
$klein->respond('DELETE', '/users/[i:id]', [UserController::class, 'deleteUser']);*/

return $klein;
