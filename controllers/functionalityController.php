<?php

include_once '../models/functionality/functionalityDAO.php';
include_once '../views/Common/head.php';
include_once '../views/Common/headerMenu.php';
include_once '../views/functionality/functionalityShowAllView.php';
include_once '../views/functionality/functionalityAddView.php';
include_once '../views/functionality/functionalityShowView.php';
include_once '../views/functionality/functionalityEditView.php';
include_once '../views/functionality/functionalitySearchView.php';
include_once '../utils/confirmDelete.php';

//DAO
$functionalityDAO = new FunctionalityDAO();
$functionalityPrimaryKey = "id";
$value = $_REQUEST[$functionalityPrimaryKey];
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (!isset($_POST["submit"])) {
            new FunctionalityAddView();
        } else {
            try {
                $functionality = new Funcionalidad();
                $functionality->setNombre($_POST["name"]);
                $functionality->setDescripcion($_POST["description"]);
                $functionalityDAO->add($functionality);
                
                goToShowAllAndShowSuccess("Funcionalidad añadida correctamente.");
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
                $functionalityDAO->delete($functionalityPrimaryKey, $value);
                goToShowAllAndShowSuccess("Funcionalidad eliminada correctamente.");
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            }
        } else {
            try {
                showAll();
                confirmDelete("Eliminar funcionalidad", "¿Está seguro de que desea eliminar " .
                    "la funcionalidad %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                    "../controllers/functionalityController.php?action=delete&id=" . $value . "&confirm=true");
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            }
        }
        break;
    case "show":
        try {
            $functionalityData = $functionalityDAO->show($functionalityPrimaryKey, $value);
            printf("entra");
            new FunctionalityShowView($functionalityData);
        } catch (DAOException $e) {
            goToShowAllAndShowError($e->getMessage());
        } catch (Exception $ve) {
            goToShowAllAndShowError($ve->getMessage());
        }
        break;
    case "edit":
        try {
            $functionality = $functionalityDAO->show($functionalityPrimaryKey, $value);
            if (!isset($_POST["submit"])) {
                new FunctionalityEditView($functionality);
            } else {
                $functionality->setId($value);
                $functionality->setNombre($_POST["name"]);
                $functionality->setDescripcion($_POST["description"]);
                $functionalityDAO->edit($functionality);
                goToShowAllAndShowSuccess("Funcionalidad editada correctamente.");
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
                $functionality = new Funcionalidad();
                if(!empty($_POST["name"])) {
                    $functionality->setNombre($_POST["name"]);
                }
                if(!empty($_POST["description"])) {
                    $functionality->setDescripcion($_POST["description"]);
                }
                showAllSearch($functionality);
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
            $currentPage = 1;//getCurrentPage();
            $itemsPerPage = 20;//getItemsPerPage();
            $toSearch = null;//getToSearch($search);
            $totalFunctionalities = $GLOBALS["functionalityDAO"]->countTotalFunctionalities($toSearch);
            $functionalityData = $GLOBALS["functionalityDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
            new FunctionalityShowAllView($functionalityData, $itemsPerPage, $currentPage, $totalFunctionalities, $toSearch);
        } catch (DAOException $e) {
            include '../models/common/messageType.php';
            include '../utils/ShowToast.php';
            new FunctionalityShowAllView(array());
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