<?php
class Permiso
{
    private $id;
    private $rol;
    private $funcAccion;

    public function __construct($id=NULL, $rol=NULL, $funcAccion=NULL){
        $this->id = $id;
        $this->rol = $rol;
        $this->funcAccion = $funcAccion;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if (empty($id) || strlen($id)>8) {
            throw new ValidationException('Error de validación. Id incorrecto.');
        } else {
            $this->id = $id;
        }
    }

    public function getRol()
    {
        return $this->rol;
    }

    public function setRol($rol)
    {
        if (empty($rol) || strlen($rol)>8) {
            throw new ValidationException('Error de validación. Rol incorrecto.');
        } else {
            $this->rol = $rol;
        }
    }

    public function getFuncAccion()
    {
        return $this->funcAccion;
    }

    public function setFuncAccion($funcAccion)
    {
        if (empty($funcAccion) || strlen($funcAccion)>8) {
            throw new ValidationException('Error de validación. Funcionalidad-Acción incorrecta.');
        } else {
            $this->funcAccion = $funcAccion;
        }
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
