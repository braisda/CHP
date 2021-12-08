<?php
include_once '../models/common/defaultDAO.php';
include_once '../models/building/buildingDAO.php';
include_once '../models/teacher/teacherDAO.php';
include_once 'espacio.php';

class SpaceDAO {

    private $defaultDAO;
    private $buildingDAO;
    private $teacherDAO;

    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
        $this->buildingDAO = new BuildingDAO();
    }

    function showAll() {
        $spaces_db = $this->defaultDAO->showAll("espacio");
        return $this->getSpacesFromDB($spaces_db);
    }

    function add($space) {
        $this->defaultDAO->insert($space, "id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("espacio", $key, $value);
    }

    function show($key, $value) {
        $space = $this->defaultDAO->show("espacio", $key, $value);
        $building = $this->buildingDAO->show("id", $space["idedificio"]);
        return new Espacio($space["id"], $space["nombre"], $building, $space["capacidad"], $space["oficina"]);
    }

    function edit($space) {
        $this->defaultDAO->edit($space, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("espacio");
    }

    function showAllPaged($currentPage, $itemsPerPage) {
        $spaces_db = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Espacio());
        return $this->getSpacesFromDB($spaces_db);
    }

    function showAllOffices() {
        $spaces = $this->showAll();
        $spacesToReturn = array();
        foreach ($spaces as $space) {
            if ($space->isOffice()) {
                array_push($spacesToReturn, $space);
            }
        }
        return $spacesToReturn;
    }

    function showAllFreeOffices() {
        $this->teacherDAO = new TeacherDAO();
        $totalSpaces = $this->showAllOffices();
        $spacesToReturn = array();
        foreach ($totalSpaces as $space) {
            $teachersAssigned = count($this->teacherDAO->teachersBySpace($space->getId()));
            if($teachersAssigned < $space->getCapacidad()) {
                array_push($spacesToReturn, $space);
            }
        }

        return $spacesToReturn;
    }

    function countTotalSpaces() {
        return $this->defaultDAO->countTotalEntries(new Espacio());
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("espacio", $value);
    }

    private function getSpacesFromDB($spacesDB) {
        $spaces = array();
        foreach ($spacesDB as $space) {
            $building = $this->buildingDAO->show("id", $space["idedificio"]);
            array_push($spaces, new Espacio($space["id"], $space["nombre"], $building, $space["capacidad"], $space["oficina"]));
        }

        return $spaces;
    }
}