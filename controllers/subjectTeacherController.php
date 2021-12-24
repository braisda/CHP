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
include_once '../models/subject/subjectDAO.php';
include_once '../models/teacher/teacherDAO.php';
include_once '../models/subjectTeacher/subjectTeacherDAO.php';
include_once '../utils/isAdmin.php';
include_once '../utils/isDepartmentOwner.php';
include_once '../utils/confirmDelete.php';
include_once '../utils/openDeletionModal.php';
include_once '../views/subjectTeacher/subjectTeacherShowAllView.php';
include_once '../views/subjectTeacher/subjectTeacherAddView.php';
include_once '../views/subjectTeacher/subjectTeacherEditView.php';

$subjectTeacherDAO = new SubjectTeacherDAO();
$teacherDAO = new TeacherDAO();
$subjectDAO = new SubjectDAO();

$teacherData = $teacherDAO->showAll();
$subjectTeacherPK = "id";
$value = $_REQUEST[$subjectTeacherPK];
$subject = $_REQUEST["subject_id"];
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (checkPermission("materiaprofesor", "ADD")) {
            if (!isset($_POST["submit"])) {
                new SubjectTeacherAddView($teacherData, $subject);
            } else {
                try {
                    $subjectTeacher = new Materia_profesor();
                    $subjectTeacher->setHoras($_POST["hours"]);
                    $subjectTeacher->setProfesor($teacherDAO->show("id",$_POST["teacher_id"]));
                    $subjectTeacher->setMateria($subjectDAO->show("id", $subject));
                    $subjectTeacherDAO->add($subjectTeacher);
                    goToShowAllAndShowSuccess("Profesor añadido correctamente.");
                } catch (DAOException $e) {
                    print_r($e->getMessage());
                    goToShowAllAndShowError($e->getMessage());
                } catch (ValidationException $ve) {
                    goToShowAllAndShowError($ve->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para añadir.");
        }
        break;
    case "edit":
        if (checkPermission("materiaprofesor", "EDIT")) {
            try {
                $subjectTeacher = $subjectTeacherDAO->show($subjectTeacherPK, $value);
                if (!isset($_POST["submit"])) {
                    new SubjectTeacherEditView($subjectTeacher, $teacherData, $subject);
                } else {
                    $subjectTeacher->setId($value);
                    $subjectTeacher->setHoras($_POST["hours"]);
                    $subjectTeacher->setProfesor($teacherDAO->show("id",$_POST["teacher_id"]));
                    $subjectTeacher->setMateria($subjectDAO->show("id", $subject));
                    $subjectTeacherDAO->edit($subjectTeacher);
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
    case "delete":
        if (checkPermission("materiaprofesor", "DELETE")) {
            $prof = $subjectTeacherDAO->show($subjectTeacherPK, $value);
            if (isset($_REQUEST["confirm"])) {
                try {
                    $subjectTeacherDAO->delete($subjectTeacherPK, $value, $prof->getMateria()->getId());
                    goToShowAllAndShowSuccess("Profesor eliminado correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    $subjectTeacherDAO->checkDependencies($value);
                    showAll();
                    openDeletionModal("Eliminar profesor", "¿Está seguro de que desea eliminar " .
                        "el profesor %" . $prof->getProfesor()->getUsuario()->getNombre() . "% de esta materia? Esta acción es permanente y no se puede recuperar.",
                        "../controllers/subjectTeacherController.php?action=delete&id=" . $value . "&confirm=true&subject_id=" . $subject);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    default:
        showAll();
        break;
}

function showAll() {
    $subjectTeacher = new Materia_profesor();
    $subjectTeacher->setMateria($GLOBALS["subjectDAO"]->show("id", $GLOBALS["subject"]));
    showAllSearch($subjectTeacher);
}

function showAllSearch($search) {
    if (checkPermission("materiaprofesor", "SHOWALL")) {
        try {
            $permission = (IsAdmin() or IsDepartmentOwner() or $search->getMateria()->getProfesor()->getUsuario()->getLogin() == getUserInSession());

            $currentPage = getPage();
            $itemsPerPage = getNumberItems();
            $totalTeachers = $GLOBALS["subjectTeacherDAO"]->countTotalSubjectTeachers();
            $teachersData = $GLOBALS["subjectTeacherDAO"]->showAllPaged($currentPage, $itemsPerPage);

            new SubjectTeacherShowAllView($teachersData, $itemsPerPage, $currentPage, $totalTeachers, $search, $search->getMateria(), $permission);
        } catch (DAOException $e) {
            new SubjectTeacherShowAllView(array());
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
?>