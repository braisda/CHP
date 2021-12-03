<?php

class Grado
{
    private $id;
    private $nombre;
    private $centro;
    private $capacidad;
    private $descripcion;
    private $creditos;
    private $usuario;

    public function __construct($id = NULL, $nombre = NULL, $centro = NULL, $capacidad = NULL, $descripcion = NULL, $creditos = NULL, $usuario = NULL)
    {
        if (!empty($id)) {
            $this->constructEntity($id, $nombre, $centro, $capacidad, $descripcion, $creditos, $usuario);
        }
    }

    public function constructEntity($id = NULL, $nombre = NULL, $centro = NULL, $capacidad = NULL, $descripcion = NULL, $creditos = NULL, $usuario = NULL)
    {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setCentro($centro);
        $this->setCapacidad($capacidad);
        $this->setDescripcion($descripcion);
        $this->setCreditos($creditos);
        $this->setUsuario($usuario);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if (empty($id) || strlen($id) > 8) {
            throw new ValidationException('Error de validación. Id incorrecto.');
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
        if (empty($nombre) || strlen($nombre) > 30) {
            throw new ValidationException('Error de validación. Nombre incorrecto.');
        } else {
            $this->nombre = $nombre;
        }
    }

    public function getCentro()
    {
        return $this->centro;
    }

    public function setCentro($centro)
    {
        if (empty($centro) || strlen($centro) > 8) {
            throw new ValidationException('Error de validación. Id centro incorrecto.');
        } else {
            $this->centro = $centro;
        }
    }

    public function getCapacidad()
    {
        return $this->capacidad;
    }

    public function setCapacidad($capacidad)
    {
        if (empty($capacidad) || strlen($capacidad) > 3) {
            throw new ValidationException('Error de validación. Capacidad incorrecta.');
        } else {
            $this->capacidad = $capacidad;
        }
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        if (empty($descripcion) || strlen($descripcion) > 50) {
            throw new ValidationException('Error de validación. Descripción incorrecta.');
        } else {
            $this->descripcion = $descripcion;
        }
    }

    public function getCreditos()
    {
        return $this->creditos;
    }

    public function setCreditos($creditos)
    {
        if (empty($creditos) || strlen($creditos) > 3) {
            throw new ValidationException('Error de validación. Créditos incorrectos.');
        } else {
            $this->creditos = $creditos;
        }
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setUsuario($usuario)
    {
        if (empty($usuario) || strlen($usuario) > 9) {
            throw new ValidationException('Error de validación. Id usuario incorrecto.');
        } else {
            $this->usuario = $usuario;
        }
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
