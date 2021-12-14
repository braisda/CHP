<?php
include_once '../models/common/defaultDAO.php';
include_once '../models/subject/subjectDAO.php';
include_once 'grupo.php';

class GroupDAO {

    private $defaultDAO;
    private $subjectDAO;

    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
        $this->subjectDAO = new SubjectDAO();
    }

    function showAll() {
        $groups_db = $this->defaultDAO->showAll("grupo_materia");
        return $this->getGroupsFromDB($groups_db);
    }

    function add($group) {
        $this->defaultDAO->insert($group, "id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("grupo_materia", $key, $value);
    }

    function show($key, $value) {
        $group = $this->defaultDAO->show("grupo_materia", $key, $value);
        $subject = $this->subjectDAO->show("id", $group["idmateria"]);
        return new GrupoMateria($group["id"], $group["nombre"], $subject);
    }

    function edit($group) {
        $this->defaultDAO->edit($group, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("grupo_materia");
    }

    function showAllPaged($currentPage, $itemsPerPage) {
        $groups_db = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new GrupoMateria());
        return $this->getGroupsFromDB($groups_db);
    }


    function countTotalGroups() {
        return $this->defaultDAO->countTotalEntries(new GrupoMateria());
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("grupo_materia", $value);
    }

    function search($subject, $name, $capacity, $office) {
        $sql = "SELECT DISTINCT * FROM grupo_materia WHERE nombre LIKE '%".
            $name . "%'AND idmateria LIKE '%" .
            $subject . "%'";
        return $this->defaultDAO->getArrayFromSqlQuery($sql);
    }

    function parseGroups($groupsData){
        $groups = array();
        foreach ($groupsData as $group) {
            $subject = $this->subjectDAO->show("id", $group["idmateria"]);
            array_push($groups, new GrupoMateria($group["id"], $group["nombre"], $subject));
        }
        return $groups;
    }

    private function getGroupsFromDB($groupsDB) {
        $groups = array();
        foreach ($groupsDB as $group) {
            $subject = $this->subjectDAO->show("id", $group["idmateria"]);
            array_push($groups, new GrupoMateria($group["id"], $group["nombre"], $subject));
        }

        return $groups;
    }
}