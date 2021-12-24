<?php

session_start();
include_once '../utils/auth.php';
include_once '../utils/CheckPermission.php';

if (!IsAuthenticated()) {
    header('Location:../index.php');
}

include_once '../utils/pagination.php';
include_once '../models/common/DAOException.php';
include_once '../models/center/centerDAO.php';
include_once '../models/user/userDAO.php';
include_once '../models/degree/degreeDAO.php';
include_once '../views/common/head.php';
include_once '../views/common/headerMenu.php';
include_once '../views/common/paginationView.php';
include_once '../utils/confirmDelete.php';
include_once '../utils/openDeletionModal.php';
include_once '../views/degree/degreeShowAllView.php';
include_once '../views/degree/degreeAddView.php';
include_once '../views/degree/degreeShowView.php';
include_once '../views/degree/degreeEditView.php';
include_once '../utils/userInSession.php';
include_once '../utils/isAdmin.php';
include_once '../utils/isCenterOwner.php';
include_once '../utils/isDegreeOwner.php';

$centerDAO = new CenterDAO();
$degreeDAO = new DegreeDAO();
$userDAO = new UserDAO();

$centerData = $centerDAO->showAll();
$userData = $userDAO->showAll();

$degreePK = "id";
$value = $_REQUEST[$degreePK];
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (checkPermission("grado", "ADD")) {
            if (!isset($_POST["submit"])) {
                if(!IsAdmin()){
                    $centers=[];
                    foreach ($centerData as $center){
                        if($center->getUsuario()->getId() == getUserInSession()){
                            array_push($centers,$center);
                        }
                    }
                    $centerData=$centers;

                }
                new DegreeAddView($centerData, $userData);
            } else {
                try {
                    $degree = new Grado();
                    $degree->setNombre($_POST["nombre"]);
                    $degree->setCentro($centerDAO->show("id", $_POST["idCentro"]));
                    $degree->setCapacidad($_POST["plazas"]);
                    $degree->setDescripcion($_POST["descripcion"]);
                    $degree->setCreditos($_POST["creditos"]);
                    $degree->setUsuario($userDAO->show("login", $_POST["idUsuario"]));
                    $degreeDAO->add($degree);
                    goToShowAllAndShowSuccess("Titulación añadida correctamente.", $userData, $centerData);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage(), $userData, $centerData);
                } catch (ValidationException $ve) {
                    goToShowAllAndShowError($ve->getMessage(), $userData, $centerData);
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para añadir.", $userData, $centerData);
        }
        break;
    case "show":
         if (checkPermission("grado", "SHOWCURRENT")) {
             try {
                 $degreeData = $degreeDAO->show($degreePK, $value);
                 new DegreeShowView($degreeData);
             } catch (DAOException $e) {
                 goToShowAllAndShowError($e->getMessage(), $userData, $centerData);
             } catch (ValidationException $ve) {
                 goToShowAllAndShowError($ve->getMessage(), $userData, $centerData);
             }
         } else {
             goToShowAllAndShowError("No tienes permiso visualizar la entidad.", $userData, $centerData);
         }
        break;
    case "delete":
        if (checkPermission("grado", "DELETE")) {
            $degree = $degreeDAO->show($degreePK, $value);
            if(IsAdmin() || $degree->getCenter() == IsCenterOwner()) {
                if (isset($_REQUEST["confirm"])) {
                    try {
                        $degreeDAO->delete($degreePK, $value);
                        goToShowAllAndShowSuccess("Titulación eliminada correctamente.", $userData, $centerData);
                    } catch (DAOException $e) {
                        goToShowAllAndShowError($e->getMessage(), $userData, $centerData);
                    }
                } else {
                    try {
                        $degreeDAO->checkDependencies($value);
                        showAll($userData, $centerData);
                        openDeletionModal("Eliminar titulación", "¿Está seguro de que desea eliminar " .
                            "la titulación %" . $degree->getNombre()  . "%? Esta acción es permanente y no se puede recuperar.",
                            "../controllers/degreeController.php?action=delete&id=" . $value . "&confirm=true");
                    } catch (DAOException $e) {
                        goToShowAllAndShowError($e->getMessage(), $userData, $centerData);
                    }
                }
            }else {
                goToShowAllAndShowError("No tienes permiso para eliminar.", $userData, $centerData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.", $userData, $centerData);
        }
           break;
    case "edit":
        if (checkPermission("grado", "EDIT")) {
            try {
                $degree = $degreeDAO->show($degreePK, $value);
                if (!isset($_POST["submit"])) {
                    if(!IsAdmin()){
                        $centers=[];
                        foreach ($centerData as $center){
                            if($center->getUsuario()->getId() == getUserInSession()){
                                array_push($centers,$center);
                            }
                        }
                        $centerData=$centers;
                    }
                    if(IsAdmin() || $degree->getCenter() == IsCenterOwner() || $degree == IsDegreeOwner()){
                        new DegreeEditView($degree, $centerData, $userData);
                    } else{
                        goToShowAllAndShowError("No tienes permiso para editar.", $userData, $centerData);
                    }
                } else {
                    $degree->setNombre($_POST["nombre"]);
                    $degree->setCentro($centerDAO->show("id", $_POST["idCentro"]));
                    $degree->setCapacidad($_POST["plazas"]);
                    $degree->setDescripcion($_POST["descripcion"]);
                    $degree->setCreditos($_POST["creditos"]);
                    $degree->setUsuario($userDAO->show("login", $_POST["idUsuario"]));
                    $degreeDAO->edit($degree);
                    goToShowAllAndShowSuccess("Titulación editada correctamente.",$userData, $centerData);
                }
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $userData, $centerData);
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage(), $userData, $centerData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para editar.", $userData, $centerData);
        }
        break;
    case "search":
        if (checkPermission("grado", "SHOWALL")) {
            try {
                $degree = $degreeDAO->search($_POST["nombre"], $_POST["idCentro"], $_POST["plazas"], $_POST["creditos"], $_POST["idUsuario"]);
                $degrees = array();

                foreach($degree as $deg) {
                   array_push($degrees, $degreeDAO->show($degreePK, $deg["id"]));
                }

                showAllSearch($degrees, $userData, $centerData);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $userData, $centerData);
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage(), $userData, $centerData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para buscar.", $userData, $centerData);
        }
        break;
    default:
        showAll($userData, $centerData);
        break;
}

function showAll($users, $centers) {
    showAllSearch(NULL, $users, $centers);
}

function showAllSearch($search, $users, $centers) {
    if (checkPermission("grado", "SHOWALL")) {
        try {
            $currentPage = getPage();
            $itemsPerPage = getNumberItems();
            $totalDegrees = $GLOBALS["degreeDAO"]->countTotalDegrees();

            if ($search != NULL) {
                $degreesData = $search;
                $totalDegrees = count($degreesData);
            } else {
                $degreesData = $GLOBALS["degreeDAO"]->showAllPaged($currentPage, $itemsPerPage);
            }
            new DegreeShowAllView($degreesData, $itemsPerPage, $currentPage, $totalDegrees, $search, $users, $centers);
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

function goToShowAllAndShowError($message, $users, $centers) {
    showAll($users, $centers);
    include '../models/common/messageType.php';
    include '../utils/ShowToast.php';
    $messageType = MessageType::ERROR;
    showToast($messageType, $message);
}

function goToShowAllAndShowSuccess($message, $users, $centers) {
    showAll($users, $centers);
    include '../models/common/messageType.php';
    include '../utils/ShowToast.php';
    $messageType = MessageType::SUCCESS;
    showToast($messageType, $message);
}

?>