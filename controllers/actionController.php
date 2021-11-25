<?php

include_once '../models/action/actionDAO.php';
include_once '../views/Common/head.php';
include_once '../views/Common/headerMenu.php';
include_once '../views/action/actionShowAllView.php';
include_once '../views/action/actionAddView.php';

//DAO
$actionDAO = new ActionDAO();

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
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
    case "delete":
        
        break;
    case "show":
        break;
    case "edit":
        
        break;
    case "search":
         
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
            $currentPage = 1;//getCurrentPage();
            $itemsPerPage = 10;//getItemsPerPage();
            $toSearch = null;//getToSearch($search);
            $totalActions = $GLOBALS["actionDAO"]->countTotalActions($toSearch);
            $actionData = $GLOBALS["actionDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
            new ActionShowAllView($actionData, $itemsPerPage, $currentPage, $totalActions, $toSearch);
        } catch (DAOException $e) {
            include '../models/common/messageType.php';
            include '../utils/ShowToast.php';
            new ActionShowAllView(array());
            $message = MessageType::ERROR;
            showToast($message, $e->getMessage());
        }
}

function goToShowAllAndShowError($message) {
    showAll();
    include '../models/common/messageType.php';
    include '../utils/ShowToast.php';
    $message = MessageType::ERROR;
    showToast($message, $e->getMessage());
}

function goToShowAllAndShowSuccess($message) {
    showAll();
    include '../models/common/messageType.php';
    include '../utils/ShowToast.php';
    $message = MessageType::ERROR;
    showToast($message, $e->getMessage());
}


?>