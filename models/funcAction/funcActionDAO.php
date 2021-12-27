<?php
include_once '../models/common/defaultDAO.php';
include_once '../models/action/actionDAO.php';
include_once '../models/functionality/functionalityDAO.php';
include_once 'funcAccion.php';

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
        $funcActions_db = $this->defaultDAO->showAll("funcaccion");
        return $this->getFuncActionFromDB($funcActions_db);
    }

    function add($funcAction) {
        $this->defaultDAO->insert($funcAction,"id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("funcaccion", $key, $value);
    }

    function show($key, $value) {
        $funcAction_db = $this->defaultDAO->show("funcaccion", $key, $value);
        $action = $this->actionDAO->show("id", $funcAction_db["idaccion"]);
        $functionality = $this->functionalityDAO->show("id", $funcAction_db["idfuncionalidad"]);
        return new Funcaccion($funcAction_db["id"], $action, $functionality);
    }

    function showAllPaged($currentPage, $itemsPerPage) {
        $funcAction_db = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Funcaccion());
        return $this->getFuncActionFromDB($funcAction_db);
    }

    function countTotalFuncActions() {
        return $this->defaultDAO->countTotalEntries(new Funcaccion());
    }

    function edit($funcAction) {
        $this->defaultDAO->edit($funcAction, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("funcaccion");
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("funcaccion", $value);
    }

    function search($action, $functionality) {
            $sql = "SELECT DISTINCT * FROM funcaccion";
            if (!empty($action)) {
                $sql .= " WHERE idaccion = '" . $action . "'";
            }
            if (!empty($action) && !empty($functionality)) {
                $sql .= " AND idfuncionalidad = '" . $functionality . "'";
            } else if (!empty($functionality)) {
                $sql .= " WHERE idfuncionalidad = '" . $functionality . "'";
            }
            return $this->defaultDAO->getArrayFromSqlQuery($sql);
        }

    private function getFuncActionFromDB($funcActions_db) {
        $funcActions = array();
        foreach ($funcActions_db as $funcAction) {
            $action = $this->actionDAO->show("id", $funcAction["idaccion"]);
            $functionality = $this->functionalityDAO->show("id", $funcAction["idfuncionalidad"]);
            array_push($funcActions, new Funcaccion($funcAction["id"],
                $action, $functionality));
        }
        return $funcActions;
    }
}