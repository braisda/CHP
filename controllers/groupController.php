<?php
session_start();
include_once '../utils/auth.php';
include_once '../utils/CheckPermission.php';

if (!IsAuthenticated()){
    header('Location:../index.php');
}

include_once '../utils/pagination.php';
include_once '../models/common/DAOException.php';
include_once '../models/group/groupDAO.php';
include_once '../models/subject/subjectDAO.php';
include_once '../views/common/head.php';
include_once '../views/common/headerMenu.php';
include_once '../views/common/paginationView.php';
include_once '../views/group/groupShowAllView.php';
include_once '../views/group/groupAddView.php';
include_once '../views/group/groupShowView.php';
include_once '../views/group/groupEditView.php';
include_once '../views/group/groupSearchView.php';
include_once '../utils/confirmDelete.php';

//DAOS
$groupDAO = new GroupDAO();
$subjectDAO = new SubjectDAO();

//Data required
$subjectData = $subjectDAO->showAll();

$groupPrimaryKey = "id";
$value = $_REQUEST[$groupPrimaryKey];

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (checkPermission("grupo", "ADD")) {
            if (!isset($_POST["submit"])) {
                new GroupAddView($subjectData);
            } else {
                try {
                    $group = new GrupoMateria();
                    $group->setIdmateria($_POST["subject"]);
                    $group->setNombre($_POST["name"]);
                    $groupDAO->add($group);
                    goToShowAllAndShowSuccess("Grupo añadido correctamente.", $subjectData);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage(), $subjectData);
                } catch (Exception $ve) {
                    goToShowAllAndShowError($ve->getMessage(), $subjectData);
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para añadir.", $subjectData);
        }
        break;
    case "delete":
        if (checkPermission("grupo", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $groupDAO->delete($groupPrimaryKey, $value);
                    goToShowAllAndShowSuccess("Grupo eliminado correctamente.", $subjectData);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage(), $subjectData);
                }
            } else {
                try {
                    $groupDAO->checkDependencies($value);
                    showAll($subjectData);
                    confirmDelete("Eliminar grupo", "¿Está seguro de que desea eliminar " .
                        "el grupo %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../controllers/groupController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage(), $subjectData);
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.", $subjectData);
        }
        break;
    case "show":
        if (checkPermission("grupo", "SHOWCURRENT")) {
            try {
                $groupData = $groupDAO->show($groupPrimaryKey, $value);
                new GroupShowView($groupData);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $subjectData);
            } catch (Exception $ve) {
                goToShowAllAndShowError($ve->getMessage(), $subjectData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para visualizar la entidad.", $subjectData);
        }
        break;
    case "edit":
        if (checkPermission("grupo", "EDIT")) {
            try {
                $group = $groupDAO->show($groupPrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new GroupEditView($group, $subjectData);
                } else {
                    $group->setId($value);
                    $group->setIdmateria($_POST["subject"]);
                    $group->setNombre($_POST["name"]);
                    $groupDAO->edit($group);
                    goToShowAllAndShowSuccess("Grupo editado correctamente.", $subjectData);
                }
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $subjectData);
            } catch (Exception $ve) {
                goToShowAllAndShowError($ve->getMessage(), $subjectData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para editar.", $subjectData);
        }
        break;
    case "search":
        if (checkPermission("grupo", "SHOWALL")) {
            try {
                $office = 0;
                if($_POST["office"] == "on"){
                    $office = 1;
                }
                $group = $groupDAO->search($_POST["subject_id"], $_POST["name"], $_POST["capacity"], $office);
                $groups = array();
                foreach($group as $s) {
                    array_push($groups, $groupDAO->show($groupPrimaryKey, $s["id"]));
                }
                showAllSearch($group, $subjectData);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $subjectData);
            } catch (Exception $ve) {
                goToShowAllAndShowError($ve->getMessage(), $subjectData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para buscar.", $subjectData);
        }
        break;
    default:
        showAll($subjectData);
        break;
}

function showAll($subjectData)
{
    showAllSearch(NULL, $subjectData);
}

function showAllSearch($search, $subjectData)
{
    if (checkPermission("grupo", "SHOWALL")) {
        try {
            $currentPage = getPage();
            $itemsPerPage = getNumberItems();
            $totalGroups = $GLOBALS["groupDAO"]->countTotalGroups();
            
            if ($search != NULL) {
                $groupsData = $GLOBALS["groupDAO"]->parseGroups($search);
                $totalGroups = count($groupsData);
            } else {
                $groupsData = $GLOBALS["groupDAO"]->showAllPaged($currentPage, $itemsPerPage);
            }
            new GroupShowAllView($groupsData, $subjectData, $itemsPerPage, $currentPage, $totalGroups, $search);
        } catch (DAOException $e) {
            include '../models/common/messageType.php';
            include '../utils/ShowToast.php';
            new GroupShowAllView(array(), $subjectData);
            $message = MessageType::ERROR;
            showToast($message, $e->getMessage());
        }
    } else {
        accessDenied();
    }
}

function goToShowAllAndShowError($message, $subjectData)
{
    showAll($subjectData);
    include '../models/common/messageType.php';
    include '../utils/ShowToast.php';
    $messageType = MessageType::ERROR;
    showToast($messageType, $message);
}

function goToShowAllAndShowSuccess($message, $subjectData)
{
    showAll($subjectData);
    include '../models/common/messageType.php';
    include '../utils/ShowToast.php';
    $messageType = MessageType::SUCCESS;
    showToast($messageType, $message);
}
