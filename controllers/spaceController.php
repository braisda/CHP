<?php
session_start();
include_once '../utils/auth.php';
include_once '../utils/CheckPermission.php';

if (!IsAuthenticated()){
    header('Location:../index.php');
}

include_once '../utils/pagination.php';
include_once '../models/common/DAOException.php';
include_once '../models/space/spaceDAO.php';
include_once '../models/building/buildingDAO.php';
include_once '../views/common/head.php';
include_once '../views/common/headerMenu.php';
include_once '../views/common/paginationView.php';
include_once '../views/space/spaceShowAllView.php';
include_once '../views/space/spaceAddView.php';
include_once '../views/space/spaceShowView.php';
include_once '../views/space/spaceEditView.php';
include_once '../views/space/spaceSearchView.php';
include_once '../utils/confirmDelete.php';

//DAOS
$spaceDAO = new SpaceDAO();
$buildingDAO = new BuildingDAO();

//Data required
$buildingData = $buildingDAO->showAll();

$spacePrimaryKey = "id";
$value = $_REQUEST[$spacePrimaryKey];

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (checkPermission("espacio", "ADD")) {
            if (!isset($_POST["submit"])) {
                new SpaceAddView($buildingData);
            } else {
                try {
                    $space = new Espacio();
                    $space->setIdedificio($_POST["building"]);
                    $space->setNombre($_POST["name"]);
                    $space->setCapacidad($_POST["capacity"]);
                    $space->setOficina($_POST["office"]);
                    $spaceDAO->add($space);
                    goToShowAllAndShowSuccess("Espacio añadido correctamente.", $buildingData);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage(), $buildingData);
                } catch (Exception $ve) {
                    goToShowAllAndShowError($ve->getMessage(), $buildingData);
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para añadir.", $buildingData);
        }
        break;
    case "delete":
        if (checkPermission("espacio", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $spaceDAO->delete($spacePrimaryKey, $value);
                    goToShowAllAndShowSuccess("Espacio eliminado correctamente.", $buildingData);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage(), $buildingData);
                }
            } else {
                try {
                    $spaceDAO->checkDependencies($value);
                    showAll($buildingData);
                    confirmDelete("Eliminar espacio", "¿Está seguro de que desea eliminar " .
                        "el espacio %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../controllers/spaceController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage(), $buildingData);
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.", $buildingData);
        }
        break;
    case "show":
        if (checkPermission("espacio", "SHOWCURRENT")) {
            try {
                $spaceData = $spaceDAO->show($spacePrimaryKey, $value);
                new SpaceShowView($spaceData);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $buildingData);
            } catch (Exception $ve) {
                goToShowAllAndShowError($ve->getMessage(), $buildingData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para visualizar la entidad.", $buildingData);
        }
        break;
    case "edit":
        if (checkPermission("espacio", "EDIT")) {
            try {
                $space = $spaceDAO->show($spacePrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new SpaceEditView($space, $buildingData);
                } else {
                    $space->setId($value);
                    $space->setIdedificio($_POST["building"]);
                    $space->setNombre($_POST["name"]);
                    $space->setCapacidad($_POST["capacity"]);
                    $space->setOficina($_POST["office"]);
                    $spaceDAO->edit($space);
                    goToShowAllAndShowSuccess("Espacio editado correctamente.", $buildingData);
                }
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $buildingData);
            } catch (Exception $ve) {
                goToShowAllAndShowError($ve->getMessage(), $buildingData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para editar.", $buildingData);
        }
        break;
    case "search":
        if (checkPermission("espacio", "SHOWALL")) {
            try {
                $office = 0;
                if($_POST["office"] == "on"){
                    $office = 1;
                }
                $space = $spaceDAO->search($_POST["building_id"], $_POST["name"], $_POST["capacity"], $office);
                print_r($_POST["office"]);
                $spaces = array();
                foreach($space as $s) {
                    array_push($spaces, $spaceDAO->show($spacePrimaryKey, $s["id"]));
                }
                showAllSearch($space, $buildingData);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $buildingData);
            } catch (Exception $ve) {
                goToShowAllAndShowError($ve->getMessage(), $buildingData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para buscar.", $buildingData);
        }
        break;
    default:
        showAll($buildingData);
        break;
}

function showAll($buildingData)
{
    showAllSearch(NULL, $buildingData);
}

function showAllSearch($search, $buildingData)
{
    if (checkPermission("espacio", "SHOWALL")) {
        try {
            $currentPage = getPage();
            $itemsPerPage = getNumberItems();
            $totalSpaces = $GLOBALS["spaceDAO"]->countTotalSpaces();
            
            if ($search != NULL) {
                $spacesData = $GLOBALS["spaceDAO"]->parseSpaces($search);
                $totalSpaces = count($spacesData);
            } else {
                $spacesData = $GLOBALS["spaceDAO"]->showAllPaged($currentPage, $itemsPerPage);
            }
            new SpaceShowAllView($spacesData, $buildingData, $itemsPerPage, $currentPage, $totalSpaces, $search);
        } catch (DAOException $e) {
            include '../models/common/messageType.php';
            include '../utils/ShowToast.php';
            new SpaceShowAllView(array(), $buildingData);
            $message = MessageType::ERROR;
            showToast($message, $e->getMessage());
        }
    } else {
        accessDenied();
    }
}

function goToShowAllAndShowError($message, $buildingData)
{
    showAll($buildingData);
    include '../models/common/messageType.php';
    include '../utils/ShowToast.php';
    $messageType = MessageType::ERROR;
    showToast($messageType, $message);
}

function goToShowAllAndShowSuccess($message, $buildingData)
{
    showAll($buildingData);
    include '../models/common/messageType.php';
    include '../utils/ShowToast.php';
    $messageType = MessageType::SUCCESS;
    showToast($messageType, $message);
}
