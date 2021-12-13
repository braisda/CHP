<?php
session_start();
include_once '../utils/auth.php';
include_once '../utils/CheckPermission.php';

if (!IsAuthenticated()){
    header('Location:../index.php');
}

include_once '../utils/pagination.php';
include_once '../models/common/DAOException.php';
include_once '../models/building/buildingDAO.php';
include_once '../models/user/userDAO.php';
include_once '../views/common/head.php';
include_once '../views/common/headerMenu.php';
include_once '../views/common/paginationView.php';
include_once '../views/building/buildingShowAllView.php';
include_once '../views/building/buildingAddView.php';
include_once '../views/building/buildingShowView.php';
include_once '../views/building/buildingEditView.php';
include_once '../views/building/buildingSearchView.php';
include_once '../utils/confirmDelete.php';

//DAOS
$buildingDAO = new BuildingDAO();
$userDAO = new UserDAO();

//Data required
$userData = $userDAO->showAll();

$buildingPrimaryKey = "id";
$value = $_REQUEST[$buildingPrimaryKey];

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (checkPermission("edificio", "ADD")) {
            if (!isset($_POST["submit"])) {
                new BuildingAddView($userData);
            } else {
                try {
                    $building = new Edificio();
                    $building->setIdusuario($_POST["user"]);
                    $building->setLocalizacion($_POST["location"]);
                    $building->setNombre($_POST["name"]);
                    $buildingDAO->add($building);
                    goToShowAllAndShowSuccess("Edificio añadido correctamente.", $userData);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage(), $userData);
                } catch (Exception $ve) {
                    goToShowAllAndShowError($ve->getMessage(), $userData);
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para añadir.", $userData);
        }
        break;
    case "delete":
        if (checkPermission("edificio", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $buildingDAO->delete($buildingPrimaryKey, $value);
                    goToShowAllAndShowSuccess("Edificio eliminado correctamente.", $userData);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage(), $userData);
                }
            } else {
                try {
                    $buildingDAO->checkDependencies($value);
                    showAll($userData);
                    confirmDelete("Eliminar edificio", "¿Está seguro de que desea eliminar " .
                        "el edificio %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../controllers/buildingController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage(), $userData);
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.", $userData);
        }
        break;
    case "show":
        if (checkPermission("edificio", "SHOWCURRENT")) {
            try {
                $buildingData = $buildingDAO->show($buildingPrimaryKey, $value);
                new BuildingShowView($buildingData);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $userData);
            } catch (Exception $ve) {
                goToShowAllAndShowError($ve->getMessage(), $userData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para visualizar la entidad.", $userData);
        }
        break;
    case "edit":
        if (checkPermission("edificio", "EDIT")) {
            try {
                $building = $buildingDAO->show($buildingPrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new BuildingEditView($building, $userData);
                } else {
                    $building->setId($value);
                    $building->setIdusuario($_POST["user_id"]);
                    $building->setLocalizacion($_POST["location"]);
                    $building->setNombre($_POST["name"]);
                    $buildingDAO->edit($building);
                    goToShowAllAndShowSuccess("Edificio editado correctamente.", $userData);
                }
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $userData);
            } catch (Exception $ve) {
                goToShowAllAndShowError($ve->getMessage(), $userData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para editar.", $userData);
        }
        break;
    case "search":
        if (checkPermission("edificio", "SHOWALL")) {
            try {
                $building = $buildingDAO->search($_POST["user_id"], $_POST["location"], $_POST["name"]);
                $buildings = array();
                
                foreach($building as $b) {
                    array_push($buildings, $buildingDAO->show($buildingPrimaryKey, $b["id"]));
                }
                showAllSearch($building, $userData);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $userData);
            } catch (Exception $ve) {
                goToShowAllAndShowError($ve->getMessage(), $userData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para buscar.", $userData);
        }
        break;
    default:
        showAll($userData);
        break;
}

function showAll($userData)
{
    showAllSearch(NULL, $userData);
}

function showAllSearch($search, $userData)
{
    if (checkPermission("edificio", "SHOWALL")) {
        try {
            $currentPage = getPage();
            $itemsPerPage = getNumberItems();
            $totalBuildings = $GLOBALS["buildingDAO"]->countTotalBuildings();
            
            if ($search != NULL) {
                $buildingsData = $GLOBALS["buildingDAO"]->parseBuildings($search);
                $totalBuildings = count($buildingsData);
            } else {
                $buildingsData = $GLOBALS["buildingDAO"]->showAllPaged($currentPage, $itemsPerPage);
            }
            new BuildingShowAllView($buildingsData, $userData, $itemsPerPage, $currentPage, $totalBuildings, $search);
        } catch (DAOException $e) {
            include '../models/common/messageType.php';
            include '../utils/ShowToast.php';
            new BuildingShowAllView(array(), $userData);
            $message = MessageType::ERROR;
            showToast($message, $e->getMessage());
        }
    } else {
        accessDenied();
    }
}

function goToShowAllAndShowError($message, $userData)
{
    showAll($userData);
    include '../models/common/messageType.php';
    include '../utils/ShowToast.php';
    $messageType = MessageType::ERROR;
    showToast($messageType, $message);
}

function goToShowAllAndShowSuccess($message, $userData)
{
    showAll($userData);
    include '../models/common/messageType.php';
    include '../utils/ShowToast.php';
    $messageType = MessageType::SUCCESS;
    showToast($messageType, $message);
}
