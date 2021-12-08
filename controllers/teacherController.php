<?php
session_start();
include_once '../utils/auth.php';
include_once '../utils/CheckPermission.php';

if (!IsAuthenticated()) {
    header('Location:../index.php');
}

include_once '../utils/pagination.php';
include_once '../utils/messages.php';
include_once '../utils/redirect.php';
include_once '../views/common/headerMenu.php';
include_once '../views/common/head.php';
include_once '../utils/openDeletionModal.php';
include_once '../models/teacher/teacherDAO.php';
include_once '../models/space/spaceDAO.php';
include_once '../models/user/userDAO.php';
include_once '../models/common/DAOException.php';
include_once '../views/common/paginationView.php';
include_once '../views/teacher/teacherShowAllView.php';
include_once '../views/teacher/teacherAddView.php';
include_once '../views/teacher/teacherShowView.php';
include_once '../views/teacher/teacherEditView.php';
$teacherDAO = new TeacherDAO();
$userDAO = new UserDAO();
$spaceDAO = new SpaceDAO();

$userData = $userDAO->showAll();
$spaceData = $spaceDAO->showAllFreeOffices();

$teacherPK = "id";
$value = $_REQUEST[$teacherPK];
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (checkPermission("profesor", "ADD")) {
            if (!isset($_POST["submit"])) {
                new TeacherAddView($userData, $spaceData);
            } else {
                try {
                    $teacher = new Profesor();
                    if(!empty($_POST["idespacio"])) {
                        $teacher->setEspacio($spaceDAO->show("id", $_POST["idespacio"]));
                    } else {
                        $teacher->setEspacio(new Espacio());
                    }
                    $teacher->setUsuario($userDAO->show("login", $_POST["idusuario"]));
                    $teacher->setDedicacion($_POST["dedicacion"]);
                    $teacherDAO->add($teacher);
                    goToShowAllAndShowSuccess("Profesor añadido correctamente.");
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
        if (checkPermission("profesor", "DELETE")) {
            $teacher = $teacherDAO->show($teacherPK, $value);
            if (isset($_REQUEST["confirm"])) {
                try {
                    $teacherDAO->delete($teacherPK, $value);
                    goToShowAllAndShowSuccess("Profesor eliminado correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    $teacherDAO->checkDependencies($value);
                    showAll();
                    openDeletionModal("Eliminar profesor", "¿Está seguro de que desea eliminar " .
                        "el profesor %" . $teacher->getUsuario()->getNombre() . "%? Esta acción es permanente y no se puede recuperar.",
                        "../controllers/teacherController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "show":
        if (checkPermission("profesor", "SHOWCURRENT")) {
            try {
                $teacherData = $teacherDAO->show($teacherPK, $value);
                new TeacherShowView($teacherData);
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
        if (checkPermission("profesor", "EDIT")) {
            try {
                $teacher = $teacherDAO->show($teacherPK, $value);
                if (!isset($_POST["submit"])) {
                    new TeacherEditView($teacher, $userData, $spaceData);
                } else {
                    $teacher->setId($value);
                    if (!empty($_POST["idespacio"])) {
                        $teacher->setEspacio($spaceDAO->show("id", $_POST["idespacio"]));
                    } else {
                        $teacher->setEspacio(new Espacio());
                    }
                    $teacher->setUsuario($userDAO->show("login", $_POST["idusuario"]));
                    $teacher->setDedicacion($_POST["dedicacion"]);
                    $teacherDAO->edit($teacher);
                    goToShowAllAndShowSuccess("Profesor editado correctamente.");
                }
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage());
            }
        } else{
            goToShowAllAndShowError("No tienes permiso para editar.");
        }
        break;
    case "search":
        if (checkPermission("profesor", "SHOWALL")) {
            try {
                $teacher = $teacherDAO->search($_POST["dni"], $_POST["nombre"], $_POST["login"], $_POST["dedicacion"]);
                $teachers = array();

                foreach($teacher as $te) {
                   array_push($teachers, $teacherDAO->show($teacherPK, $te["id"]));
                }

                showAllSearch($teachers);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $rolesData, $funcActionData);
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage(), $rolesData, $funcActionData);
            }
        } else {
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
    if (checkPermission("profesor", "SHOWALL")) {
        try {
            $page = getPage();
            $itemsInPage = getNumberItems();
            $totalTeachers = $GLOBALS["teacherDAO"]->countTotalTeachers();

            if ($search != NULL) {
                $teachersData = $search;
                $totalTeachers = count($data);
            } else {
                $teachersData = $GLOBALS["teacherDAO"]->showAllPaged($page, $itemsInPage);
            }

            new TeacherShowAllView($teachersData, $itemsInPage, $page, $totalTeachers, $search);
        } catch (DAOException $e) {
            new TeacherShowAllView(array());
            errorMessage($e->getMessage());
        }
    } else {
        accessDenied();
    }
}

function goToShowAllAndShowError($message) {
    showAll();
    errorMessage($message);
}

function goToShowAllAndShowSuccess($message) {
    showAll();
    successMessage($message);
}