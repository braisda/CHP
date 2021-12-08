<?php
include_once '../models/common/defaultDAO.php';
include_once '../models/teacher/teacherDAO.php';
include_once 'departamento.php';

class DepartmentDAO {

    private $defaultDAO;
    private $teacherDAO;

    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
        $this->teacherDAO = new TeacherDAO();
    }

    function showAll() {
        $departments_db = $this->defaultDAO->showAll("departamento");
        return $this->getDepartmentsFromDB($departments_db);
    }

    function add($department) {
        $this->defaultDAO->insert($department, "id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("departamento", $key, $value);
    }

    function show($key, $value) {
        $department = $this->defaultDAO->show("departamento", $key, $value);
        $teacher = $this->teacherDAO->show("id", $department["idprofesor"]);
        return new Departamento($department["id"], $department["codigo"], $department["nombre"], $teacher);
    }

    function edit($department) {
        $this->defaultDAO->edit($department, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("departamento");
    }

    function showAllPaged($currentPage, $itemsPerPage) {
        $departments_db = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Departamento());
        return $this->getDepartmentsFromDB($departments_db);
    }

    function countTotalDepartments() {
        return $this->defaultDAO->countTotalEntries(new Departamento());
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("departamento", $value);
    }

    private function getDepartmentsFromDB($departments_db) {
        $departments = array();
        foreach ($departments_db as $department) {
            $teacher = $this->teacherDAO->show("id", $department["idprofesor"]);
            array_push($departments, new Departamento($department["id"], $department["codigo"], $department["nombre"], $teacher));
        }
        return $departments;
    }
}