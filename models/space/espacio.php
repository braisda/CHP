<?php
class Espacio {
    private $id;
    private $nombre;
    private $idedificio;
    private $capacidad;
    private $oficina;

    public function __construct($id=NULL, $nombre=NULL, $idedificio=NULL, $capacidad=NULL, $oficina=NULL){
        if(!empty($id)) {
            $this->constructEntity($id, $nombre, $idedificio, $capacidad, $oficina);
        }
    }

    public function constructEntity($id=NULL, $nombre=NULL, $idedificio=NULL, $capacidad=NULL, $oficina=NULL) {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setIdedificio($idedificio);
        $this->setCapacidad($capacidad);
        $this->setOficina($oficina);
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

    public function getIdedificio() {
        return $this->idedificio;
    }

    public function setIdedificio($idedificio) {
        if (empty($idedificio) || strlen($idedificio)>9) {
            throw new Exception('Error de validación. Id edificio incorrecto.');
        } else {
            $this->idedificio = $idedificio;
        }
    }

    public function getCapacidad() {
        return $this->capacidad;
    }

    public function setCapacidad($capacidad) {
        if (empty($capacidad) || strlen($capacidad)>3) {
            throw new Exception('Error de validación. Capacidad incorrecta.');
        } else {
            $this->capacidad = $capacidad;
        }
    }

    public function getOficina() {
        return $this->oficina;
    }

    public function isOffice() {
        return $this->oficina;
    }

    public function setOficina($oficina) {
        $oficina = boolval($oficina) ? boolval($oficina) : false;
        if (is_bool($oficina)) {
            $this->oficina = (int) $oficina;
        } else {
            throw new Exception('Error de validación. Despacho indicado de forma incorrecta.');
        }
    }

    public static function expose() {
        return get_class_vars(__CLASS__);
    }
}
