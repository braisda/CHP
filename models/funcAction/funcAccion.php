<?php
class Funcaccion
{
    private $id;
    private $accion;
    private $funcionalidad;

    public function __construct($id=NULL, $accion=NULL, $funcionalidad=NULL){
        $this->id = $id;
        $this->accion = $accion;
        $this->funcionalidad = $funcionalidad;
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

    public function getAccion()
    {
        return $this->accion;
    }

    public function setAccion($accion)
    {
        if (empty($accion) || strlen($accion)>8) {
            throw new ValidationException('Error de validación. Acción incorrecta.');
        } else {
            $this->accion = $accion;
        }
    }

    public function getFuncionalidad()
    {
        return $this->funcionalidad;
    }

    public function setFuncionalidad($funcionalidad)
    {
        if (empty($funcionalidad) || strlen($funcionalidad)>8) {
            throw new ValidationException('Error de validación. Funcionalidad incorrecta.');
        } else {
            $this->funcionalidad = $funcionalidad;
        }
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
