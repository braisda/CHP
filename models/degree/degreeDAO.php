<?php
include_once '../models/common/defaultDAO.php';
include_once '../models/center/centerDAO.php';
include_once '../models/user/userDAO.php';
include_once 'grado.php';

class DegreeDAO {

    private $defaultDAO;
    private $centerDAO;
    private $userDAO;

    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
        $this->centerDAO = new CenterDAO();
        $this->userDAO = new UserDAO();
    }

    function showAll() {
        $degrees_db = $this->defaultDAO->showAll("grado");
        return $this->getDegreesFromDB($degrees_db);
    }

    function add($degree) {
        $this->defaultDAO->insert($degree, "id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("grado", $key, $value);
    }

    function show($key, $value) {
        $degree = $this->defaultDAO->show("grado", $key, $value);
        $center = $this->centerDAO->show("id", $degree["idcentro"]);
        $user = $this->userDAO->show("login", $degree["idusuario"]);
        return new Grado($degree["id"], $degree["nombre"], $center, $degree["capacidad"], $degree["descripcion"], $degree["creditos"], $user);
    }

    function edit($degree) {
        $this->defaultDAO->edit($degree, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("grado");
    }

    function showAllPaged($currentPage, $itemsPerPage)  {
        $degrees_db = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Grado());
        return $this->getDegreesFromDB($degrees_db);
    }

    function countTotalDegrees() {
        return $this->defaultDAO->countTotalEntries(new Grado());
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("grado", $value);
    }

    function search($nombre, $idCentro, $capacidad, $creditos, $idUsuario) {
        $sql = "SELECT DISTINCT * FROM grado WHERE nombre LIKE '%" . $nombre . "%'";
        if (!empty($idCentro)) {
            $sql .= " AND idcentro = '" . $idCentro . "'";
        }
        if (!empty($capacidad)) {
            $sql .= " AND capacidad = '" . $capacidad . "'";
        }
        if (!empty($creditos)) {
            $sql .= " AND creditos = '" . $creditos . "'";
        }
        if (!empty($idUsuario)) {
            $sql .= " AND idusuario = '" . $idUsuario . "'";
        }
        return $this->defaultDAO->getArrayFromSqlQuery($sql);
    }

    private function getDegreesFromDB($degreesDB) {
        $degrees = array();
        foreach ($degreesDB as $degree) {
            $center = $this->centerDAO->show("id", $degree["idcentro"]);
            $user = $this->userDAO->show("login", $degree["idusuario"]);
            array_push($degrees, new Grado($degree["id"], $degree["nombre"], $center, $degree["capacidad"], $degree["descripcion"], $degree["creditos"], $user));
        }
        return $degrees;
    }
}