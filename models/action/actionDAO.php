<?php
include_once '../models/common/defaultDAO.php';
include_once 'action.php';

class ActionDAO
{
    private $defaultDAO;
    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
    }

    function showAll() {
        $actions_db = $this->defaultDAO->showAll("accion");
        return $this->getActionsFromDB($actions_db);
    }

    function add($action) {
        $this->defaultDAO->insert($action, "id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("accion", $key, $value);
    }

    function show($key, $value) {
        $action_db = $this->defaultDAO->show("accion", $key, $value);
        return new Accion($action_db["id"], $action_db["nombre"], $action_db["descripcion"]);
    }

    function edit($action) {
        $this->defaultDAO->edit($action, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("accion");
    }

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch) {
        $actionsDB = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Accion(), $stringToSearch);
        return $this->getActionsFromDB($actionsDB);
    }

    function countTotalActions($stringToSearch) {
        return $this->defaultDAO->countTotalEntries(new Accion(), $stringToSearch);
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("accion", $value);
    }

    private function getActionsFromDB($actions_db) {
        $actions = array();
        foreach ($actions_db as $action) {
            array_push($actions, new Accion($action["id"], $action["nombre"], $action["descripcion"]));
        }
        return $actions;
    }
}