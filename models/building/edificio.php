<?php
class Edificio
{
    private $id;
    private $nombre;
    private $localizacion;
    private $usuario;

    public function __construct($id=NULL, $nombre=NULL, $localizacion=NULL, $usuario=NULL){
        if(!empty($id)) {
            $this->constructEntity($id, $nombre, $localizacion, $usuario);
        }
    }

    public function constructEntity($id=NULL,$nombre=NULL, $localizacion=NULL, $usuario=NULL) {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setLocalizacion($localizacion);
        $this->setUsuario($usuario);
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

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setUsuario($usuario)
    {
        if (empty($usuario) || strlen($usuario)>9) {
            throw new ValidationException('Error de validación. Usuario incorrecto.');
        } else {
            $this->usuario = $usuario;
        }
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        if (empty($nombre) || strlen($nombre)>30) {
            throw new ValidationException('Error de validación. Nombre incorrecto.');
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
            throw new ValidationException('Error de validación. Localización incorrecta.');
        } else {
            $this->localizacion = $localizacion;
        }
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
