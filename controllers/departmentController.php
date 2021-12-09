<?php
session_start();
include_once '../utils/auth.php';
include_once '../utils/CheckPermission.php';

if (!IsAuthenticated()){
    header('Location:../index.php');
}

include_once '../utils/pagination.php';
include_once '../models/common/DAOException.php';
include_once '../models/department/departmentDAO.php';
include_once '../models/teacher/teacherDAO.php';
include_once '../views/common/head.php';
include_once '../views/common/headerMenu.php';
include_once '../views/common/paginationView.php';
include_once '../views/department/departmentShowAllView.php';
include_once '../views/department/departmentAddView.php';
include_once '../views/department/departmentShowView.php';
include_once '../views/department/departmentEditView.php';
include_once '../views/department/departmentSearchView.php';
include_once '../utils/confirmDelete.php';

//DAOS
$departmentDAO = new DepartmentDAO();
$teacherDAO = new TeacherDAO();

//Data required
$teacherData = $teacherDAO->showAll();

$departmentPrimaryKey = "id";
$value = $_REQUEST[$departmentPrimaryKey];

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (checkPermission("departamento", "ADD")) {
            if (!isset($_POST["submit"])) {
                new DepartmentAddView($teacherData);
            } else {
                try {
                    $department = new Departamento();
                    $department->setCodigo($_POST["code"]);
                    $department->setidProfesor($_POST["teacher_id"]);
                    $department->setNombre($_POST["name"]);
                    $departmentDAO->add($department);
                    goToShowAllAndShowSuccess("Departamento añadido correctamente.", $teacherData);
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
        if (checkPermission("departamento", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $departmentDAO->delete($departmentPrimaryKey, $value);
                    goToShowAllAndShowSuccess("Departamento eliminado correctamente.", $teacherData);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage(), $teacherData);
                }
            } else {
                try {
                    $departmentDAO->checkDependencies($value);
                    showAll($teacherData);
                    confirmDelete("Eliminar departamento", "¿Está seguro de que desea eliminar " .
                        "el departamento %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../controllers/departmentController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage(), $teacherData);
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.", $teacherData);
        }
        break;
    case "show":
        if (checkPermission("departamento", "SHOWCURRENT")) {
            try {
                $departmentData = $departmentDAO->show($departmentPrimaryKey, $value);
                new DepartmentShowView($departmentData);
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
        if (checkPermission("departamento", "EDIT")) {
            try {
                $department = $departmentDAO->show($departmentPrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new DepartmentEditView($department, $teacherData);
                } else {
                    $department->setId($value);
                    $department->setCodigo($_POST["code"]);
                    $department->setIdprofesor($_POST["teacher_id"]);
                    $department->setNombre($_POST["name"]);
                    $departmentDAO->edit($department);
                    goToShowAllAndShowSuccess("Departamento editado correctamente.", $teacherData);
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
        if (checkPermission("departamento", "SHOWALL")) {
            try {
                $department = $departmentDAO->search($_POST["teacher_id"], $_POST["code"], $_POST["name"]);
                $departments = array();
                foreach($department as $dep) {
                    array_push($departments, $departmentDAO->show($departmentPrimaryKey, $dep["id"]));
                }
                showAllSearch($departments, $teacherData);
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
    if (checkPermission("departamento", "SHOWALL")) {
        try {
            $currentPage = getPage();
            $itemsPerPage = getNumberItems();
            $totalDepartments = $GLOBALS["departmentDAO"]->countTotalDepartments();
            
            if ($search != NULL) {
                $departmentsData = $GLOBALS["departmentDAO"]->parseDepartments($search);
                $totalDepartments = count($departmentsData);
            } else {
                $departmentsData = $GLOBALS["departmentDAO"]->showAllPaged($currentPage, $itemsPerPage);
            }
            new DepartmentShowAllView($departmentsData, $teacherData, $itemsPerPage, $currentPage, $totalDepartments, $search);
        } catch (DAOException $e) {
            include '../models/common/messageType.php';
            include '../utils/ShowToast.php';
            new DepartmentShowAllView(array(), $teacherData);
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
