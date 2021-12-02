<?php
session_start();
include_once '../utils/auth.php';
include_once '../utils/CheckPermission.php';

if (!IsAuthenticated()){
    header('Location:../index.php');
}

include_once '../utils/pagination.php';
include_once '../models/common/DAOException.php';
include_once '../models/university/universityDAO.php';
include_once '../models/academicCourse/academicCourseDAO.php';
include_once '../views/common/head.php';
include_once '../views/common/headerMenu.php';
include_once '../views/common/paginationView.php';
include_once '../views/university/universityShowAllView.php';
include_once '../views/university/universityAddView.php';
include_once '../views/university/universityShowView.php';
include_once '../views/university/universityEditView.php';
include_once '../views/university/universitySearchView.php';
include_once '../utils/confirmDelete.php';;
include_once '../utils/isUniversityOwner.php';
include_once '../utils/isAdmin.php';

//DAOS
$universityDAO = new UniversityDAO();
$academicCourseDAO = new AcademicCourseDAO();
$userDAO = new UserDAO();

//Data required
$academicCourseData = $academicCourseDAO->showAll();
$userData = $userDAO->showAll();

$universityPrimaryKey = "id";
$value = $_REQUEST[$universityPrimaryKey];

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (checkPermission("universidad", "ADD")) {
            if (!isset($_POST["submit"])) {
                new UniversityAddView($academicCourseData, $userData);
            } else {
                try {
                    $university = new Universidad();
                    $university->setIdCursoAcademico($_POST["academic_course_id"]);
                    $university->setidUsuario($_POST["user_id"]);
                    $university->setNombre($_POST["name"]);
                    $universityDAO->add($university);
                    goToShowAllAndShowSuccess("Universidad añadida correctamente.", $academicCourseData, $userData);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage(), $academicCourseData, $userData);
                } catch (Exception $ve) {
                    goToShowAllAndShowError($ve->getMessage(), $academicCourseData, $userData);
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para añadir.", $academicCourseData, $userData);
        }
        break;
    case "delete":
        if (checkPermission("universidad", "DELETE")) {
            $university = $universityDAO->show($universityPrimaryKey, $value);
            if (IsAdmin() || in_array($university, IsUniversityOwner())) {
                if (isset($_REQUEST["confirm"])) {
                    try {
                        $universityDAO->delete($universityPrimaryKey, $value);
                        goToShowAllAndShowSuccess("Universidad eliminada correctamente.", $academicCourseData, $userData);
                    } catch (DAOException $e) {
                        goToShowAllAndShowError($e->getMessage(), $academicCourseData, $userData);
                    }
                } else {
                    try {
                        $universityDAO->checkDependencies($value);
                        showAll($academicCourseData, $userData);
                        confirmDelete("Eliminar universidad", "¿Está seguro de que desea eliminar " .
                            "la universidad %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                            "../Controllers/UniversityController.php?action=delete&id=" . $value . "&confirm=true");
                    } catch (DAOException $e) {
                        goToShowAllAndShowError($e->getMessage(), $academicCourseData, $userData);
                    }
                }
            } else {
                goToShowAllAndShowError("No tienes permiso para eliminar.", $academicCourseData, $userData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.", $academicCourseData, $userData);
        }
        break;
    case "show":
        if (checkPermission("universidad", "SHOWCURRENT")) {
            try {
                $universityData = $universityDAO->show($universityPrimaryKey, $value);
                new UniversityShowView($universityData);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $academicCourseData, $userData);
            } catch (Exception $ve) {
                goToShowAllAndShowError($ve->getMessage(), $academicCourseData, $userData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para visualizar la entidad.", $academicCourseData, $userData);
        }
        break;
    case "edit":
        if (checkPermission("universidad", "EDIT")) {
            try {
                $university = $universityDAO->show($universityPrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    if (IsAdmin() || in_array($university, IsUniversityOwner())) {
                        new UniversityEditView($university, $academicCourseData, $userData);
                    } else {
                        goToShowAllAndShowError("No tienes permiso para editar.", $academicCourseData, $userData);
                    }
                } else {
                    $university->setId($value);
                    $university->setIdCursoAcademico($_POST["academic_course_id"]);
                    $university->setIdUsuario($_POST["user_id"]);
                    $university->setNombre($_POST["name"]);
                    $universityDAO->edit($university);
                    goToShowAllAndShowSuccess("Universidad editada correctamente.", $academicCourseData, $userData);
                }
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $academicCourseData, $userData);
            } catch (Exception $ve) {
                goToShowAllAndShowError($ve->getMessage(), $academicCourseData, $userData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para editar.", $academicCourseData, $userData);
        }
        break;
    case "search":
        if (checkPermission("universidad", "SHOWALL")) {
                try {
                    $university = $universityDAO->search($_POST["academic_course_id"], $_POST["name"], $_POST["user_id"]);
                    $universities = array();

                    foreach($university as $u) {
                        array_push($universities, $universityDAO->show($universityPrimaryKey, $u["id"]));
                    }
                    showAllSearch($university, $academicCourseData, $userData);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage(), $academicCourseData, $userData);
                } catch (Exception $ve) {
                    goToShowAllAndShowError($ve->getMessage(), $academicCourseData, $userData);
                }
        } else {
            goToShowAllAndShowError("No tienes permiso para buscar.", $academicCourseData, $userData);
        }
        break;
    default:
        showAll($academicCourseData, $userData);
        break;
}

function showAll($academicCourseData, $userData)
{
    showAllSearch(NULL, $academicCourseData, $userData);
}

function showAllSearch($search, $academicCourseData, $userData)
{
    if (checkPermission("universidad", "SHOWALL")) {
        try {
            $searching = False;
            $break = false;
            if (!empty($search)) {
                $searching = True;
            }
            if (!IsAdmin()) {
                $universities = IsUniversityOwner();
                if (!empty($universities)) {
                    $searching = False;
                } else {
                    new UniversityShowAllView(array(), array(), array());
                    $break = true;
                }

            }
            if (!$break) {
                $currentPage = getPage();
                $itemsPerPage = getNumberItems();
                $totalUniversities = 0;

                if ($search != NULL) {
                    $universitiesData = $GLOBALS["universityDAO"]->parseUniversities($search);
                    $totalUniversities = count($universitiesData);
                    new UniversityShowAllView($universitiesData, $academicCourseData, $userData, $itemsPerPage, $currentPage, $totalUniversities, NULL, $searching);
                } else {
                    if (!empty($universities) && count($universities) == 1) {
                        $search = $universities[0];
                        $totalUniversities = $GLOBALS["universityDAO"]->countTotalUniversities(NULL);
                        $universitiesData = $GLOBALS["universityDAO"]->showAllPaged($currentPage, $itemsPerPage, NULL);
                        new UniversityShowAllView($universitiesData, $academicCourseData, $userData, $itemsPerPage, $currentPage, $totalUniversities, NULL, $searching);
                    } elseif (count($universities) > 1) {
                        $universitiesData = array();
                        foreach ($universities as $uni) {
                            $search = $uni;
                            $totalUniversities += $GLOBALS["universityDAO"]->countTotalUniversities(NULL);
                            $data = $GLOBALS["universityDAO"]->showAllPaged($currentPage, $itemsPerPage, NULL);
                            foreach ($data as $dat) {
                                array_push($universitiesData, $dat);
                            }
                        }
                        new UniversityShowAllView($universitiesData, $academicCourseData, $userData, $itemsPerPage, $currentPage, $totalUniversities, NULL, $searching);
                    } else {
                        $totalUniversities = $GLOBALS["universityDAO"]->countTotalUniversities(NULL);
                        $universitiesData = $GLOBALS["universityDAO"]->showAllPaged($currentPage, $itemsPerPage, NULL);
                        new UniversityShowAllView($universitiesData, $academicCourseData, $userData, $itemsPerPage, $currentPage, $totalUniversities, NULL, $searching);
                    }
                }
            }
        } catch (DAOException $e) {
            new UniversityShowAllView(array(), array(), array());
            errorMessage($e->getMessage());
        }
    } else {
        accessDenied();
    }
}

function goToShowAllAndShowError($message, $academicCourseData, $userData)
{
    showAll($academicCourseData, $userData);
    include '../models/common/messageType.php';
    include '../utils/ShowToast.php';
    $messageType = MessageType::ERROR;
    showToast($messageType, $message);
}

function goToShowAllAndShowSuccess($message, $academicCourseData, $userData)
{
    showAll($academicCourseData, $userData);
    include '../models/common/messageType.php';
    include '../utils/ShowToast.php';
    $messageType = MessageType::SUCCESS;
    showToast($messageType, $message);
}
