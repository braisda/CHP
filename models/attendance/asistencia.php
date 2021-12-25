<?php
class Asistencia {

    private $id;
    private $materia;
    private $numalumnos;
    private $asiste;
    private $horario;

    public function __construct($id=NULL, $materia=NULL, $numalumnos=NULL, $asiste=NULL, $horario=NULL) {
        if (!empty($id)) {
            $this->constructEntity($id, $materia, $numalumnos, $asiste, $horario);
        }
    }

    public function constructEntity($id=NULL, $materia=NULL, $numalumnos=NULL, $asiste=NULL, $horario=NULL) {
        $this->setId($id);
        $this->setMateria($materia);
        $this->setNumAlumnos($numalumnos);
        $this->setAsiste($asiste);
        $this->setHorario($horario);
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

    public function getMateria() {
        return $this->materia;
    }

    public function setMateria($materia) {
        $this->materia = $materia;
    }

    public function getNumAlumnos() {
        return $this->numalumnos;
    }

    public function setNumAlumnos($numalumnos) {
        $this->numalumnos = $numalumnos;
    }

    public function getAsiste() {
        return $this->asiste;
    }

    public function setAsiste($asiste) {
        $this->asiste = $asiste;
    }

    public function getHorario() {
        return $this->horario;
    }

    public function setHorario($horario) {
        $this->horario = $horario;
    }

    public static function expose() {
        return get_class_vars(__CLASS__);
    }
}
?>