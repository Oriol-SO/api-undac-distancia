<?php
namespace App\repository;

use App\config\Query;
use PDO;

class AlumnoRepository{

    public static function findBycodigo($codigo)
    {
        // Ejemplo de uso
        $sql = new Query();
        return $sql->Exec(function ($con) use ($codigo) {
            $query = "SELECT id, codigo, nombres, espe, esp_nomb FROM alumnos 
            INNER JOIN especialidades_distancia ON alumnos.espe = especialidades_distancia.esp_codi
            WHERE codigo= :cod";
            $stmt = $con->prepare($query);
            $stmt->bindParam(":cod", $codigo, PDO::PARAM_INT);
            $stmt->execute();

            //return [$query];
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        });
    }
}