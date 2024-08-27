<?php
namespace App\entities;

class Alumno
{
    public Alumno $alumno;

    public $id;
    public $codigo;
    public $nombres;
    public $espe;
    public $esp_nombre;

    public function __construct(Alumno $alumno=null)
    {   
        if(!$alumno){
            $this->alumno= new Alumno();
        }else{
            $this->alumno= $alumno;
        }    
    }
    
    public function id($id): Alumno{
        $this->alumno->id=$id;
        return $this;
    }
    public function codigo($codigo): Alumno{
        $this->alumno->codigo=$codigo;
        return $this;
    }
    public function nombres($nombres): Alumno{
        $this->alumno->nombres=$nombres;
        return $this;
    }
    public function espe($espe): Alumno{
        $this->alumno->espe=$espe;
        return $this;
    }

    public function esp_nombre($esp_nombre):Alumno{
        $this->alumno->esp_nombre=$esp_nombre;
        return $this;
    }

    public function get():Alumno{
        return $this->alumno;
    }
}