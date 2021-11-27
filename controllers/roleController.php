<?php
session_start();
include_once '../utils/auth.php';
include_once '../utils/CheckPermission.php';

if (!IsAuthenticated()){
    header('Location:../index.php');
}

include_once '../utils/pagination.php';
include_once '../models/role/roleDAO.php';
include_once '../views/common/head.php';
include_once '../views/common/headerMenu.php';
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
        break;
    case "delete":
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
        break;
    case "show":
        try {
            $roleData = $roleDAO->show($rolePrimaryKey, $value);
            printf("entra");
            new RoleShowView($roleData);
        } catch (DAOException $e) {
            goToShowAllAndShowError($e->getMessage());
        } catch (Exception $ve) {
            goToShowAllAndShowError($ve->getMessage());
        }
        break;
    case "edit":
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
        break;
    case "search":
        if (!isset($_POST["submit"])) {
            new ActionSearchView();
        } else {
            try {
                $role = new Rol();
                if(!empty($_POST["name"])) {
                    $role->setNombre($_POST["name"]);
                }
                if(!empty($_POST["description"])) {
                    $role->setDescripcion($_POST["description"]);
                }
                showAllSearch($role);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            } catch (Exception $ve) {
                goToShowAllAndShowError($ve->getMessage());
            }
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
    try {
            $currentPage = getPage();
            $itemsPerPage = getNumberItems();
            $toSearch = getToSearch($search);
            $totalRoles = $GLOBALS["roleDAO"]->countTotalRoles($toSearch);
            $roleData = $GLOBALS["roleDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
            new RoleShowAllView($roleData, $itemsPerPage, $currentPage, $totalRoles, $toSearch);
        } catch (DAOException $e) {
            include '../models/common/messageType.php';
            include '../utils/ShowToast.php';
            new RoleShowAllView(array());
            $message = MessageType::ERROR;
            showToast($message, $e->getMessage());
        }
}

function goToShowAllAndShowError($message) {
    showAll();
    include '../models/common/messageType.php';
    include '../utils/ToastTrigger.php';
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