<?php

namespace App\HTTP\Controllers;


use App\Services\AlumnoService;
use Exception;
use Klein\Request;
use Klein\Response;

class PruebaController
{
    protected $alumnoservice;

    public function __construct()
    {
        $this->alumnoservice = new AlumnoService();
    }
    
    public function prueba(Request $request,Response $response){
        try{
            $codigo=intval($request->codigo);
            $res=$this->alumnoservice->findByCodigo($codigo);
            return $response->json($res) ;
            return $response->json(['message' => 'hola mundo']);
        }catch(Exception $e){
            $response->code(400);
            return $response->json(['message'=>$e->getMessage()]);
        }
    }
}
