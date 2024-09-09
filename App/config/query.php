<?php

namespace App\config;

use App\config\conexion;
use Exception;
use PDOException;

class Query{

    function __construct(){
    }

    function Exec( $function, $sp = false){

        $stmt = conexion::conect(); // Abrimos la conexión
        $stmt->beginTransaction(); // Iniciamos la transacción
        try {

            $result = $function($stmt); // Ejecutamos la función que contiene la consulta preparada

            if (!$sp) { // Confirmamos la transacción
                $stmt->commit();
            }

            Conexion::close($stmt); // Cerramos la conexión
            return $result;

        } catch (PDOException $ex) {
            // Si hay algún error, deshacemos la transacción
            $stmt->rollBack();
            // Cerramos la conexión
            Conexion::close($stmt);
            throw new Exception($ex->getMessage(), 1);
        }
    }
}
