<?php
include_once "../models/userRole/userRoleDAO.php";
include_once "../models/permission/permissionDAO.php";
include_once 'userInSession.php';

function IsAdmin()
{
    $permissionDAO = new PermissionDAO();
    $userRoleDAO = new UserRoleDAO();

    try{
        $userRoles = $userRoleDAO->showAll();
        foreach ($userRoles as $userRole) {
            if($userRole->getUsuario()->getLogin() ==  getUserInSession()) {
                $permissions = $permissionDAO->showAll();
                foreach ($permissions as $permission) {
                    if ($permission->getRol()->getId() == $userRole->getId()) {
                        if ($permission->getRol()->getNombre() == "Admin") {
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