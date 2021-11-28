<?php
session_start();
include_once '../utils/auth.php';
include_once '../utils/CheckPermission.php';

if (!IsAuthenticated()){
    header('Location:../index.php');
}

include_once '../models/user/userDAO.php';
include_once '../models/common/DAOException.php';
include_once '../utils/messages.php';
include_once '../utils/openDeletionModal.php';
include_once '../utils/pagination.php';
include_once '../utils/redirect.php';
include_once '../views/common/head.php';
include_once '../views/common/headerMenu.php';
include_once '../views/common/paginationView.php';
include_once '../views/user/userShowAllView.php';
include_once '../views/user/userShowView.php';
include_once '../views/user/userEditView.php';
include_once '../views/user/userAddView.php';

$userDAO = new UserDAO();

$userPK = "login";
$value = $_REQUEST[$userPK];

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "show":
        if (checkPermission("usuario", "SHOWCURRENT")) {
            try {
                $userData = $userDAO->show($userPK, $value);
                new UserShowView($userData);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            } catch (ValidationException $e) {
                goToShowAllAndShowError($e->getMessage());
            }
        } else {
            goToShowAllAndShowError("No tiene permiso para visualizar la entidad.");
        }
        break;
    case "edit":
        if(checkPermission("usuario", "EDIT")) {
            try {

                $user = $userDAO->show($userPK, $value);

                if (!isset($_POST["submit"])) {
                    new UserEditView($user);
                } else {
                    $user->setDni($_POST["dni"]);
                    $user->setNombre($_POST["nombre"]);
                    $user->setApellido($_POST["apellido"]);
                    $user->setEmail($_POST["email"]);
                    $user->setDireccion($_POST["direccion"]);
                    $user->setTelefono($_POST["telefono"]);
                    $userDAO->edit($user);
                    goToShowAllAndShowSuccess("Usuario modificado correctamente.");
                }
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            } catch (ValidationException $e) {
                goToShowAllAndShowError($e->getMessage());
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para editar.");
        }
        break;
    case "add":
         if (checkPermission("usuario", "ADD")) {
            if (!isset($_POST["submit"])) {
                new UserAddView();
            } else {
                try {
                    $user = new Usuario();
                    $user->setLogin($_POST["login"]);
                    $user->setPassword($user->encryptPassword($_POST["password1"]));
                    $user->setDni($_POST["dni"]);
                    $user->setNombre($_POST["nombre"]);
                    $user->setApellido($_POST["apellido"]);
                    $user->setEmail($_POST["email"]);
                    $user->setDireccion($_POST["direccion"]);
                    $user->setTelefono($_POST["telefono"]);
                    $userDAO->add($user);
                    goToShowAllAndShowSuccess("Usuario añadido correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                } catch (ValidationException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
         } else {
            goToShowAllAndShowError("No tienes permiso para añadir.");
         }
        break;
    case "delete":
        if (checkPermission("usuario", "DELETE")) {
            if (isset($_REQUEST["confirm"])) {
                try {
                    $userDAO->delete($userPK, $value);
                    goToShowAllAndShowSuccess("Usuario eliminado correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    $userDAO->checkDependencies($value);
                    showAll();
                    openDeletionModal("Eliminar usuario", "¿Está seguro de que desea eliminar " .
                        "el usuario %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../controllers/userController.php?action=delete&login=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "search":
        if (checkPermission("usuario", "SHOWALL")) {
            try {
                $user = $userDAO->search($_POST["login"], $_POST["nombre"], $_POST["apellido"], $_POST["email"]);
                $users = array();

                foreach($user as $us) {
                    array_push($users, $userDAO->show($userPK, $us["login"]));
                }

                showAllSearch($users);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage());
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
    if (checkPermission("usuario", "SHOWALL")) {
        try {

            $page = getPage();
            $itemsInPage = getNumberItems();
            $totalUsers = $GLOBALS["userDAO"]->countTotalUsers($toSearch);

            if ($search != NULL) {
                $data = $search;
                $totalUsers = count($data);
            } else {
                $data = $GLOBALS["userDAO"]->showAllPaged($page, $itemsInPage, NULL);
            }

            new UserShowAllView($data, $itemsInPage, $page, $totalUsers, $search);
        } catch (DAOException $e) {
            new UserShowAllView(array());
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
?>