<?php
include_once '../models/common/defaultDAO.php';
include_once '../models/user/userDAO.php';
include_once 'edificio.php';

class BuildingDAO
{
    private $defaultDAO;
    private $userDAO;

    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
        $this->userDAO = new UserDAO();
    }

    function showAll() {
        $buildings_db = $this->defaultDAO->showAll("edificio");
        return $this->getBuildingFromDB($buildings_db);
    }

    function add($building) {
        $this->defaultDAO->insert($building,"id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("edificio", $key, $value);
    }

    function show($key, $value) {
        $building = $this->defaultDAO->show("edificio", $key, $value);
        $user = $this->userDAO->show("login", $building["idusuario"]);
        return new Edificio($building["id"],$building["nombre"], $building["localizacion"],$user);
    }

    function edit($building) {
        $this->defaultDAO->edit($building, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("edificio");
    }

    function showAllPaged($currentPage, $itemsPerPage) {
        $buildings_db = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Edificio());
        return $this->getBuildingFromDB($buildings_db);
    }

    function countTotalBuildings() {
        return $this->defaultDAO->countTotalEntries(new Edificio());
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("edificio", $value);
    }

    function search($user, $location, $name) {
        $sql = "SELECT DISTINCT * FROM edificio WHERE nombre LIKE '%".
            $name . "%'AND localizacion LIKE '%" .
            $location . "%' AND idusuario LIKE '%" .
            $user . "%'";
        return $this->defaultDAO->getArrayFromSqlQuery($sql);
    }

    function parseBuildings($buildingsData){
        $buildings = array();
        foreach ($buildingsData as $building) {
            $user = $this->userDAO->show("login", $building["idusuario"]);
            array_push($buildings, new Edificio($building["id"], $building["nombre"], $building["localizacion"],$user));
        }
        return $buildings;
    }

    private function getBuildingFromDB($buildingsDB) {
        $buildings = array();
        foreach ($buildingsDB as $building) {
            $user = $this->userDAO->show("login", $building["idusuario"]);
            array_push($buildings, new Edificio($building["id"], $building["nombre"], $building["localizacion"],$user));
        }
        return $buildings;
    }
}