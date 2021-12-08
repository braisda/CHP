<?php
class Departmento {

    private $id;
    private $codigo;
    private $nombre;
    private $profesor;

    public function __construct($id=NULL, $codigo=NULL, $nombre=NULL, $profesor=NULL){
        if(!empty($id)) {
            $this->constructEntity($id, $codigo, $nombre, $profesor);
        }
    }

    public function constructEntity($id=NULL, $codigo=NULL, $nombre=NULL, $profesor=NULL) {
        $this->setId($id);
        $this->setCodigo($codigo);
        $this->setNombre($nombre);
        $this->setProfesor($profesor);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        if (empty($id) || strlen($id)>8) {
            throw new ValidationException('Error de validación. Id incorrecto.');
        } else {
            $this->id = $id;
        }
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function setCodigo($codigo) {
        if (empty($codigo) || strlen($codigo)>6 || substr($codigo, 0, 1 ) !== "D") {
            throw new ValidationException('Error de validación. Código incorrecto.');
        } else {
            $this->codigo = $codigo;
        }
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setName($nombre) {
        if (empty($nombre) || strlen($nombre)>30) {
            throw new ValidationException('Error de validación. Nombre incorrecto.');
        } else {
            $this->nombre = $nombre;
        }
    }

    public function getProfesor() {
        return $this->profesor;
    }

    public function setProfesor($profesor) {
        if (empty($profesor)) {
            throw new ValidationException('Error de validación. Profesor incorrecto.');
        } else {
            $this->profesor = $profesor;
        }
    }

    public static function expose() {
        return get_class_vars(__CLASS__);
    }
}
