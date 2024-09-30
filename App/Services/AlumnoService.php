<?php

namespace App\Services;

use App\repository\AlumnoRepository;
use DateTime;
use Exception;

class AlumnoService{

    private $repository;

    public function __construct() {
        $this->repository = new AlumnoRepository();
    }

    public function findByCodigo($codigo){
        $response = $this->getDataApi($codigo);
        if (count($response)<3){
            $response = $this->repository->findByCodigo($codigo);
            if (empty($response)) throw new Exception("Usuario no encontrado", 409);
            $idCurricula = $this->repository->getCurricula($codigo);
            $creditos = $this->repository->getTotalCreditos($idCurricula, $response[0]["espe"]);
            if (count($response)>1) throw new Exception("Usuario con más de una especialidad", 409);
            $response = $this->constructResponse($response, $codigo, $idCurricula, $creditos);
        }
        return $response;
    }

    private function getDataApi($codigo) {

        $curl = curl_init();
        $url = "http://distancia.undac.edu.pe:8080/tasks/6996522b093b1c5560199ed48b553b9f/91f33e2776c526b9cca723a63476f028/".$codigo;
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);

        if (curl_errno($curl)) {
//            throw new Exception(curl_error($curl), 409);
            return [];
        } else {
            curl_close($curl);
            $response = json_decode($response, true);
            if (count($response) > 3) {
                $añoIngreso = substr($codigo,0,2);
                $date = DateTime::createFromFormat('d-m-y', "01-03-$añoIngreso");
                $fechaIngreso = $date->format('d-m-Y');
                $response["Fecha de Ingreso"] = $fechaIngreso;
                $response["Creditos"] = 0;
            }
            return $response;
        }
    }

    private function constructResponse($res, $codigo, $curricula, $creditos) {
        $response = [];

        $nombres = explode(',',$res[0]['nombres']);
        $añoIngreso = substr($codigo,0,2);
        $date = DateTime::createFromFormat('d-m-y', "01-03-$añoIngreso");
        $fechaIngreso = $date->format('d-m-Y');

        $response['Apellido Paterno'] = explode(" ", $nombres[0])[0];
        $response['Apellido Materno'] = explode(" ", $nombres[0])[1];
        $response['Nombres'] = trim($nombres[1]);
        $response['Correo Institucional'] = $codigo."@undac.edu.pe";
        $response['Dni'] = $codigo;
        $response['Fecha de Ingreso'] = $fechaIngreso;
        $response['Curricula'] = $curricula.$res[0]["espe"];
        $response['idEspecialidad'] = $res[0]["espe"];
        $response['Programa facultad'] = $res[0]["esp_nomb"];
        $response["Creditos"] = $creditos;
        $response['Fecha de nacimiento'] = null;
        $response['Genero'] = "F";
        $response['Domicilio'] = null;
        $response['Rol'] = "EG";


        return $response;
    }
}
