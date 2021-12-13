<?php
include_once '../models/common/defaultDAO.php';
include_once '../models/degree/degreeDAO.php';
include_once '../models/department/departmentDAO.php';
include_once '../models/teacher/teacherDAO.php';
include_once '../models/teacher/teacher.php';
include_once 'materia.php';

class SubjectDAO {

    private $defaultDAO;
    private $degreeDAO;
    private $departmentDAO;
    private $teacherDAO;

    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
        $this->degreeDAO = new DegreeDAO();
        $this->departmentDAO = new DepartmentDAO();
        $this->teacherDAO = new TeacherDAO();
    }

    function showAll() {
        $subjects_db = $this->defaultDAO->showAll("materia");
        return $this->getSubjectsFromDB($subjects_db);
    }

    function add($subject) {
        $this->defaultDAO->insert($subject, "id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("materia", $key, $value);
    }

    function show($key, $value) {
        $subject = $this->defaultDAO->show("materia", $key, $value);
        $degree = $this->degreeDAO->show("id", $subject["idgrado"]);
        $department = $this->departmentDAO->show("id", $subject["iddepartamento"]);
        if ($subject["idprofesor"] != NULL) {
            $teacher = $this->teacherDAO->show("id", $subject["idprofesor"]);
        }
        return new Materia($subject["id"], $subject["codigo"], $subject["contenido"], $subject["tipo"], $department,
                        $subject["area"], $subject["curso"], $subject["cuatrimestre"], $subject["creditos"],
                        $subject["nuevoregistro"], $subject["repeticiones"], $subject["estudiantesefectivos"],
                        $subject["horasinscritas"], $subject["horasenseño"], $subject["horas"],
                        $subject["alumnos"], $degree, $teacher, $subject["acronimo"]);
    }

    function edit($subject) {
        $this->defaultDAO->edit($subject, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("materia");
    }

    function showAllPaged($currentPage, $itemsPerPage) {
        $subjects_id = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Materia());
        return $this->getSubjectsFromDB($subjects_id);
    }

    function countTotalSubjects() {
        return $this->defaultDAO->countTotalEntries(new Materia());
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("materia", $value);
    }

    public function getSubjectsFromDB($subjects_db) {
        $subjects = array();
        foreach ($subjects_db as $subject) {
            $degree = $this->degreeDAO->show("id", $subject["idgrado"]);
            $department = $this->departmentDAO->show("id", $subject["iddepartamento"]);
            if ($subject["idprofesor"] != NULL){
                $teacher = $this->teacherDAO->show("id", $subject["idprofesor"]);
            } else {
                $teacher = new Profesor();
            }
            array_push($subjects, new Materia($subject["id"], $subject["codigo"], $subject["contenido"],
                $subject["tipo"], $department, $subject["area"], $subject["curso"], $subject["cuatrimestre"],
                $subject["creditos"], $subject["nuevoregistro"], $subject["repeticiones"], $subject["estudiantesefectivos"],
                $subject["horasinscritas"], $subject["horasenseño"], $subject["horas"], $subject["alumnos"],
                $degree, $teacher, $subject["acronimo"]));
        }
        return $subjects;
    }
}