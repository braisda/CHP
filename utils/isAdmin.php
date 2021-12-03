<?php
include_once "../models/userRole/userRoleDAO.php";
include_once "../models/permission/permissionDAO.php";

function IsAdmin()
{
    $permissionDAO = new PermissionDAO();
    $userRoleDAO = new UserRoleDAO();

    $serverKey = '5f2b5cdbe5194f10b3241568fe4e2b24';
    $elem = JWT::decode($_SESSION['token'], $serverKey, array('HS256'));

    try{
        $userRoles = $userRoleDAO->showAll();
        foreach ($userRoles as $userRole) {
            if($userRole->getUsuario()->getLogin() ==  $elem->login) {
                $permissions = $permissionDAO->showAll();
                foreach ($permissions as $permission) {
                    if ($permission->getRol()->getId() == $userRole->getId()) {
                        if ($permission->getRol()->getNombre() =="Admin") {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }
    catch (DAOException $e){
        return false;
    }
}