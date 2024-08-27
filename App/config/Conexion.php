<?php

namespace App\config;
use Dotenv\Dotenv;
use PDO;

class conexion{

    public static function conect()
    {
        // Cargar variables de entorno
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $host = $_ENV['DB_HOST'];
        $port = $_ENV['DB_PORT'];

        $db = $_ENV['DB_DATABASE'];
        $user = $_ENV['DB_USERNAME'];
        $pass = $_ENV['DB_PASSWORD'];
        $charset = $_ENV['DB_CHARSET'];

        $sgbd_track = "mysql:host=" . $host . ";dbname=" . $db;
        $link = new PDO($sgbd_track, $user, $pass, [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        $link->exec("set names utf8");

        return $link;
    }

    public static function validar()
    {
        Conexion::conect();
        return  null;
    }

    public static function close(PDO $pdo)
    {
        $pdo = null;
    }
    
}