<?php
class UsuarioRol
{
    private $id;
    private $idrol;
    private $idusuario;

    public function __construct($id=NULL, $idrol=NULL, $idusuario=NULL) {
        $this->id = $id;
        $this->idrol = $idrol;
        $this->idusuario = $idusuario;
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

    public function getIdrol() {
        return $this->idrol;
    }

    public function setIdrol($idrol) {
        if (empty($idrol) || strlen($idrol)>8) {
            throw new Exception('Error de validación. Id rol incorrecto.');
        } else {
            $this->idrol = $idrol;
        }
    }

    public function getIdusuario() {
        return $this->idusuario;
    }

    public function setIdusuario($idusuario) {
        if (empty($idusuario) || strlen($idusuario)>9) {
            throw new Exception('Error de validación. Id usuario incorrecto.');
        } else {
            $this->idusuario = $idusuario;
        }
    }

    public static function expose() {
        return get_class_vars(__CLASS__);
    }
}
?>