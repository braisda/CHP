<?php
include_once '../models/common/defaultDAO.php';
include_once '../models/user/userDAO.php';
include_once '../models/role/roleDAO.php';
include_once 'usuarioRol.php';

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
        $user = $this->userDAO->show("login", $userRole["idusuario"]);
        $role = $this->roleDAO->show("id", $userRole["idrol"]);
        return new UsuarioRol($userRole["id"], $role, $user);
    }

    function edit($permission) {
        $this->defaultDAO->edit($permission, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("usuario_rol");
    }

    function showAllPaged($currentPage, $itemsPerPage) {
        $userRolesDB = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new UsuarioRol());
        return $this->getUserRolesFromDB($userRolesDB);
    }

    function countTotalUserRoles() {
        return $this->defaultDAO->countTotalEntries(new UsuarioRol());
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("usuario_rol", $value);
    }

    function search($usuario, $rol) {
        $sql = "SELECT DISTINCT * FROM usuario_rol WHERE idusuario LIKE '%".
            $usuario . "%' AND idrol LIKE '%" .
            $rol . "%'";
        return $this->defaultDAO->getArrayFromSqlQuery($sql);
    }

    private function getUserRolesFromDB($userRolesDB) {
        $roles = array();

        foreach ($userRolesDB as $userRole) {
            $user = $this->userDAO->show("login", $userRole["idusuario"]);
            $role = $this->roleDAO->show("id", $userRole["idrol"]);
            $x = new UsuarioRol($userRole["id"], $role, $user);
            array_push($roles, $x);
        }
        return $roles;
    }
}