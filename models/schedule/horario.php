<?php
class Horario {

    private $id;
    private $espacio;
    private $profesor;
    private $grupomateria;
    private $horainicio;
    private $horafin;
    private $dia;

    public function __construct($id=NULL, $espacio=NULL, $profesor=NULL, $grupomateria=NULL, $horainicio=NULL, $horafin=NULL,
                                $dia=NULL) {
        if(!empty($id)) {
            $this->constructEntity($id, $espacio, $profesor, $grupomateria, $horainicio, $horafin, $dia);
        }
    }

    public function constructEntity($id=NULL, $espacio=NULL, $profesor=NULL, $grupomateria=NULL, $horainicio=NULL, $horafin=NULL,
                                    $dia=NULL) {
        $this->setId($id);
        $this->setEspacio($espacio);
        $this->setProfesor($profesor);
        $this->setGrupoMateria($grupomateria);
        $this->setHoraInicio($horainicio);
        $this->setHoraFin($horafin);
        $this->setDia($dia);
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

    public function getProfesor() {
        return $this->profesor;
    }

    public function setProfesor($profesor) {
        $this->profesor = $profesor;
    }

    public function getGrupoMateria() {
        return $this->grupomateria;
    }

    public function setGrupoMateria($grupomateria) {
        $this->grupomateria = $grupomateria;
    }

    public function getHoraInicio() {
        return $this->horainicio;
    }

    public function setHoraInicio($horainicio) {
        $this->horainicio = $horainicio;
    }

    public function getHoraFin() {
        return $this->horafin;
    }

    public function setHoraFin($horafin) {
        $this->horafin = $horafin;
    }

    public function getDia() {
        return $this->dia;
    }

    public function setDia($dia) {
        $this->dia = $dia;
    }

    public function getEspacio() {
        return $this->espacio;
    }

    public function setEspacio($espacio) {
        $this->espacio = $espacio;
    }

    public static function expose() {
        return get_class_vars(__CLASS__);
    }
}
?>