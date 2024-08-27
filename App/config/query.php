<?php

namespace App\config;

use App\config\conexion;
use Exception;
use PDOException;

class Query{

    private $db;

    function __construct($db = "track"){
        $this->db = $db;
    }

    function Exec( $function, $sp = false){

        // Abrimos la conexión
        $stmt = conexion::conect($this->db);

        // Iniciamos la transacción

        $stmt->beginTransaction();
        try {
            // Ejecutamos la función que contiene la consulta preparada
            $result = $function($stmt);

            // Confirmamos la transacción
            if (!$sp) {
                $stmt->commit();
            };

            // Cerramos la conexión
            Conexion::close($stmt);
            // Retornamos el resultado
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