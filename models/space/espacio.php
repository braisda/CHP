<?php
class Espacio {
    private $id;
    private $nombre;
    private $edificio;
    private $capacidad;
    private $oficina;

    public function __construct($id=NULL, $nombre=NULL, $edificio=NULL, $capacidad=NULL, $oficina=NULL){
        if(!empty($id)) {
            $this->constructEntity($id, $nombre, $edificio, $capacidad, $oficina);
        }
    }

    public function constructEntity($id=NULL, $nombre=NULL, $edificio=NULL, $capacidad=NULL, $oficina=NULL) {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setEdificio($edificio);
        $this->setCapacidad($capacidad);
        $this->setOficina($oficina);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        if (empty($id) || strlen($id) > 8) {
            throw new ValidationException('Error de validación. Id incorrecto.');
        } else {
            $this->id = $id;
        }
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        if (empty($nombre) || strlen($nombre)>30) {
            throw new ValidationException('Error de validación. Nombre incorrecto.');
        } else {
            $this->nombre = $nombre;
        }
    }

    public function getEdificio() {
        return $this->edificio;
    }

    public function setEdificio($edificio) {
        if (empty($edificio) || strlen($edificio)>8) {
            throw new ValidationException('Error de validación. Id edificio incorrecto.');
        } else {
            $this->edificio = $edificio;
        }
    }

    public function getCapacidad() {
        return $this->capacidad;
    }

    public function setCapacidad($capacidad) {
        if (empty($capacidad) || strlen($capacidad)>3) {
            throw new ValidationException('Error de validación. Capacidad incorrecta.');
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
            throw new ValidationException('Error de validación. Despacho indicado de forma incorrecta.');
        }
    }

    public static function expose() {
        return get_class_vars(__CLASS__);
    }
}
