<?php
class GrupoMateria {
    private $id;
    private $nombre;
    private $idmateria;

    public function __construct($id=NULL, $nombre=NULL, $idmateria=NULL){
        if(!empty($id)) {
            $this->constructEntity($id, $nombre, $idmateria);
        }
    }

    public function constructEntity($id=NULL, $nombre=NULL, $idmateria=NULL) {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setIdmateria($idmateria);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        if (empty($id) || strlen($id) > 8) {
            throw new Exception('Error de validación. Id incorrecto.');
        } else {
            $this->id = $id;
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

    public function getIdmateria() {
        return $this->idmateria;
    }

    public function setIdmateria($idmateria) {
        if (empty($idmateria) || strlen($idmateria)>9) {
            throw new Exception('Error de validación. Id materia incorrecto.');
        } else {
            $this->idmateria = $idmateria;
        }
    }

    public static function expose() {
        return get_class_vars(__CLASS__);
    }
}
