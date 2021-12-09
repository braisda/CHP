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

    function search($user, $code, $name) {
        $sql = "SELECT DISTINCT * FROM departamento WHERE nombre LIKE '%".
            $name . "%'AND idprofesor LIKE '%" .
            $user . "%' AND codigo LIKE '%" .
            $code . "%'";
            //print_r($this->defaultDAO->getArrayFromSqlQuery($sql));
        return $this->defaultDAO->getArrayFromSqlQuery($sql);
    }

    function parseDepartments($deps){
        $departments = array();
        foreach ($deps as $department) {
            $teacher = $this->teacherDAO->show("id", $department->getIdprofesor()->getId());
            array_push($departments, new Departamento($department->getId(), $department->getCodigo(), $department->getNombre(), $teacher));
        }
        return $departments;
    }

    private function getDepartmentsFromDB($departments_db) {
        $departments = array();
        foreach ($departments_db as $department) {
            print_r($department);
            $teacher = $this->teacherDAO->show("id", $department["idprofesor"]);
            array_push($departments, new Departamento($department["id"], $department["codigo"], $department["nombre"], $teacher));
        }
        return $departments;
    }
}