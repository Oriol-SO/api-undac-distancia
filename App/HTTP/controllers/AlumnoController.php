<?php

namespace App\HTTP\Controllers;


use App\Services\AlumnoService;
use Exception;
use Klein\Request;
use Klein\Response;

class AlumnoController
{
    protected $alumnoservice;

    public function __construct()
    {
        $this->alumnoservice = new AlumnoService();
    }

    public function getAlumno(Request $request,Response $response){
        try{
            $codigo=$request->codigo;
            $res=$this->alumnoservice->findByCodigo($codigo);
            return $response->json($res) ;
        }catch(Exception $e){
            $response->code(400);
            return $response->json(['message'=>$e->getMessage()]);
        }
    }
}
