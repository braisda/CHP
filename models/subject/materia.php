<?php
class Materia {

    private $id;
    private $codigo;
    private $contenido;
    private $tipo;
    private $departamento;
    private $area;
    private $curso;
    private $cuatrimestre;
    private $creditos;
    private $nuevoregistro;
    private $repeticiones;
    private $estudiantesefectivos;
    private $horasinscritas;
    private $horasenseño;
    private $horas;
    private $alumnos;
    private $grado;
    private $profesor;
    private $acronimo;

    public function __construct($id = NULL, $codigo = NULL, $contenido = NULL, $tipo = NULL, $departamento = NULL, $area = NULL, $curso = NULL,
                                $cuatrimestre = NULL, $creditos = NULL, $nuevoregistro = NULL, $repeticiones = NULL, $estudiantesefectivos = NULL, $horasinscritas = NULL,
                                $horasenseño = NULL, $horas = NULL, $alumnos = NULL, $grado = NULL, $profesor = NULL, $acronimo = NULL) {
        if (!empty($id)) {
            $this->constructEntity($id, $codigo, $contenido, $tipo, $departamento, $area, $curso, $cuatrimestre, $creditos,
                $nuevoregistro, $repeticiones, $estudiantesefectivos, $horasinscritas, $horasenseño,
                $horas, $alumnos, $grado, $profesor, $acronimo);
        }
    }

    public function constructEntity($id = NULL, $codigo = NULL, $contenido = NULL, $tipo = NULL, $departamento = NULL, $area = NULL, $curso = NULL,
                                    $cuatrimestre = NULL, $creditos = NULL, $nuevoregistro = NULL, $repeticiones = NULL, $estudiantesefectivos = NULL, $horasinscritas = NULL,
                                    $horasenseño = NULL, $horas = NULL, $alumnos = NULL, $grado = NULL, $profesor = NULL, $acronimo = NULL) {

        $this->setId($id);
        $this->setCodigo($codigo);
        $this->setContenido($contenido);
        $this->setTipo($tipo);
        $this->setDepartamento($departamento);
        $this->setArea($area);
        $this->setCurso($curso);
        $this->setCuatrimestre($cuatrimestre);
        $this->setCreditos($creditos);
        $this->setNuevoRegistro($nuevoregistro);
        $this->setRepeticiones($repeticiones);
        $this->setEstudiantesEfectivos($estudiantesefectivos);
        $this->setHorasInscritas($horasinscritas);
        $this->setHorasEnseño($horasenseño);
        $this->setHoras($horas);
        $this->setAlumnos($alumnos);
        $this->setGrado($grado);
        $this->setProfesor($profesor);
        $this->setAcronimo($acronimo, NULL);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function getContenido() {
        return $this->contenido;
    }

    public function setContenido($contenido) {
        $this->contenido = $contenido;
        $this->setAcronym(NULL, $contenido);
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getDepartamento() {
        return $this->departamento;
    }

    public function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }

    public function getArea() {
        return $this->area;
    }

    public function setArea($area) {
        $this->area = $area;
    }

    public function getCurso() {
        return $this->curso;
    }

    public function setCurso($curso) {
        $this->curso = $curso;
    }

    public function getCuatrimestre() {
        return $this->cuatrimestre;
    }

    public function setCuatrimestre($cuatrimestre) {
        $this->cuatrimestre = $cuatrimestre;
    }

    public function getCreditos() {
        return $this->creditos;
    }

    public function setCreditos($creditos) {
        $this->creditos = $creditos;
    }

    public function getNuevoRegistro() {
        return $this->nuevoregistro;
    }

    public function setNuevoRegistro($nuevoregistro) {
        $this->nuevoregistro = $nuevoregistro;
    }

    public function getRepeticiones() {
        return $this->repeticiones;
    }

    public function setRepeticiones($repeticiones) {
        $this->repeticiones = $repeticiones;
    }

    public function getEstudiantesEfectivos() {
        return $this->estudiantesefectivos;
    }

    public function setEstudiantesEfectivos($estudiantesefectivos) {
        $this->estudiantesefectivos = $estudiantesefectivos;
    }

    public function getHorasInscritas() {
        return $this->horasinscritas;
    }

    public function setHorasInscritas($horasinscritas) {
        $this->horasinscritas = $horasinscritas;
    }

    public function getHorasEnseño() {
        return $this->horasenseño;
    }

    public function setHorasEnseño($horasenseño) {
        $this->horasenseño = $horasenseño;
    }

    public function getHoras() {
        return $this->horas;
    }

    public function setHoras($horas) {
        $this->horas = $horas;
    }

    public function getAlumnos() {
        return $this->alumnos;
    }

    public function setAlumnos($alumnos) {
        $this->alumnos = $alumnos;
    }

    public function getGrado() {
        return $this->grado;
    }

    public function setGrado($grado) {
        $this->grado = $grado;
    }

    public function getProfesor() {
        return $this->profesor;
    }

    public function setProfesor($profesor) {
        if ($profesor == NULL) {
            $this->profesor = new Profesor();
        } else {
            $this->profesor = $profesor;
        }
    }

    public function getAcronimo() {
        return $this->acronimo;
    }

    public function setAcronimo($acronimo, $nombreMateria) {
        if($acronimo !== NULL) {
            $this->acronimo = $acronimo;
        } else {
            $this->acronimo = $this->acronimo($nombreMateria);
        }
    }

    private function acronimo($longName) {
       $letters=array();
        $words=explode(' ', $longName);
        foreach($words as $word)
        {
            if(strlen($word) > 2 && $word !== "del") {
                $word = (substr($word, 0, 1));
                array_push($letters, $word);
            }
        }
        $shortName = strtoupper(implode($letters));
        return $shortName;
    }

    public static function expose() {
        return get_class_vars(__CLASS__);
    }
}
?>