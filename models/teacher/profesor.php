<?php
class Profesor {

    private $id;
    private $usuario;
    private $dedicacion;
    private $espacio;

    public function __construct($id=NULL, $usuario=NULL, $dedicacion=NULL, $espacio=NULL) {
        if(!empty($id)) {
            $this->constructEntity($id, $usuario, $dedicacion, $espacio);
        }
    }

    public function constructEntity($id=NULL, $usuario=NULL, $dedicacion=NULL, $espacio=NULL) {
        $this->setId($id);
        $this->setUsuario($usuario);
        $this->setDedicacion($dedicacion);
        $this->setEspacio($espacio);
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

    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usuario) {
        if (empty($usuario)) {
            throw new ValidationException('Error de validación. Usuario incorrecto.');
        } else {
            $this->usuario = $usuario;
        }
    }

    public function getDedicacion() {
        return $this->dedicacion;
    }

    public function setDedicacion($dedicacion) {
        if (empty($dedicacion) || strlen($dedicacion) > 4) {
            throw new ValidationException('Error de validación. Dedicación incorrecta.');
        } else {
            $this->dedicacion = $dedicacion;
        }
    }

    public function getEspacio() {
        return $this->espacio;
    }

    public function setEspacio($espacio) {
        $this->espacio = $espacio;
    }

    public static function expose() {
        return get_class_vars(__CLASS__);
    }
}
