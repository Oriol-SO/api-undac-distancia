<?php

namespace App\Services;

use App\repository\AlumnoRepository;
use Exception;

class AlumnoService{


    public function findByCodigo($codigo){
        $res = AlumnoRepository::findByCodigo($codigo);
        if(count($res)>1){
            throw new Exception("Usuario con más de una especialidad", 409);
        }
        return  empty($res) ? throw new Exception("Usuario no encontrado", 409) : $res;
    }
}