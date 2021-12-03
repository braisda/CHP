<?php
include_once '../models/common/DefaultDAO.php';
include_once 'cursoAcademico.php';

class AcademicCourseDAO
{
    private $defaultDAO;
    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
    }

    function showAll() {
        $academicCourses_db = $this->defaultDAO->showAll("curso_academico");
        return $this->getAcademicCoursesFromDB($academicCourses_db);
    }

    function add($academicCourse) {
        $this->defaultDAO->insert($academicCourse, "id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("curso_academico", $key, $value);
    }

    function show($key, $value) {
        $academicCourse_db = $this->defaultDAO->show("curso_academico", $key, $value);
        return new CursoAcademico($academicCourse_db["id"], $academicCourse_db["nombre"],
            $academicCourse_db["anoInicio"], $academicCourse_db["anoFin"]);
    }

    function edit($academicCourse) {
        $this->defaultDAO->edit($academicCourse, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("curso_academico");
    }

    function showAllPaged($currentPage, $itemsPerPage) {
        $academicCoursesDB = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage,
            new CursoAcademico());
        return $this->getAcademicCoursesFromDB($academicCoursesDB);
    }

    function countTotalAcademicCourses() {
        return $this->defaultDAO->countTotalEntries(new CursoAcademico());
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("curso_academico", $value);
    }

    function search($nombre, $anoInicio, $anoFin) {
        $sql = "SELECT DISTINCT * FROM curso_academico WHERE nombre LIKE '%".
            $nombre . "%'";
        if (!empty($anoInicio)) {
            $sql .= " AND anoInicio = '" . $anoInicio . "'";
        }
        if (!empty($anoFin)) {
            $sql .= " AND anoFin = '" . $anoFin . "'";
        }
        return $this->defaultDAO->getArrayFromSqlQuery($sql);
    }

    private function getAcademicCoursesFromDB($academicCourses_db) {
        $academicCourses = array();
        foreach ($academicCourses_db as $academicCourse) {
            array_push($academicCourses, new CursoAcademico($academicCourse["id"],
                $academicCourse["nombre"], $academicCourse["anoInicio"], $academicCourse["anoFin"]));
        }
        return $academicCourses;
    }
}
