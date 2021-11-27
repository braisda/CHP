<?php
include_once '../models/common/defaultDAO.php';
include_once 'rol.php';

class RoleDAO
{
    private $defaultDAO;
    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
    }

    function showAll() {
        $roles_db = $this->defaultDAO->showAll("rol");
        return $this->getRolesFromDB($roles_db);
    }

    function add($role) {
        $this->defaultDAO->insert($role, "id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("role", $key, $value);
    }

    function show($key, $value) {
        $role_db = $this->defaultDAO->show("rol", $key, $value);
        return new Rol($role_db["id"], $role_db["nombre"], $role_db["descripcion"]);
    }

    function edit($role) {
        $this->defaultDAO->edit($role, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("rol");
    }

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch) {
        $rolesDB = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Rol(), $stringToSearch);
        return $this->getRolesFromDB($rolesDB);
    }

    function countTotalRoles($stringToSearch) {
        return $this->defaultDAO->countTotalEntries(new Rol(), $stringToSearch);
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("rol", $value);
    }

    private function getRolesFromDB($roles_db) {
        $roles = array();
        foreach ($roles_db as $role) {
            array_push($roles, new Rol($role["id"], $role["nombre"], $role["descripcion"]));
        }
        return $roles;
    }
}