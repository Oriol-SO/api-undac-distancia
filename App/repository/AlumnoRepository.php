<?php
namespace App\repository;

use App\config\Query;
use PDO;

class AlumnoRepository{

    private $sql;

    public function __construct()
    {
        $this->sql = new Query();
    }

    public function findBycodigo($codigo)
    {
        return $this->sql->Exec(function ($con) use ($codigo) {
            $query = "SELECT id, codigo, nombres, espe, esp_nomb FROM alumnos 
            INNER JOIN especialidades_distancia ON alumnos.espe = especialidades_distancia.esp_codi
            WHERE codigo= :cod";
            $stmt = $con->prepare($query);
            $stmt->bindParam(":cod", $codigo, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        });
    }

    public function getCurricula($codigo) {
        return $this->sql->Exec(function ($con) use ($codigo) {

            $stmt = $con->prepare("CALL GetUniformCurricula(:alumno, @curricula)");
            $stmt->bindParam(":alumno", $codigo, PDO::PARAM_STR);
            $stmt->execute();
            $result = $con->query("SELECT @curricula")->fetch(PDO::FETCH_ASSOC);

            return empty($result['@curricula']) ? "" : $result['@curricula'];
        });
    }

    public function getTotalCreditos($idCurricula, $espCodigo) {
        return $this->sql->Exec(function ($con) use ($idCurricula, $espCodigo) {
            $query = "SELECT SUM(asi_cred) as creditos FROM asignaturas WHERE Cur_codi= :cur_cod AND Esp_codi= :esp_cod";
            $stmt = $con->prepare($query);
            $stmt->bindParam(":cur_cod", $idCurricula, PDO::PARAM_STR);
            $stmt->bindParam(":esp_cod", $espCodigo, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return  $result[0]['creditos'] ? intval($result[0]['creditos']) : 0;
        });
    }
}
