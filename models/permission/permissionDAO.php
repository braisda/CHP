<?php
include_once '../models/common/defaultDAO.php';
include_once '../models/role/roleDAO.php';
include_once '../models/funcAction/funcActionDAO.php';
include_once 'permission.php';

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
        $this->defaultDAO->insert($permission,"id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("permission", $key, $value);
    }

    function show($key, $value) {
        $permission_db = $this->defaultDAO->show("permission", $key, $value);
        $role = $this->roleDAO->show("id", $permission_db["role_id"]);
        $funcAction = $this->funcActionDAO->show("id", $permission_db["func_action_id"]);
        return new Permission($permission_db["id"], $role, $funcAction);
    }

    function edit($permission) {
        $this->defaultDAO->edit($permission, "id");
    }

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch) {
        $permissionsDB = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Permission(), $stringToSearch);
        return $this->getPermissionsFromDB($permissionsDB);
    }

    function countTotalPermissions($stringToSearch) {
        return $this->defaultDAO->countTotalEntries(new Permission(), $stringToSearch);
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("permission", $value);
    }

    private function getPermissionsFromDB($permissions_db) {
        $permissions = array();
        foreach ($permissions_db as $permission) {
            $role = $this->roleDAO->show("id", $permission["idRol"]);
            $funcAction = $this->funcActionDAO->show("id", $permission["idFuncAccion"]);
            array_push($permissions, new Permission($permission["id"], $role, $funcAction));
        }
        return $permissions;
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("permission");
    }
}