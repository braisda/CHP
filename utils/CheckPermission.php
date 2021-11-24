<?php
include_once "../models/userRole/userRoleDAO.php";
include_once "../models/permission/permissionDAO.php";
include_once "../utils/jwt.php";

function checkPermission($controller, $act)
{
    $permissionDAO = new PermissionDAO();
    $userRoleDAO = new UserRoleDAO();
    try{
        $userRoles = $userRoleDAO->showAll();
        foreach ($userRoles as $userRole) {
        // Clave secreta del lado del servidor
        $serverKey = '5f2b5cdbe5194f10b3241568fe4e2b24';
        $elem = JWT::decode($_SESSION['token'], $serverKey, array('HS256'));

            if($userRole->getUser()->getLogin() ==  $elem->login) {
                $permissions = $permissionDAO->showAll();
                foreach ($permissions as $permission) {
                    if ($permission->getRole()->getId() == $userRole->getId()) {
                        if ($permission->getFuncAction()->getFunctionality()->getName() ==
                            $controller . "Management" && $permission->getFuncAction()->getAction()->getName() == $act) {
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
?>