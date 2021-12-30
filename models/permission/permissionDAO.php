<?php
include_once '../models/common/defaultDAO.php';
include_once '../models/role/roleDAO.php';
include_once '../models/funcAction/funcActionDAO.php';
include_once 'permiso.php';

class PermissionDAO
{
    private $defaultDAO;
    private $roleDAO;
    private $funcActionDAO;


    public function __construct() {
        $this->defaultDAO = new defaultDAO();
        $this->roleDAO = new RoleDAO();
        $this->funcActionDAO = new FuncActionDAO();
    }

    function showAll() {
        $permission = $this->defaultDAO->showAll("permiso");
        return $this->getPermissionsFromDB($permission);
    }

    function add($permission) {
        $this->defaultDAO->insert($permission, "id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("permiso", $key, $value);
    }

    function show($key, $value) {
        $permission_db = $this->defaultDAO->show("permiso", $key, $value);
        $role = $this->roleDAO->show("id", $permission_db["idrol"]);
        $funcAction = $this->funcActionDAO->show("id", $permission_db["idfuncaccion"]);
        return new Permiso($permission_db["id"], $role, $funcAction);
    }

    function edit($permission) {
        $this->defaultDAO->edit($permission, "id");
    }

    function showAllPaged($currentPage, $itemsPerPage) {
        $permissionsDB = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Permiso());
        return $this->getPermissionsFromDB($permissionsDB);
    }

    function countTotalPermissions() {
        return $this->defaultDAO->countTotalEntries(new Permiso());
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("permiso", $value);
    }

    private function getPermissionsFromDB($permissions_db) {
        $permissions = array();
        foreach ($permissions_db as $permission) {
            $role = $this->roleDAO->show("id", $permission["idrol"]);
            $funcAction = $this->funcActionDAO->show("id", $permission["idfuncaccion"]);
            array_push($permissions, new Permiso($permission["id"], $role, $funcAction));
        }
        return $permissions;
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("permiso");
    }

    function search($idRol, $idFuncAccion) {
        $sql = "SELECT DISTINCT * FROM permiso WHERE idrol ='". $idRol . "' AND idfuncaccion ='" . $idFuncAccion . "'";
        return $this->defaultDAO->getArrayFromSqlQuery($sql);
    }
}