<?php
class Materia_profesor {

    private $id;
    private $profesor;
    private $materia;
    private $horas;

    public function __construct($id=NULL, $profesor=NULL, $materia=NULL, $horas=NULL){
        if(!empty($id)) {
            $this->constructEntity($id, $profesor, $materia, $horas);
        }
    }

    public function constructEntity($id=NULL, $profesor=NULL, $materia=NULL, $horas=NULL) {
        $this->setId($id);
        $this->setProfesor($profesor);
        $this->setMateria($materia);
        $this->setHoras($horas);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        if (empty($id) || strlen($id) > 8) {
            throw new ValidationException('Error de validación. Id incorrecto.');
        } else {
            $this->id = $id;
        }
    }

    public function getProfesor() {
        return $this->profesor;
    }

    public function setProfesor($profesor) {
        if (empty($profesor)) {
            throw new ValidationException('Error de validación. Profesor incorrecto.');
        } else {
            $this->profesor = $profesor;
        }
    }

    public function getMateria() {
        return $this->materia;
    }

    public function setMateria($materia) {
        if (empty($materia)) {
            throw new ValidationException('Error de validación. Materia incorrecta.');
        } else {
            $this->materia = $materia;
        }
    }

    public function getHoras() {
        return $this->horas;
    }

    public function setHoras($horas) {
        if (empty($horas) || strlen($horas)>2) {
            if($horas==0){
                $this->horas = $horas;
            }else{
                throw new ValidationException('Error de validación. Horas incorrectas.');
            }
        } else {
            $this->horas = $horas;
        }
    }

    public static function expose() {
        return get_class_vars(__CLASS__);
    }
}
