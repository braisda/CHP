<?php
include_once '../models/common/defaultDAO.php';
include_once '../models/teacher/teacherDAO.php';
include_once 'tutoria.php';

class TutorialDAO
{
    private $defaultDAO;
    private $teacherDAO;

    public function __construct()
    {
        $this->defaultDAO = new DefaultDAO();
        $this->teacherDAO = new TeacherDAO();
    }

    function showAll()
    {
        $tutorial_db = $this->defaultDAO->showAll("tutoria");
        return $this->getTutorialsFromDB($tutorial_db);
    }

    function add($tutorial)
    {
        $this->defaultDAO->insert($tutorial, "idtutoria");
    }

    function delete($key, $value)
    {
        $this->defaultDAO->delete("tutoria", $key, $value);
    }

    function show($key, $value)
    {
        $tutorial = $this->defaultDAO->show("tutoria", $key, $value);
        $teacher = $this->teacherDAO->show("id", $tutorial["idprofesor"]);
        return new Tutoria($tutorial["idtutoria"], $teacher, $tutorial["fechainicio"], $tutorial["fechafin"]);
    }

    function edit($tutorial)
    {
        $this->defaultDAO->edit($tutorial, "idtutoria");
    }

    function truncateTable()
    {
        $this->defaultDAO->truncateTable("tutoria");
    }

    function showAllPaged($currentPage, $itemsPerPage)
    {
        $tutorialsDB = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Tutoria());
        return $this->getTutorialsFromDB($tutorialsDB);
    }

    function countTotalTutorials()
    {
        return $this->defaultDAO->countTotalEntries(new Tutoria());
    }

    function checkDependencies($value)
    {
        $this->defaultDAO->checkDependencies("tutoria", $value);
    }

    function search($idTeacher, $startDate, $endDate) {
        //TODO comprobar fechas
        $sql = "SELECT DISTINCT * FROM tutoria WHERE idprofesor LIKE '%".
        $idTeacher . "%'AND fechainicio LIKE '%" .
        $startDate . "%' AND fechafin LIKE '%" .
        $endDate . "%'";
        return $this->defaultDAO->getArrayFromSqlQuery($sql);
    }

    function parseTutorials($tutorialsData){
        $tutorials = array();
        foreach ($tutorialsData as $tutorial) {
            $teacher = $this->teacherDAO->show("id", $tutorial["idprofesor"]);
            array_push($tutorials, new Tutoria($tutorial["idtutoria"], $teacher, $tutorial["fechainicio"],$tutorial["fechafin"]));
        }
        return $tutorials;
    }

    private function getTutorialsFromDB($tutorialsDB)
    {
        $tutorials = array();
        foreach ($tutorialsDB as $tutorial) {
            $teacher = $this->teacherDAO->show("id", $tutorial["idprofesor"]);
            $t = new Tutoria($tutorial["idtutoria"], $teacher, $tutorial["fechainicio"],$tutorial["fechafin"]);
            array_push($tutorials, new Tutoria($tutorial["idtutoria"], $teacher, $tutorial["fechainicio"],$tutorial["fechafin"]));
        }
        return $tutorials;
    }
}