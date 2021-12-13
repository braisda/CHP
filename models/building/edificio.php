<?php
class Edificio
{
    private $id;
    private $nombre;
    private $localizacion;
    private $idusuario;

    public function __construct($id=NULL, $nombre=NULL, $localizacion=NULL, $idusuario=NULL){
        if(!empty($id)) {
            $this->constructEntity($id, $nombre, $localizacion, $idusuario);
        }
    }

    public function constructEntity($id=NULL,$nombre=NULL, $localizacion=NULL, $idusuario=NULL) {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setLocalizacion($localizacion);
        $this->setIdusuario($idusuario);
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

    public function getIdusuario()
    {
        return $this->idusuario;
    }

    public function setIdusuario($idusuario)
    {
        if (empty($idusuario) || strlen($idusuario)>9) {
            throw new Exception('Error de validación. Usuario incorrecto.');
        } else {
            $this->idusuario = $idusuario;
        }
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        if (empty($nombre) || strlen($nombre)>30) {
            throw new Exception('Error de validación. Nombre incorrecto.');
        } else {
            $this->nombre = $nombre;
        }
    }

    public function getLocalizacion()
    {
        return $this->localizacion;
    }

    public function setLocalizacion($localizacion)
    {
        if (empty($localizacion) || strlen($localizacion)>30) {
            throw new Exception('Error de validación. Localización incorrecta.');
        } else {
            $this->localizacion = $localizacion;
        }
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
