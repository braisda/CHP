<?php
include_once '../models/common/defaultDAO.php';
include_once '../models/academicCourse/academicCourseDAO.php';
include_once '../models/user/userDAO.php';
include_once 'universidad.php';

class UniversityDAO
{
    private $defaultDAO;
    private $academicCourseDAO;
    private $userDAO;

    public function __construct()
    {
        $this->defaultDAO = new DefaultDAO();
        $this->academicCourseDAO = new AcademicCourseDAO();
        $this->userDAO = new UserDAO();
    }

    function showAll()
    {
        $university_db = $this->defaultDAO->showAll("universidad");
        return $this->getUniversitiesFromDB($university_db);
    }

    function add($university)
    {
        $this->defaultDAO->insert($university, "id");
    }

    function delete($key, $value)
    {
        $this->defaultDAO->delete("universidad", $key, $value);
    }

    function show($key, $value)
    {
        $university = $this->defaultDAO->show("universidad", $key, $value);
        $academicCourse = $this->academicCourseDAO->show("id", $university["idCursoAcademico"]);
        $user = $this->userDAO->show("login", $university["idUsuario"]);
        return new Universidad($university["id"], $academicCourse, $university["nombre"], $user);
    }

    function edit($university)
    {
        $this->defaultDAO->edit($university, "id");
    }

    function truncateTable()
    {
        $this->defaultDAO->truncateTable("universidad");
    }

    function showAllPaged($currentPage, $itemsPerPage)
    {
        $universitiesDB = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Universidad());
        return $this->getUniversitiesFromDB($universitiesDB);
    }

    function countTotalUniversities()
    {
        return $this->defaultDAO->countTotalEntries(new Universidad());
    }

    function checkDependencies($value)
    {
        $this->defaultDAO->checkDependencies("universidad", $value);
    }

    function search($academiCourse, $name, $user) {
        $sql = "SELECT DISTINCT * FROM universidad WHERE nombre LIKE '%".
            $name . "%'AND idCursoAcademico LIKE '%" .
            $academiCourse . "%' AND idUsuario LIKE '%" .
            $user . "%'";
        return $this->defaultDAO->getArrayFromSqlQuery($sql);
    }

    function parseUniversities($unis){
        $universities = array();
        foreach ($unis as $university) {
            $academicCourse = $this->academicCourseDAO->show("id", $university["idCursoAcademico"]);
            $user = $this->userDAO->show("login", $university["idUsuario"]);
            array_push($universities, new Universidad($university["id"], $academicCourse, $university["nombre"],$user));
        }
        return $universities;
    }

    private function getUniversitiesFromDB($universitiesDB)
    {
        $universities = array();
        foreach ($universitiesDB as $university) {
            $academicCourse = $this->academicCourseDAO->show("id", $university["idCursoAcademico"]);
            $user = $this->userDAO->show("login", $university["idUsuario"]);
            array_push($universities, new Universidad($university["id"], $academicCourse, $university["nombre"],$user));
        }
        return $universities;
    }
}