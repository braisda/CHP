<?php
class Tutoria
{
    private $idtutoria;
    private $idprofesor;
    private $fechainicio;
    private $fechafin;

    public function __construct($idtutoria=NULL, $idprofesor=NULL, $fechainicio=NULL, $fechafin=NULL){
        if(!empty($idtutoria)) {
            $this->constructEntity($idtutoria, $idprofesor, $fechainicio, $fechafin);
        }
    }

    public function constructEntity($idtutoria=NULL, $idprofesor=NULL, $fechainicio=NULL, $fechafin=NULL) {
        $this->setIdtutoria($idtutoria);
        $this->setIdprofesor($idprofesor);
        $this->setFechainicio($fechainicio);
        $this->setFechafin($fechafin);
    }

    public function getIdtutoria()
    {
        return $this->idtutoria;
    }

    public function setIdtutoria($idtutoria)
    {
        if (empty($idtutoria) || strlen($idtutoria)>8) {
            throw new Exception('Error de validación. Id incorrecto.');
        } else {
            $this->idtutoria = $idtutoria;
        }
    }

    public function getIdprofesor()
    {
        return $this->idprofesor;
    }

    public function setIdprofesor($idprofesor)
    {
        if (empty($idprofesor) || strlen($idprofesor)>8) {
            throw new Exception('Error de validación. Id profesor incorrecto.');
        } else {
            
            $this->idprofesor = $idprofesor;
        }
    }

    public function getFechainicio()
    {
        return $this->fechainicio;
    }

    public function setFechainicio($fechainicio)
    {
        if (empty($fechainicio) || strlen($fechainicio)>30) {
            throw new Exception('Error de validación. Fecha inicio incorrecta.');
        } else {
            $this->fechainicio = $fechainicio;
        }
    }

    public function getFechafin()
    {
        return $this->fechafin;
    }

    public function setFechafin($fechafin)
    {
        if (empty($fechafin) || strlen($fechafin)>30) {
            throw new Exception('Error de validación. Fecha fin incorrecta.');
        } else {
            $this->fechafin = $fechafin;
        }
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
