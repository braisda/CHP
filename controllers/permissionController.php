<?php
session_start();
include_once '../utils/auth.php';
include_once '../utils/CheckPermission.php';

if (!IsAuthenticated()){
    header('Location:../index.php');
}

include_once '../utils/pagination.php';
include_once '../views/common/headerMenu.php';
include_once '../views/common/head.php';
include_once '../models/permission/permissionDAO.php';
include_once '../models/funcAction/funcActionDAO.php';
include_once '../models/role/roleDAO.php';
include_once '../views/common/paginationView.php';
include_once '../views/permission/permissionShowAllView.php';
include_once '../views/permission/permissionShowView.php';
include_once '../views/permission/permissionEditView.php';
include_once '../views/permission/permissionAddView.php';
include_once '../views/permission/permissionSearchView.php';
include_once '../utils/redirect.php';
include_once '../utils/openDeletionModal.php';
include_once '../utils/messages.php';

$permissionDAO = new PermissionDAO();
$roleDAO = new RoleDAO();
$funcActionDAO = new FuncActionDAO();

$rolesData = $roleDAO->showAll();
$funcActionData = $funcActionDAO->showAll();
$permissionPK = "id";
$value = $_REQUEST[$permissionPK];
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";

switch($action) {
    case "show":
        if (checkPermission("Permission", "SHOWCURRENT")) {
           try {
                $permissionData = $permissionDAO->show($permissionPK, $value);
                new PermissionShowView($permissionData);
           } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $rolesData, $funcActionData);
           } catch (Exception $e) {
                goToShowAllAndShowError($e->getMessage(), $rolesData, $funcActionData);
           }
        } else {
            goToShowAllAndShowError("No tienes permiso para ver.", $rolesData, $funcActionData);
        }
        break;
    case "edit":
        if (checkPermission("Permission", "EDIT")) {
            try {
                $permissionData = $permissionDAO->show($permissionPK, $value);
                if (!isset($_POST["submit"])) {
                    new PermissionEditView($permissionData, $rolesData, $funcActionData);
                } else {
                    $permissionData->setId($value);
                    $permissionData->setRol($roleDAO->show("id", $_POST["idRol"]));
                    $permissionData->setFuncAccion($funcActionDAO->show("id", $_POST["idFuncAccion"]));
                    $permissionDAO->edit($permissionData);
                    goToShowAllAndShowSuccess("Permiso modificado correctamente.", $rolesData, $funcActionData);
                }
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $rolesData, $funcActionData);
            } catch (Exception $e) {
                goToShowAllAndShowError($e->getMessage(), $rolesData, $funcActionData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para editar.", $rolesData, $funcActionData);
        }
        break;
    case "delete":
        if (checkPermission("Permission", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $permissionDAO->delete($permissionPK, $value);
                    goToShowAllAndShowSuccess("Permiso eliminado correctamente.", $rolesData, $funcActionData);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage(), $rolesData, $funcActionData);
                }
            } else {
                try {
                    $permissionDAO->checkDependencies($value);
                    showAll($rolesData, $funcActionData);
                    openDeletionModal("Eliminar permiso", "¿Está seguro de que desea eliminar " .
                    "el permiso %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                    "../controllers/permissionController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage(), $rolesData, $funcActionData);
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.", $rolesData, $funcActionData);
        }
        break;
    case "add":
        if (checkPermission("Permission", "ADD")) {
            if (!isset($_POST["submit"])) {
                new PermissionAddView($rolesData, $funcActionData);
            } else {
                try {
                    $permission = new Permiso();
                    $permission->setRol($roleDAO->show("id", $_POST["idRol"]));
                    $permission->setFuncAccion($funcActionDAO->show("id", $_POST["idFuncAccion"]));
                    $permissionDAO->add($permission);
                    goToShowAllAndShowSuccess("Permiso añadido correctamente.", $rolesData, $funcActionData);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                } catch (Exception $ve) {
                    goToShowAllAndShowError($ve->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para añadir.", $rolesData, $funcActionData);
        }
        break;
    case "search":
        if (checkPermission("Permission", "SHOWALL")) {
            try {
                $permission = $permissionDAO->search($_POST["idRol"], $_POST["idFuncAccion"]);
                $permissions = array();

                foreach($permission as $per) {
                   array_push($permissions, $permissionDAO->show($permissionPK, $per["id"]));
                }

                showAllSearch($permissions, $rolesData, $funcActionData);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $rolesData, $funcActionData);
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage(), $rolesData, $funcActionData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para buscar.", $rolesData, $funcActionData);
        }
        break;
    default:
        showAll($rolesData, $funcActionData);
        break;
}

function showAll($rolesData, $funcActionData) {
    showAllSearch(NULL, $rolesData, $funcActionData);
}

function showAllSearch($search, $rolesData, $funcActionData) {
    if (checkPermission("Permission", "SHOWALL")) {
        try {

            $page = getPage();
            $itemsInPage = getNumberItems();
            $totalPermissions = $GLOBALS["permissionDAO"]->countTotalPermissions($toSearch);

            if ($search != NULL) {
                $data = $search;
                $totalPermissions = count($data);
            } else {
                $data = $GLOBALS["permissionDAO"]->showAllPaged($page, $itemsInPage, NULL);
            }

            new PermissionShowAllView($data, $itemsInPage, $page, $totalPermissions, $search, $rolesData, $funcActionData);
        } catch (DAOException $e) {
            new PermissionShowAllView(array());
            errorMessage($e->getMessage());
        }
    } else {
        accessDenied();
    }
}

function goToShowAllAndShowError($message, $rolesData, $funcActionData) {
    showAll($rolesData, $funcActionData);
    errorMessage($message);
}

function goToShowAllAndShowSuccess($message, $rolesData, $funcActionData) {
    showAll($rolesData, $funcActionData);
    successMessage($message);
}