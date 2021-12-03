<?php
include_once '../models/common/defaultDAO.php';
include_once 'funcionalidad.php';

class FunctionalityDAO
{
    private $defaultDAO;
    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
    }

    function showAll() {
        $functionalities_db = $this->defaultDAO->showAll("funcionalidad");
        return $this->getFunctionalitiesFromDB($functionalities_db);
    }

    function add($functionality) {
        $this->defaultDAO->insert($functionality, "id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("funcionalidad", $key, $value);
    }

    function show($key, $value) {
        $functionality_db = $this->defaultDAO->show("funcionalidad", $key, $value);
        return new Funcionalidad($functionality_db["id"], $functionality_db["nombre"], $functionality_db["descripcion"]);
    }

    function edit($functionality) {
        $this->defaultDAO->edit($functionality, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("funcionalidad");
    }

    function showAllPaged($currentPage, $itemsPerPage) {
        $functionalitiesDB = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Funcionalidad());
        return $this->getFunctionalitiesFromDB($functionalitiesDB);
    }

    function countTotalFunctionalities() {
        return $this->defaultDAO->countTotalEntries(new Funcionalidad());
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("funcionalidad", $value);
    }

    function search($name, $description) {
        $sql = "SELECT DISTINCT * FROM funcionalidad WHERE nombre LIKE '%".
            $name . "%' AND descripcion LIKE '%" .
            $description . "%'";
        return $this->defaultDAO->getArrayFromSqlQuery($sql);
    }

    private function getFunctionalitiesFromDB($functionalities_db) {
        $functionalities = array();
        foreach ($functionalities_db as $functionality) {
            array_push($functionalities, new Funcionalidad($functionality["id"],
                $functionality["nombre"], $functionality["descripcion"]));
        }
        return $functionalities;
    }
}