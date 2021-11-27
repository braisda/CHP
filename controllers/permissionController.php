<?php
session_start();
include_once '../utils/auth.php';
include_once '../utils/CheckPermission.php';

if (!IsAuthenticated()){
    header('Location:../index.php');
}

include_once '../utils/pagination.php';
include_once '../models/permission/permissionDAO.php';
include_once '../models/funcAction/funcActionDAO.php';
include_once '../models/role/roleDAO.php';
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
                goToShowAllAndShowError($e->getMessage());
           } catch (Exception $e) {
                goToShowAllAndShowError($e->getMessage());
           }
        } else {
            goToShowAllAndShowError("No tienes permiso para ver.");
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
                    goToShowAllAndShowSuccess("Permiso modificado correctamente.");
                }
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            } catch (Exception $e) {
                goToShowAllAndShowError($e->getMessage());
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para editar.");
        }
        break;
    case "delete":
        if (checkPermission("Permission", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $permissionDAO->delete($permissionPK, $value);
                    goToShowAllAndShowSuccess("Permiso eliminado correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    $permissionDAO->checkDependencies($value);
                    showAll();
                    openDeletionModal("Eliminar permiso", "¿Está seguro de que desea eliminar " .
                    "el permiso %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                    "../controllers/permissionController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
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
                    goToShowAllAndShowSuccess("Permiso añadido correctamente.");
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
    case "search":
        if (checkPermission("Permission", "SHOWALL")) {
            if (!isset($_POST["submit"])) {
                new PermissionSearchView($rolesData, $funcActionData);
            } else {
                try {
                    $permission = new Permiso();
                    if(!empty($_POST["idRol"])) {
                        $permission->setRol($roleDAO->show('id', $_POST["idRol"]));
                    }
                    if(!empty($_POST["idFuncAccion"])) {
                            $permission->setFuncAction($funcActionDAO->show('id', $_POST["idFuncAccion"]));
                    }
                    showAllSearch($permission);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                } catch (ValidationException $ve) {
                    goToShowAllAndShowError($ve->getMessage());
                }
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
    if (checkPermission("Permission", "SHOWALL")) {
        try {

            $page = getPage();
            $itemsInPage = getNumberItems();
            $toSearch = getToSearch($search);

            $totalPermissions = $GLOBALS["permissionDAO"]->countTotalPermissions($toSearch);
            $data = $GLOBALS["permissionDAO"]->showAllPaged($page, $itemsInPage, $toSearch);
            new PermissionShowAllView($data, $itemsInPage, $page, $totalPermissions, $toSearch);
        } catch (DAOException $e) {

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