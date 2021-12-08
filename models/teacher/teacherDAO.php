<?php
include_once '../models/common/defaultDAO.php';
include_once '../models/space/spaceDAO.php';
include_once '../models/user/userDAO.php';
include_once 'profesor.php';

class TeacherDAO {

    private $defaultDAO;
    private $spaceDAO;
    private $userDAO;

    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
        $this->spaceDAO = new SpaceDAO();
        $this->userDAO = new UserDAO();
    }

    function showAll() {
        $teachers_db = $this->defaultDAO->showAll("profesor");
        return $this->getTeachersFromDB($teachers_db);
    }

    function add($teacher) {
        $this->defaultDAO->insert($teacher, "id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("profesor", $key, $value);
    }

    function show($key, $value) {
        $teacher = $this->defaultDAO->show("profesor", $key, $value);
        $space = NULL;
        if (!empty($teacher["idespacio"])) {
            $space = $this->spaceDAO->show("id", $teacher["idespacio"]);
        }
        $user = $this->userDAO->show("login", $teacher["idusuario"]);
        return new Profesor($teacher["id"], $user, $teacher["dedicacion"], $space);
    }

    function teachersBySpace($spaceId) {
        $totalTeachers = $this->showAll();
        $teachersToReturn = array();
        foreach ($totalTeachers as $teacher) {
            if (!empty($teacher->getEspacio()) && $teacher->getEspacio()->getId() == $spaceId) {
                array_push($teachersToReturn, $teacher);
            }
        }
        return $teachersToReturn;
    }

    function edit($teacher) {
        $this->defaultDAO->edit($teacher, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("profesor");
    }

    function showAllPaged($currentPage, $itemsPerPage) {
        $teachers_db = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Profesor());
        return $this->getTeachersFromDB($teachers_db);
    }

    function countTotalTeachers() {
        return $this->defaultDAO->countTotalEntries(new Profesor());
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("profesor", $value);
    }

    function search($dni, $nombre, $login, $dedicacion) {
        $sql = "SELECT DISTINCT * FROM profesor p LEFT JOIN usuario u ON p.idusuario = u.login WHERE u.dni LIKE '%" . $dni . "%'";
        if (!empty($nombre)) {
            $sql .= " AND u.nombre LIKE '%" . $nombre . "%'";
        }
        if (!empty($login)) {
            $sql .= " AND u.login LIKE '%" . $login . "%'";
        }
        if (!empty($dedicacion)) {
            $sql .= " AND p.dedicacion LIKE '%" . $dedicacion . "%'";
        }
        return $this->defaultDAO->getArrayFromSqlQuery($sql);
    }

    private function getTeachersFromDB($teachers_db) {
        $teachers = array();
        foreach ($teachers_db as $teacher) {
            $space = NULL;
            if (!empty($teacher["idespacio"])) {
                $space = $this->spaceDAO->show("id", $teacher["idespacio"]);
            }
            $user = $this->userDAO->show("login", $teacher["idusuario"]);
            array_push($teachers, new Profesor($teacher["id"], $user, $teacher["dedicacion"], $space));
        }
        return $teachers;
    }
}