<?php
include_once '../models/common/defaultDAO.php';
include_once '../models/user/userDAO.php';
include_once '../models/role/roleDAO.php';
include_once 'userRole.php';

class UserRoleDAO
{
    private $defaultDAO;
    private $userDAO;
    private $roleDAO;

    public function __construct() {
        $this->defaultDAO = new defaultDAO();
        $this->userDAO = new userDAO();
        $this->roleDAO = new RoleDAO();
    }

    function showAll() {
        $userRole_db = $this->defaultDAO->showAll("usuario_rol");
        return $this->getUserRolesFromDB($userRole_db);
    }

    function add($userRole) {
        $this->defaultDAO->insert($userRole,"id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("usuario_rol", $key, $value);
    }

    function show($key, $value) {
        $userRole = $this->defaultDAO->show("usuario_rol", $key, $value);
        $user = $this->userDAO->show("login", $userRole["id_usuario"]);
        $role = $this->roleDAO->show("id", $userRole["id_rol"]);
        return new UserRole($userRole["id"], $role, $user);
    }

    function edit($permission) {
        $this->defaultDAO->edit($permission, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("usuario_rol");
    }

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch) {
        $userRolesDB = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new UserRole(), $stringToSearch);
        return $this->getUserRolesFromDB($userRolesDB);
    }

    function countTotalUserRoles($stringToSearch) {
        return $this->defaultDAO->countTotalEntries(new UserRole(), $stringToSearch);
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("usuario_rol", $value);
    }

    private function getUserRolesFromDB($userRolesDB) {
        $roles = array();

        foreach ($userRolesDB as $userRole) {
            $user = $this->userDAO->show("login", $userRole["idUsuario"]);
            $role = $this->roleDAO->show("id", $userRole["idRol"]);
            array_push($roles, new UserRole($userRole["id"], $role, $user));
        }
        return $roles;
    }
}