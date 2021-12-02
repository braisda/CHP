<?php
class Universidad
{
    private $id;
    private $idCursoAcademico;
    private $nombre;
    private $idUsuario;

    public function __construct($id=NULL, $idCursoAcademico=NULL, $nombre=NULL, $idUsuario=NULL){
        if(!empty($id)) {
            $this->constructEntity($id, $idCursoAcademico, $nombre, $idUsuario);
        }
    }

    public function constructEntity($id=NULL, $idCursoAcademico=NULL, $nombre=NULL, $idUsuario=NULL) {
        $this->setId($id);
        $this->setIdCursoAcademico($idCursoAcademico);
        $this->setNombre($nombre);
        $this->setIdUsuario($idUsuario);
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

    public function getIdCursoAcademico()
    {
        return $this->idCursoAcademico;
    }

    public function setIdCursoAcademico($idCursoAcademico)
    {
        if (empty($idCursoAcademico) || strlen($idCursoAcademico)>8) {
            throw new Exception('Error de validación. Id curso académico incorrecto.');
        } else {
            $this->idCursoAcademico = $idCursoAcademico;
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

    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario)
    {
        if (empty($idUsuario) || strlen($idUsuario)>9) {
            throw new Exception('Error de validación. Id usuario incorrecto.');
        } else {
            $this->idUsuario = $idUsuario;
        }
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
