<?php
session_start();
include_once '../utils/auth.php';
include_once '../utils/CheckPermission.php';
if (!IsAuthenticated()){
    header('Location:../index.php');
}

include_once '../utils/pagination.php';
include_once '../models/common/DAOException.php';
include_once '../models/center/centerDAO.php';
include_once '../models/university/universityDAO.php';
include_once '../models/building/buildingDAO.php';
include_once '../views/common/head.php';
include_once '../views/common/headerMenu.php';
include_once '../views/common/paginationView.php';
include_once '../utils/confirmDelete.php';
include_once '../utils/isAdmin.php';
include_once '../utils/isUniversityOwner.php';
include_once '../utils/openDeletionModal.php';
include_once '../views/center/centerShowAllView.php';
include_once '../views/center/centerAddView.php';
include_once '../views/center/centerShowView.php';
include_once '../views/center/centerEditView.php';
include_once '../utils/userInSession.php';

$centerDAO = new CenterDAO();
$universityDAO = new UniversityDAO();
$userDAO = new UserDAO();
$buildingDAO = new BuildingDAO();

$universityData = $universityDAO->showAll();
$userData = $userDAO->showAll();
$buildingData = $buildingDAO->showAll();

$centerPK = "id";
$value = $_REQUEST[$centerPK];
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (checkPermission("centro", "ADD")) {
            if (!isset($_POST["submit"])) {
                if(!IsAdmin()){
                    $elem = getUserInSession();
                    $universities=[];
                   foreach ($universityData as $university){
                        if($university->getUsuario()->getId() == $elem->login){
                            array_push($universities, $university);
                        }
                    }
                    $universityData=$universities;
                }
                new CenterAddView($universityData, $userData, $buildingData);
            } else {
                try {
                    $center = new Centro();
                    $center->setUniversidad($universityDAO->show("id", $_POST["idUniversidad"]));
                    $center->setUsuario($userDAO->show("login", $_POST["idUsuario"]));
                    $center->setNombre($_POST["nombre"]);
                    $center->setEdificio($buildingDAO->show("id", $_POST["idEdificio"]));
                    $centerDAO->add($center);
                    goToShowAllAndShowSuccess("Centro añadido correctamente.", $universityData, $buildingData, $userData);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage(), $universityData, $buildingData, $userData);
                } catch (ValidationException $ve) {
                    goToShowAllAndShowError($ve->getMessage(), $universityData, $buildingData, $userData);
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para añadir.", $universityData, $buildingData, $userData);
        }
        break;
    case "show":
        if (checkPermission("centro", "SHOWCURRENT")) {
            try {
                $centerData = $centerDAO->show($centerPK, $value);
                new CenterShowView($centerData);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $universityData, $buildingData, $userData);
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage(), $universityData, $buildingData, $userData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso visualizar la entidad.", $universityData, $buildingData, $userData);
        }
        break;
        break;
    case "delete":
        if (checkPermission("centro", "DELETE")) {
            $center = $centerDAO->show($centerPK, $value);
            if(IsAdmin() || $center->getUniversidad() == IsUniversityOwner()) {
                if (isset($_REQUEST["confirm"])) {
                    try {
                        $centerDAO->delete($centerPK, $value);
                        goToShowAllAndShowSuccess("Centro eliminado correctamente.", $universityData, $buildingData, $userData);
                    } catch (DAOException $e) {
                        goToShowAllAndShowError($e->getMessage(), $universityData, $buildingData, $userData);
                    }
                } else {
                    try {
                        $centerDAO->checkDependencies($value);
                        showAll($universityData, $buildingData, $userData);
                        openDeletionModal("Eliminar centro", "¿Está seguro de que desea eliminar " .
                            "el centro %" . $center->getNombre() . "%? Esta acción es permanente y no se puede recuperar.",
                            "../controllers/centerController.php?action=delete&id=" . $value . "&confirm=true");
                    } catch (DAOException $e) {
                        goToShowAllAndShowError($e->getMessage(), $universityData, $buildingData, $userData);
                    }
                }
            } else {
                goToShowAllAndShowError("No tienes permiso para eliminar.", $universityData, $buildingData, $userData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.", $universityData, $buildingData, $userData);
        }
        break;
    case "edit":
        if (checkPermission("centro", "EDIT")) {
            try {
                $center = $centerDAO->show($centerPK, $value);
                if (!isset($_POST["submit"])) {
                    if(!IsAdmin()){
                        $universities=[];
                        foreach ($universityData as $university){
                            if($university->getUsuario()->getId() == getUserInSession()){
                                array_push($universities, $university);
                            }
                        }
                        $universityData = $universities;
                    }
                    if(IsAdmin() || $center->getUniversidad() == IsUniversityOwner()){
                        new CenterEditView($center, $universityData, $userData, $buildingData);
                    } else{
                        goToShowAllAndShowError("No tienes permiso para editar.", $universityData, $buildingData, $userData);
                    }

                } else {
                    $center->setId($value);
                    $center->setUniversidad($universityDAO->show("id", $_POST["idUniversidad"]));
                    $center->setUsuario($userDAO->show("login", $_POST["idUsuario"]));
                    $center->setNombre($_POST["nombre"]);
                    $center->setEdificio($buildingDAO->show("id", $_POST["idEdificio"]));
                    $universityDAO->edit($center);
                    goToShowAllAndShowSuccess("Centro editado correctamente.", $universityData, $buildingData, $userData);
                }
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $universityData, $buildingData, $userData);
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage(), $universityData, $buildingData, $userData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para editar.", $universityData, $buildingData, $userData);
        }
        break;
    case "search":
        if (checkPermission("centro", "SHOWALL")) {
            try {
                $center = $centerDAO->search($_POST["nombre"], $_POST["idUniversidad"], $_POST["idEdificio"], $_POST["idUsuario"]);
                $centers = array();

                foreach($center as $cen) {
                   array_push($centers, $centerDAO->show($centerPK, $cen["id"]));
                }

                showAllSearch($centers, $universityData, $buildingData, $userData);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $universityData, $buildingData, $userData);
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage(), $universityData, $buildingData, $userData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para buscar.", $rolesData, $funcActionData);
        }
        break;
    default:
        showAll($universityData, $buildingData, $userData);
        break;
}

function showAll($universityData, $buildingData, $userData) {
    showAllSearch(NULL, $universityData, $buildingData, $userData);
}

function showAllSearch($search, $universityData, $buildingData, $userData) {
    if (checkPermission("centro", "SHOWALL")) {
        try {
            $currentPage = getPage();
            $itemsPerPage = getNumberItems();
            $totalCenters = $GLOBALS["centerDAO"]->countTotalCenters();

            if ($search != NULL) {
                $centerData = $search;
                $totalCenters = count($centerData);
            } else {
                $centerData = $GLOBALS["centerDAO"]->showAllPaged($currentPage, $itemsPerPage, NULL);
            }
            new CenterShowAllView($centerData, $itemsPerPage, $currentPage, $totalCenters, $search, $universityData, $buildingData, $userData);
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

function goToShowAllAndShowError($message, $universityData, $buildingData, $userData) {
    showAll($universityData, $buildingData, $userData);
    include '../models/common/messageType.php';
    include '../utils/ToastTrigger.php';
    $messageType = MessageType::ERROR;
    showToast($messageType, $message);
}

function goToShowAllAndShowSuccess($message, $universityData, $buildingData, $userData) {
    showAll($universityData, $buildingData, $userData);
    include '../models/common/messageType.php';
    include '../utils/ShowToast.php';
    $messageType = MessageType::SUCCESS;
    showToast($messageType, $message);
}

?>