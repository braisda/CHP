<?php
session_start();
include_once '../utils/auth.php';
include_once '../utils/CheckPermission.php';

if (!IsAuthenticated()){
    header('Location:../index.php');
}

include_once '../utils/pagination.php';
include_once '../models/common/DAOException.php';
include_once '../models/role/roleDAO.php';
include_once '../models/user/userDAO.php';
include_once '../models/userRole/userRoleDAO.php';
include_once '../views/common/head.php';
include_once '../views/common/headerMenu.php';
include_once '../views/common/paginationView.php';
include_once '../views/userRole/userRoleShowAllView.php';
include_once '../views/userRole/userRoleAddView.php';
include_once '../views/userRole/userRoleShowView.php';
include_once '../views/userRole/userRoleEditView.php';
include_once '../views/userRole/userRoleSearchView.php';
include_once '../utils/confirmDelete.php';

//DAO
$userRoleDAO = new UserRoleDAO();
$roleDAO = new RoleDAO();
$userDAO = new UserDAO();

//Data required
$roleData = $roleDAO->showAll();
$userData = $userDAO->showAll();

$userRolePrimaryKey = "id";
$value = $_REQUEST[$userRolePrimaryKey];
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (checkPermission("usuarioRole", "ADD")) {
            if (!isset($_POST["submit"])) {
                new UserRoleAddView($userData, $roleData);
            } else {
                try {
                    $userRole = new UsuarioRol();
                    $userRole->setIdusuario($userDAO->show("login", $_POST["user_id"])->getId());
                    $userRole->setIdrol($roleDAO->show("id", $_POST["role_id"])->getId());
                    $userRoleDAO->add($userRole);
                    
                    goToShowAllAndShowSuccess("Rol añadido correctamente.", $userData, $roleData);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage(), $userData, $roleData);
                } catch (Exception $ve) {
                    goToShowAllAndShowError($ve->getMessage(), $userData, $roleData);
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para añadir.", $userData, $roleData);
        }
        break;
    case "delete":
        if (checkPermission("usuarioRole", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $userRoleDAO->delete($userRolePrimaryKey, $value);
                    goToShowAllAndShowSuccess("Rol eliminado correctamente.", $userData, $roleData);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage(), $userData, $roleData);
                }
            } else {
                try {
                    showAll($userData, $roleData);
                    confirmDelete("Eliminar Rol", "¿Está seguro de que desea eliminar " .
                        "el rol %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../controllers/userRoleController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage(), $userData, $roleData);
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.", $userData, $roleData);
        }
        break;
    case "show":
        if (checkPermission("usuarioRole", "SHOWCURRENT")) {
            try {
                $userRoleData = $userRoleDAO->show($userRolePrimaryKey, $value);
                new UserRoleShowView($userRoleData);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $userData, $roleData);
            } catch (Exception $ve) {
                goToShowAllAndShowError($ve->getMessage(), $userData, $roleData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para visualizar la entidad.", $userData, $roleData);
        }
        break;
    case "edit":
        if (checkPermission("usuarioRole", "EDIT")) {
            try {
                $userRole = $userRoleDAO->show($userRolePrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new UserRoleEditView($userRole, $userData, $roleData);
                } else {
                    $userRole->setId($value);
                    $userRole->setIdusuario($userDAO->show("login", $_POST["user_id"])->getId());
                    $userRole->setIdrol($roleDAO->show("id", $_POST["role_id"])->getId());
                    $userRoleDAO->edit($userRole);
                    goToShowAllAndShowSuccess("Rol editado correctamente.", $userData, $roleData);
                }
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $userData, $roleData);
            } catch (Exception $ve) {
                goToShowAllAndShowError($ve->getMessage(), $userData, $roleData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para editar.", $userData, $roleData);
        }
        break;
    case "search":
        if(checkPermission("usuarioRole", "SHOWALL")) {
            try {
                $userRole = $userRoleDAO->search($_POST["user_id"], $_POST["role_id"]);
                $userRoles = array();

                foreach($userRole as $userRol) {
                    array_push($userRoles, $userRoleDAO->show($userRolePrimaryKey, $userRol["id"]));
                }
                showAllSearch($userRoles, $userData, $roleData);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $userData, $roleData);
            } catch (Exception $ve) {
                goToShowAllAndShowError($ve->getMessage(), $userData, $roleData);
            }
        } else{
            goToShowAllAndShowError("No tienes permiso para buscar.", $userData, $roleData);
        }
        break;
    default:
        showAll($userData, $roleData);
        break;
}

function showAll($userData, $roleData) {
    showAllSearch(NULL, $userData, $roleData);
}

function showAllSearch($search, $userData, $roleData) {
    if (checkPermission("usuarioRole", "SHOWALL")) {
        try {
            $currentPage = getPage();
            $itemsPerPage = getNumberItems();
            $totalUserRoles = $GLOBALS["userRoleDAO"]->countTotalUserRoles();

            if ($search != NULL) {
                $userRoleData = $search;
                $totalUserRoles = count($userRoleData);
            } else {
                $userRoleData = $GLOBALS["userRoleDAO"]->showAllPaged($currentPage, $itemsPerPage);
            }

            new UserRoleShowAllView($userRoleData, $userData, $roleData, $itemsPerPage, $currentPage, $totalUserRoles, $search);
        } catch (DAOException $e) {
            include '../models/common/messageType.php';
            include '../utils/ShowToast.php';
            new RoleShowAllView(array());
            $message = MessageType::ERROR;
            showToast($message, $e->getMessage());
        }
    } else {
        accessDenied();
    }
}

function goToShowAllAndShowError($message, $userData, $roleData) {
    showAll($userData, $roleData);
    include '../models/common/messageType.php';
    include '../utils/ShowToast.php';
    $messageType = MessageType::ERROR;
    showToast($messageType, $message);
}

function goToShowAllAndShowSuccess($message, $userData, $roleData) {
    showAll($userData, $roleData);
    include '../models/common/messageType.php';
    include '../utils/ShowToast.php';
    $messageType = MessageType::SUCCESS;
    showToast($messageType, $message);
}


?>