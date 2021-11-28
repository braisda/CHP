<?php
session_start();
include_once '../utils/auth.php';
include_once '../utils/CheckPermission.php';

if (!IsAuthenticated()){
    header('Location:../index.php');
}

include_once '../utils/pagination.php';
include_once '../models/academicCourse/academicCourseDAO.php';
include_once '../models/common/DAOException.php';
include_once '../views/Common/head.php';
include_once '../views/Common/headerMenu.php';
include_once '../views/common/paginationView.php';
include_once '../views/academicCourse/academicCourseShowAllView.php';
include_once '../views/academicCourse/academicCourseAddView.php';
include_once '../views/academicCourse/academicCourseShowView.php';
include_once '../views/academicCourse/academicCourseEditView.php';
include_once '../views/academicCourse/academicCourseSearchView.php';
include_once '../utils/confirmDelete.php';

//DAO
$academicCourseDAO = new AcademicCourseDAO();

$academicCoursePrimaryKey = "id";
$value = $_REQUEST[$academicCoursePrimaryKey];

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch($action) {
    case "add":
        if (checkPermission("Academiccurso", "ADD")) {
            if (!isset($_POST["submit"])) {
                new AcademicCourseAddView();
            } else {
                try {
                    $academicCourse = new CursoAcademico(NULL,
                        NULL, $_POST["anoinicio"], $_POST["anofin"]);
                    $academicCourseDAO->add($academicCourse);
                    goToShowAllAndShowSuccess("Curso académico añadido correctamente.");
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
        if (checkPermission("Academiccurso", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $academicCourseDAO->delete($academicCoursePrimaryKey, $value);
                    goToShowAllAndShowSuccess("Curso académico eliminado correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    $academicCourse = $academicCourseDAO->show($academicCoursePrimaryKey, $value);
                    //$academicCourseDAO->checkDependencies($value);
                    showAll();
                    confirmDelete("Eliminar curso académico", "¿Está seguro de que desea eliminar" .
                    " el curso académico %" . $academicCourse->getNombre() .
                    "%? Esta acción es permanente y no se puede recuperar.",
                    "../controllers/academicCourseController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                } catch (Exception $ve) {
                    goToShowAllAndShowError($ve->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "show":
        if (checkPermission("Academiccurso", "SHOWCURRENT")) {
            try {
                $academicCourseData = $academicCourseDAO->show($academicCoursePrimaryKey, $value);
                new AcademicCourseShowView($academicCourseData);
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
        if (checkPermission("Academiccurso", "EDIT")) {
            try {
                $academicCourse = $academicCourseDAO->show($academicCoursePrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new AcademicCourseEditView($academicCourse);
                } else {
                    $academicCourse->setId($value);
                    $academicCourse->isCorrectAcademicCourse($_POST["anoinicio"], $_POST["anofin"]);
                    $academicCourse->setAnoinicio($_POST["anoinicio"]);
                    $academicCourse->setAnofin($_POST["anofin"]);
                    $academicCourse->setNombre($academicCourse->formatAbbr($_POST["anoinicio"], $_POST["anofin"]));
                    $academicCourseDAO->edit($academicCourse);
                    goToShowAllAndShowSuccess("Curso académico editado correctamente.");
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
        if(checkPermission("Academiccurso", "SHOWALL")) {
            if (!isset($_POST["submit"])) {
                new AcademicCourseSearchView();
            } else {
                try {
                    $academicCourse = new AcademicCourse();
                    if (!empty($_POST["anoinicio"]) && !empty($_POST["anofin"])) {
                        $academicCourse->isCorrectAcademicCourse($_POST["anoinicio"], $_POST["anofin"]);
                    }
                    if (!empty($_POST["anoinicio"])) {
                        $academicCourse->setStartYear($_POST["anoinicio"]);
                    }
                    if (!empty($_POST["anofin"])) {
                        $academicCourse->setEndYear($_POST["anofin"]);
                    }
                    if (!empty($_POST["nombre"])) {
                        $academicCourse->setAcademicCourseAbbr($_POST["nombre"]);
                    }
                    showAllSearch($academicCourse);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                } catch (Exception $ve) {
                    goToShowAllAndShowError($ve->getMessage());
                }
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
    if (checkPermission("Academiccurso", "SHOWALL")) {
        try {
            $currentPage = getPage();
            $itemsPerPage = getNumberItems();
            $toSearch = getToSearch($search);
            $totalAcademicCourses = $GLOBALS["academicCourseDAO"]->countTotalAcademicCourses($toSearch);
            $academicCoursesData = $GLOBALS["academicCourseDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
            new AcademicCourseShowAllView($academicCoursesData, $itemsPerPage, $currentPage, $totalAcademicCourses, $toSearch);
        } catch (DAOException $e) {
            new AcademicCourseShowAllView(array());
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