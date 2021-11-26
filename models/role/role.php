<?php
class Rol
{
    private $id;
    private $nombre;
    private $descripcion;

    public function __construct($id=NULL, $nombre=NULL, $descripcion=NULL){
        if (!empty($nombre) && !empty($descripcion)) {
            $this->constructEntity($id, $nombre, $descripcion);
        }
    }

    private function constructEntity($id=NULL, $nombre=NULL, $descripcion=NULL){
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setDescripcion($descripcion);
    }
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if (empty($id) || strlen($id)>8) {
            throw new Exception('Error de validación. Id incorrecto.');
        } else {
            $this->id = $id;
        }
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        if(strlen($nombre)>60 || empty($nombre)){
            throw new Exception('Error de validación. Nombre incorrecto.');
        }else{
            $this->nombre = $nombre;
        }
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        if(strlen($descripcion)>100 || empty($descripcion)){
            throw new Exception('Error de validación. Descripción incorrecta.');
        }else{
            $this->descripcion = $descripcion;
        }
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
