<?php
session_start();
include_once '../utils/auth.php';
include_once '../utils/CheckPermission.php';

if (!IsAuthenticated()){
    header('Location:../index.php');
}

include_once '../utils/pagination.php';
include_once '../models/common/DAOException.php';
include_once '../models/tutorial/tutorialDAO.php';
include_once '../models/teacher/teacherDAO.php';
include_once '../views/common/head.php';
include_once '../views/common/headerMenu.php';
include_once '../views/common/paginationView.php';
include_once '../views/tutorial/tutorialShowAllView.php';
include_once '../views/tutorial/tutorialAddView.php';
include_once '../views/tutorial/tutorialShowView.php';
include_once '../views/tutorial/tutorialEditView.php';
include_once '../views/tutorial/tutorialSearchView.php';
include_once '../utils/confirmDelete.php';;
include_once '../utils/isTutorialOwner.php';
include_once '../utils/isAdmin.php';

//DAOS
$tutorialDAO = new TutorialDAO();
$teacherDAO = new TeacherDAO();

//Data required
$teacherData = $teacherDAO->showAll();

$tutorialPrimaryKey = "idtutoria";
$value = $_REQUEST[$tutorialPrimaryKey];

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (checkPermission("tutoria", "ADD")) {
            if (!isset($_POST["submit"])) {
                new TutorialAddView($teacherData);
            } else {
                try {
                    $tutorial = new Tutoria();
                    $tutorial->setIdprofesor($_POST["teacher_id"]);
                    $tutorial->setFechainicio($_POST["start_date"]);
                    $tutorial->setFechafin($_POST["end_date"]);
                    $tutorialDAO->add($tutorial);
                    goToShowAllAndShowSuccess("Tutoria añadida correctamente.", $teacherData);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage(), $teacherData);
                } catch (Exception $ve) {
                    goToShowAllAndShowError($ve->getMessage(), $teacherData);
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para añadir.", $teacherData);
        }
        break;
    case "delete":
        if (checkPermission("tutoria", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $tutorialDAO->delete($tutorialPrimaryKey, $value);
                    goToShowAllAndShowSuccess("Tutoria eliminada correctamente.", $teacherData);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage(), $teacherData);
                }
            } else {
                try {
                    $tutorialDAO->checkDependencies($value);
                    showAll($teacherData);
                    confirmDelete("Eliminar tutoría", "¿Está seguro de que desea eliminar " .
                        "la tutoría %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../controllers/tutorialController.php?action=delete&idtutoria=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage(), $teacherData);
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.", $teacherData);
        }
        break;
    case "show":
        if (checkPermission("tutoria", "SHOWCURRENT")) {
            try {
                $tutorialData = $tutorialDAO->show($tutorialPrimaryKey, $value);
                new TutorialShowView($tutorialData);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $teacherData);
            } catch (Exception $ve) {
                goToShowAllAndShowError($ve->getMessage(), $teacherData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para visualizar la entidad.", $teacherData);
        }
        break;
    case "edit":
        if (checkPermission("tutoria", "EDIT")) {
            try {
                $tutorial = $tutorialDAO->show($tutorialPrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new TutorialEditView($tutorial, $teacherData);
                } else {
                    $tutorial->setIdtutoria($value);
                    $tutorial->setIdprofesor($_POST["teacher_id"]);
                    $tutorial->setFechainicio($_POST["start_date"]);
                    $tutorial->setFechafin($_POST["end_date"]);
                    $tutorialDAO->edit($tutorial);
                    goToShowAllAndShowSuccess("Tutoria editada correctamente.", $teacherData);
                }
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $teacherData);
            } catch (Exception $ve) {
                goToShowAllAndShowError($ve->getMessage(), $teacherData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para editar.", $teacherData);
        }
        break;
    case "search":
        if (checkPermission("tutoria", "SHOWALL")) {
            try {
                $tutorial = $tutorialDAO->search($_POST["teacher_id"], $_POST["start_date"], $_POST["end_date"]);
                $tutorials = array();
                
                foreach($tutorial as $tut) {
                    array_push($tutorials, $tutorialDAO->show($tutorialPrimaryKey, $tut["idtutoria"]));
                }
                showAllSearch($tutorial, $teacherData);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $teacherData);
            } catch (Exception $ve) {
                goToShowAllAndShowError($ve->getMessage(), $teacherData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para buscar.", $teacherData);
        }
        break;
    default:
        showAll($teacherData);
        break;
}

function showAll($teacherData)
{
    showAllSearch(NULL, $teacherData);
}

function showAllSearch($search, $teacherData)
{
    if (checkPermission("tutoria", "SHOWALL")) {
        try {
            $currentPage = getPage();
            $itemsPerPage = getNumberItems();
            $totalTutorials = $GLOBALS["tutorialDAO"]->countTotalTutorials();
            
            if ($search != NULL) {
                $tutorialsData = $GLOBALS["tutorialDAO"]->parseTutorials($search);
                $totalTutorials = count($tutorialsData);
            } else {
                $tutorialsData = $GLOBALS["tutorialDAO"]->showAllPaged($currentPage, $itemsPerPage);
                printf("dsasdfsdfasdfasdf");
            }
            new TutorialShowAllView($tutorialsData, $teacherData, $itemsPerPage, $currentPage, $totalTutorials, $search);
        } catch (DAOException $e) {
            include '../models/common/messageType.php';
            include '../utils/ShowToast.php';
            new TutorialShowAllView(array(), $teacherData);
            $message = MessageType::ERROR;
            showToast($message, $e->getMessage());
        }
    } else {
        accessDenied();
    }
}

function goToShowAllAndShowError($message, $teacherData)
{
    showAll($teacherData);
    include '../models/common/messageType.php';
    include '../utils/ShowToast.php';
    $messageType = MessageType::ERROR;
    showToast($messageType, $message);
}

function goToShowAllAndShowSuccess($message, $teacherData)
{
    showAll($teacherData);
    include '../models/common/messageType.php';
    include '../utils/ShowToast.php';
    $messageType = MessageType::SUCCESS;
    showToast($messageType, $message);
}
