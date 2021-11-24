<?php
include_once '../models/common/defaultDAO.php';
include_once '../models/action/actionDAO.php';
include_once '../models/functionality/functionalityDAO.php';
include_once 'funcAction.php';

class FuncActionDAO
{
    private $defaultDAO;
    private $actionDAO;
    private $functionalityDAO;

    public function __construct() {
        $this->defaultDAO = new defaultDAO();
        $this->actionDAO = new ActionDAO();
        $this->functionalityDAO = new FunctionalityDAO();
    }

    function showAll() {
        $funcActions_db = $this->defaultDAO->showAll("func_accion");
        return $this->getFuncActionFromDB($funcActions_db);
    }

    function add($funcAction) {
        $this->defaultDAO->insert($funcAction,"id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("func_accion", $key, $value);
    }

    function show($key, $value) {
        $funcAction_db = $this->defaultDAO->show("func_accion", $key, $value);
        $action = $this->actionDAO->show("id", $funcAction_db["idAccion"]);
        $functionality = $this->functionalityDAO->show("id", $funcAction_db["idFuncionalidad"]);
        return new FuncAction($funcAction_db["id"], $action, $functionality);
    }

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch) {
        $funcAction_db = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new FuncAction(), $stringToSearch);
        return $this->getFuncActionFromDB($funcAction_db);
    }

    function countTotalFuncActions($stringToSearch) {
        return $this->defaultDAO->countTotalEntries(new FuncAction(), $stringToSearch);
    }

    function edit($funcAction) {
        $this->defaultDAO->edit($funcAction, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("func_accion");
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("func_accion", $value);
    }

    private function getFuncActionFromDB($funcActions_db) {
        $funcActions = array();
        foreach ($funcActions_db as $funcAction) {
            $action = $this->actionDAO->show("id", $funcAction["idAccion"]);
            $functionality = $this->functionalityDAO->show("id", $funcAction["idFuncionalidad"]);
            array_push($funcActions, new FuncAction($funcAction["id"],
                $action, $functionality));
        }
        return $funcActions;
    }
}