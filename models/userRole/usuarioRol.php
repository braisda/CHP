<?php
class UsuarioRol
{
    private $id;
    private $rol;
    private $usuario;

    public function __construct($id=NULL, $rol=NULL, $usuario=NULL) {
        $this->id = $id;
        $this->rol = $rol;
        $this->usuario = $usuario;
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

    public function getRol() {
        return $this->rol;
    }

    public function setRol($rol) {
        if (empty($rol) || strlen($rol)>8) {
            throw new ValidationException('Error de validación. Id rol incorrecto.');
        } else {
            $this->rol = $rol;
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
?>