<?php
session_start();
include_once '../utils/auth.php';
include_once '../utils/CheckPermission.php';

if (!IsAuthenticated()){
    header('Location:../index.php');
}

include_once '../utils/pagination.php';
include_once '../models/common/DAOException.php';
include_once '../models/action/actionDAO.php';
include_once '../views/common/head.php';
include_once '../views/common/headerMenu.php';
include_once '../views/common/paginationView.php';
include_once '../views/action/actionShowAllView.php';
include_once '../views/action/actionAddView.php';
include_once '../views/action/actionShowView.php';
include_once '../views/action/actionEditView.php';
include_once '../views/action/actionSearchView.php';
include_once '../utils/confirmDelete.php';

//DAO
$actionDAO = new ActionDAO();
$actionPrimaryKey = "id";
$value = $_REQUEST[$actionPrimaryKey];
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (checkPermission("accion", "ADD")) {
            if (!isset($_POST["submit"])) {
                new ActionAddView();
            } else {
                try {
                    $action = new Accion();
                    $action->setNombre($_POST["name"]);
                    $action->setDescripcion($_POST["description"]);
                    $actionDAO->add($action);
                    
                    goToShowAllAndShowSuccess("Acción añadida correctamente.");
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
        if (checkPermission("accion", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $actionDAO->delete($actionPrimaryKey, $value);
                    goToShowAllAndShowSuccess("Acción eliminada correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    showAll();
                    confirmDelete("Eliminar Acción", "¿Está seguro de que desea eliminar " .
                        "la acción %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../controllers/actionController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "show":
        if (checkPermission("accion", "SHOWCURRENT")) {
            try {
                $actionData = $actionDAO->show($actionPrimaryKey, $value);
                new ActionShowView($actionData);
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
        if (checkPermission("accion", "EDIT")) {
            try {
                $action = $actionDAO->show($actionPrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new ActionEditView($action);
                } else {
                    $action->setId($value);
                    $action->setNombre($_POST["name"]);
                    $action->setDescripcion($_POST["description"]);
                    $actionDAO->edit($action);
                    goToShowAllAndShowSuccess("Acción editada correctamente.");
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
        if(checkPermission("accion", "SHOWALL")) {
            try {
                $action = $actionDAO->search($_POST["name"], $_POST["description"]);
                $actions = array();

                foreach($action as $act) {
                    array_push($actions, $actionDAO->show($actionPrimaryKey, $act["id"]));
                }

                showAllSearch($actions);
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
    if (checkPermission("accion", "SHOWALL")) {
        try {
            $currentPage = getPage();
            $itemsPerPage = getNumberItems();
            $totalActions = $GLOBALS["actionDAO"]->countTotalActions();

            if ($search != NULL) {
                $actionData = $search;
                $totalActions = count($actionData);
            } else {
                $actionData = $GLOBALS["actionDAO"]->showAllPaged($currentPage, $itemsPerPage);
            }

            new ActionShowAllView($actionData, $itemsPerPage, $currentPage, $totalActions, $search);
        } catch (DAOException $e) {
            include '../models/common/messageType.php';
            include '../utils/ShowToast.php';
            new ActionShowAllView(array());
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