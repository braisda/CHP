<?php

session_start();
include_once '../utils/auth.php';
include_once '../utils/CheckPermission.php';

if (!IsAuthenticated()) {
    header('Location:../index.php');
}

include_once '../utils/pagination.php';
include_once '../models/functionality/functionalityDAO.php';
include_once '../models/common/DAOException.php';
include_once '../views/common/head.php';
include_once '../views/common/headerMenu.php';
include_once '../views/common/paginationView.php';
include_once '../utils/confirmDelete.php';
include_once '../utils/openDeletionModal.php';
include_once '../models/funcAction/funcActionDAO.php';
include_once '../models/action/actionDAO.php';
include_once '../models/functionality/functionalityDAO.php';
include_once '../views/funcAction/funcActionShowAllView.php';
include_once '../views/funcAction/funcActionAddView.php';
include_once '../views/funcAction/funcActionShowView.php';
include_once '../views/funcAction/funcActionEditView.php';

$funcActionDAO = new FuncActionDAO();
$actionDAO = new ActionDAO();
$functionalityDAO = new FunctionalityDAO();

$actionsData = $actionDAO->showAll();
$functionalitiesData = $functionalityDAO->showAll();

$funcActionPK = "id";
$value = $_REQUEST[$funcActionPK];

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (checkPermission("Funcaccion", "ADD")) {
            if (!isset($_POST["submit"])) {
                new FuncActionAddView($actionsData, $functionalitiesData);
            } else {
                try {
                    $funcAction = new Funcaccion();
                    $funcAction->setAccion($actionDAO->show("id", $_POST["action_id"]));
                    $funcAction->setFuncionalidad($functionalityDAO->show("id", $_POST["functionality_id"]));
                    $funcActionDAO->add($funcAction);
                    goToShowAllAndShowSuccess("Acción-funcionalidad añadida correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                } catch (ValidationException $ve) {
                    goToShowAllAndShowError($ve->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para añadir.");
        }
        break;
    case "delete":
        if (checkPermission("Funcaccion", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $funcActionDAO->delete($funcActionPK, $value);
                    goToShowAllAndShowSuccess("Acción-funcionalidad eliminada correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    $funcActionDAO->checkDependencies($value);
                    showAll();
                    openDeletionModal("Eliminar acción-funcionalidad", "¿Está seguro de que desea eliminar " .
                        "la acción-funcionalidad %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../controllers/funcActionController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "show":
        if (checkPermission("Funcaccion", "SHOWCURRENT")) {
            try {
                $funcActionData = $funcActionDAO->show($funcActionPK, $value);
                new FuncActionShowView($funcActionData);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage());
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para visualizar la entidad.");
        }
        break;
    case "edit":
        if (checkPermission("Funcaccion", "EDIT")) {
            try {
                $funcAction = $funcActionDAO->show($funcActionPK, $value);
                if (!isset($_POST["submit"])) {
                    new FuncActionEditView($funcAction, $actionsData, $functionalitiesData);
                } else {
                    $funcAction->setId($value);
                    $funcAction->setAccion($actionDAO->show("id", $_POST["action_id"]));
                    $funcAction->setFuncionalidad($functionalityDAO->show("id", $_POST["functionality_id"]));
                    $funcActionDAO->edit($funcAction);
                    goToShowAllAndShowSuccess("Acción-funcionalidad editada correctamente.");
                }
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage());
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para editar.");
        }
        break;
    case "search":
        if (checkPermission("Funcaccion", "SHOWALL")) {
            try {
                $funcAction = $funcActionDAO->search($_POST["action_id"], $_POST["functionality_id"]);
                $funcActions = array();

                foreach($funcAction as $fa) {
                   array_push($funcActions, $funcActionDAO->show($funcActionPK, $fa["id"]));
                }

                showAllSearch($funcActions);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $userData, $centerData);
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage(), $userData, $centerData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para buscar.", $userData, $centerData);
        }
        break;
        break;
    default:
        showAll();
        break;
}

function showAll() {
    showAllSearch(NULL);
}

function showAllSearch($search) {
    if (checkPermission("Funcaccion", "SHOWALL")) {
        try {
            $currentPage = getPage();
            $itemsPerPage = getNumberItems();

            $totalFuncActions = $GLOBALS["funcActionDAO"]->countTotalFuncActions();
            if ($search != NULL) {
                $funcActionsData = $search;
                $totalFuncActions = count($funcActionsData);
            } else {
                $funcActionsData = $GLOBALS["funcActionDAO"]->showAllPaged($currentPage, $itemsPerPage);
            }
            new FuncActionShowAllView($funcActionsData, $itemsPerPage, $currentPage, $totalFuncActions, $search, $GLOBALS["actionsData"], $GLOBALS["functionalitiesData"]);
        } catch (DAOException $e) {
            new FuncActionShowAllView(array());
            errorMessage($e->getMessage());
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