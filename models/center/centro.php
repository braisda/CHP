<?php
class Centro
{
    private $id;
    private $universidad;
    private $nombre;
    private $edificio;
    private $usuario;

    public function __construct($id=NULL, $universidad=NULL, $nombre=NULL, $edificio=NULL, $usuario=NULL){
        if(!empty($id)) {
            $this->constructEntity($id, $universidad, $nombre, $edificio, $usuario);
        }
    }

    public function constructEntity($id=NULL, $universidad=NULL, $nombre=NULL, $edificio=NULL, $usuario=NULL) {
        $this->setId($id);
        $this->setUniversidad($universidad);
        $this->setNombre($nombre);
        $this->setEdificio($edificio);
        $this->setUsuario($usuario);
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

    public function getUniversidad() {
        return $this->universidad;
    }

    public function setUniversidad($universidad) {
        if (empty($universidad) || strlen($universidad)>8) {
            throw new ValidationException('Error de validación. Id universidad incorrecto.');
        } else {
            $this->universidad = $universidad;
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

    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usuario) {
        if (empty($usuario) || strlen($usuario)>9) {
            throw new ValidationException('Error de validación. Id usuario incorrecto.');
        } else {
            $this->usuario = $usuario;
        }
    }

    public static function expose() {
        return get_class_vars(__CLASS__);
    }
}
