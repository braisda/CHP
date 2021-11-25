<?php

include_once '../models/action/actionDAO.php';
include_once '../views/Common/head.php';
include_once '../views/Common/headerMenu.php';
include_once '../views/action/actionShowAllView.php';
include_once '../views/action/actionAddView.php';
include_once '../views/action/actionShowView.php';
include_once '../views/action/actionEditView.php';
include_once '../utils/confirmDelete.php';

//DAO
$actionDAO = new ActionDAO();
$actionPrimaryKey = "id";
$value = $_REQUEST[$actionPrimaryKey];
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
        try {
            $actionData = $actionDAO->show($actionPrimaryKey, $value);
            new ActionShowView($actionData);
        } catch (DAOException $e) {
            goToShowAllAndShowError($e->getMessage());
        } catch (Exception $ve) {
            goToShowAllAndShowError($ve->getMessage());
        }
        break;
    case "edit":
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