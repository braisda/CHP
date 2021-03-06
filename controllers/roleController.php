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
include_once '../views/common/head.php';
include_once '../views/common/headerMenu.php';
include_once '../views/common/paginationView.php';
include_once '../views/role/roleShowAllView.php';
include_once '../views/role/roleAddView.php';
include_once '../views/role/roleShowView.php';
include_once '../views/role/roleEditView.php';
include_once '../views/role/roleSearchView.php';
include_once '../utils/confirmDelete.php';

//DAO
$roleDAO = new RoleDAO();
$rolePrimaryKey = "id";
$value = $_REQUEST[$rolePrimaryKey];
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (checkPermission("Role", "ADD")) {
            if (!isset($_POST["submit"])) {
                new RoleAddView();
            } else {
                try {
                    $role = new Rol();
                    $role->setNombre($_POST["name"]);
                    $role->setDescripcion($_POST["description"]);
                    $roleDAO->add($role);
                    
                    goToShowAllAndShowSuccess("Rol añadido correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                } catch (Exception $ve) {
                    goToShowAllAndShowError($ve->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para añadir.");
        }
        break;
    case "delete":
        if (checkPermission("Role", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $roleDAO->delete($rolePrimaryKey, $value);
                    goToShowAllAndShowSuccess("Rol eliminado correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    showAll();
                    confirmDelete("Eliminar Rol", "¿Está seguro de que desea eliminar " .
                        "el rol %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../controllers/roleController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "show":
        if (checkPermission("Role", "SHOWCURRENT")) {
            try {
                $roleData = $roleDAO->show($rolePrimaryKey, $value);
                new RoleShowView($roleData);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            } catch (Exception $ve) {
                goToShowAllAndShowError($ve->getMessage());
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para visualizar la entidad.");
        }
        break;
    case "edit":
        if (checkPermission("Role", "EDIT")) {
            try {
                $role = $roleDAO->show($rolePrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new RoleEditView($role);
                } else {
                    $role->setId($value);
                    $role->setNombre($_POST["name"]);
                    $role->setDescripcion($_POST["description"]);
                    $roleDAO->edit($role);
                    goToShowAllAndShowSuccess("Rol editado correctamente.");
                }
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            } catch (Exception $ve) {
                goToShowAllAndShowError($ve->getMessage());
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para editar.");
        }
        break;
    case "search":
        if(checkPermission("Role", "SHOWALL")) {
            try {
                $role = $roleDAO->search($_POST["name"], $_POST["description"]);
                $roles = array();

                foreach($role as $rol) {
                    array_push($roles, $roleDAO->show($rolePrimaryKey, $rol["id"]));
                }

                showAllSearch($roles);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            } catch (Exception $ve) {
                goToShowAllAndShowError($ve->getMessage());
            }
        } else{
            goToShowAllAndShowError("No tienes permiso para buscar.");
        }
        break;
    default:
        showAll();
        break;
}

function showAll() {
    showAllSearch(NULL);
}

function showAllSearch($search) {
    if (checkPermission("Role", "SHOWALL")) {
        try {
            $currentPage = getPage();
            $itemsPerPage = getNumberItems();
            $totalRoles = $GLOBALS["roleDAO"]->countTotalRoles();

            if ($search != NULL) {
                $roleData = $search;
                $totalUsers = count($roleData);
            } else {
                $roleData = $GLOBALS["roleDAO"]->showAllPaged($currentPage, $itemsPerPage);
            }

            new RoleShowAllView($roleData, $itemsPerPage, $currentPage, $totalRoles, $search);
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

function goToShowAllAndShowError($message) {
    showAll();
    include '../models/common/messageType.php';
    include '../utils/ShowToast.php';
    $messageType = MessageType::ERROR;
    showToast($messageType, $message);
}

function goToShowAllAndShowSuccess($message) {
    showAll();
    include '../models/common/messageType.php';
    include '../utils/ShowToast.php';
    $messageType = MessageType::SUCCESS;
    showToast($messageType, $message);
}


?>