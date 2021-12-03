<?php
include_once '../models/common/defaultDAO.php';
include_once '../models/university/universityDAO.php';
include_once '../models/building/buildingDAO.php';
include_once '../models/user/userDAO.php';
include_once 'centro.php';

class CenterDAO
{
    private $defaultDAO;
    private $universityDAO;
    private $userDAO;
    private $buildingDAO;

    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
        $this->universityDAO = new UniversityDAO();
        $this->userDAO = new UserDAO();
        $this->buildingDAO = new BuildingDAO();
    }

    function showAll() {
        $centers_db = $this->defaultDAO->showAll("centro");
        return $this->getCentersFromDB($centers_db);
    }

    function add($center) {
        $this->defaultDAO->insert($center,"id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("centro", $key, $value);
    }

    function show($key, $value) {
        $center = $this->defaultDAO->show("centro", $key, $value);
        $university = $this->universityDAO->show("id", $center["idUniversidad"]);
        $user = $this->userDAO->show("login", $center["idUsuario"]);
        $building = $this->buildingDAO->show("id", $center["idEdificio"]);
        return new Centro($center["id"], $university, $center["nombre"], $building, $user);
    }

    function edit($center) {
        $this->defaultDAO->edit($center, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("centro");
    }

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch) {
        $centers_db = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Centro(), $stringToSearch);
        return $this->getCentersFromDB($centers_db);
    }

    function countTotalCenters() {
        return $this->defaultDAO->countTotalEntries(new Centro(), NULL);
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("centro", $value);
    }

    function search($nombre, $idUniversidad, $idEdificio, $idUsuario) {
        $sql = "SELECT DISTINCT * FROM centro WHERE nombre LIKE '%" . $nombre . "%'";
        if (!empty($idUniversidad)) {
            $sql .= " AND idUniversidad = '" . $idUniversidad . "'";
        }
        if (!empty($idEdificio)) {
            $sql .= " AND idEdificio = '" . $idEdificio . "'";
        }
        if (!empty($idUsuario)) {
            $sql .= " AND idUsuario = '" . $idUsuario . "'";
        }
        return $this->defaultDAO->getArrayFromSqlQuery($sql);
    }

    private function getCentersFromDB($centersDB) {
        $centers = array();
        foreach ($centersDB as $center) {
            $university = $this->universityDAO->show("id", $center["idUniversidad"]);
            $user = $this->userDAO->show("login", $center["idUsuario"]);
            $building = $this->buildingDAO->show("id", $center["idEdificio"]);
            array_push($centers, new Centro($center["id"], $university, $center["nombre"], $building, $user));
        }
        return $centers;
    }
}