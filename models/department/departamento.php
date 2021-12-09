<?php
class Departamento {

    private $id;
    private $codigo;
    private $nombre;
    private $idprofesor;

    public function __construct($id=NULL, $codigo=NULL, $nombre=NULL, $idprofesor=NULL){
        if(!empty($id)) {
            $this->constructEntity($id, $codigo, $nombre, $idprofesor);
        }
    }

    public function constructEntity($id=NULL, $codigo=NULL, $nombre=NULL, $idprofesor=NULL) {
        $this->setId($id);
        $this->setCodigo($codigo);
        $this->setNombre($nombre);
        $this->setidProfesor($idprofesor);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        if (empty($id) || strlen($id)>8) {
            throw new Exception('Error de validación. Id incorrecto.');
        } else {
            $this->id = $id;
        }
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function setCodigo($codigo) {
        if (empty($codigo) || strlen($codigo)>6 || substr($codigo, 0, 1 ) !== "D") {
            throw new Exception('Error de validación. Código incorrecto.');
        } else {
            $this->codigo = $codigo;
        }
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        if (empty($nombre) || strlen($nombre)>30) {
            throw new Exception('Error de validación. Nombre incorrecto.');
        } else {
            $this->nombre = $nombre;
        }
    }

    public function getIdprofesor() {
        return $this->idprofesor;
    }

    public function setidProfesor($idprofesor) {
        if (empty($idprofesor)) {
            throw new Exception('Error de validación. Profesor incorrecto.');
        } else {
            $this->idprofesor = $idprofesor;
        }
    }

    public static function expose() {
        return get_class_vars(__CLASS__);
    }
}
