<?php
session_start();
include_once '../utils/auth.php';
include_once '../utils/CheckPermission.php';

if (!IsAuthenticated()){
    header('Location:../index.php');
}

include_once '../utils/pagination.php';
include_once '../models/functionality/functionalityDAO.php';
include_once '../models/common/DAOException.php';
include_once '../views/Common/head.php';
include_once '../views/Common/headerMenu.php';
include_once '../views/common/paginationView.php';
include_once '../views/functionality/functionalityShowAllView.php';
include_once '../views/functionality/functionalityAddView.php';
include_once '../views/functionality/functionalityShowView.php';
include_once '../views/functionality/functionalityEditView.php';
include_once '../views/functionality/functionalitySearchView.php';
include_once '../utils/confirmDelete.php';

//DAO
$functionalityDAO = new FunctionalityDAO();
$functionalityPrimaryKey = "id";
$value = $_REQUEST[$functionalityPrimaryKey];
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (checkPermission("Academiccurso", "ADD")) {
            if (checkPermission("Functionality", "ADD")) {
                if (!isset($_POST["submit"])) {
                    new FunctionalityAddView();
                } else {
                    try {
                        $functionality = new Funcionalidad();
                        $functionality->setNombre($_POST["name"]);
                        $functionality->setDescripcion($_POST["description"]);
                        $functionalityDAO->add($functionality);
                        
                        goToShowAllAndShowSuccess("Funcionalidad añadida correctamente.");
                    } catch (DAOException $e) {
                        goToShowAllAndShowError($e->getMessage());
                    } catch (Exception $ve) {
                        goToShowAllAndShowError($ve->getMessage());
                    }
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
                    $functionalityDAO->delete($functionalityPrimaryKey, $value);
                    goToShowAllAndShowSuccess("Funcionalidad eliminada correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    showAll();
                    confirmDelete("Eliminar Funcionalidad", "¿Está seguro de que desea eliminar " .
                        "la funcionalidad %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../controllers/functionalityController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "show":
        if (checkPermission("Functionality", "SHOWCURRENT")) {
            try {
                $functionalityData = $functionalityDAO->show($functionalityPrimaryKey, $value);
                new FunctionalityShowView($functionalityData);
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
        if (checkPermission("Functionality", "EDIT")) {
            try {
                $functionality = $functionalityDAO->show($functionalityPrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new FunctionalityEditView($functionality);
                } else {
                    $functionality->setId($value);
                    $functionality->setNombre($_POST["name"]);
                    $functionality->setDescripcion($_POST["description"]);
                    $functionalityDAO->edit($functionality);
                    goToShowAllAndShowSuccess("Funcionalidad editada correctamente.");
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
        if(checkPermission("Functionality", "SHOWALL")) {
            try {
                $functionality = $functionalityDAO->search($_POST["name"], $_POST["description"]);
                $functionalities = array();

                foreach($functionality as $func) {
                    array_push($functionalities, $functionalityDAO->show($functionalityPrimaryKey, $func["id"]));
                }

                showAllSearch($functionalities);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            } catch (Exception $ve) {
                goToShowAllAndShowError($ve->getMessage());
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
    if (checkPermission("Functionality", "SHOWALL")) {
        try {
            $currentPage = getPage();
            $itemsPerPage = getNumberItems();
            $toSearch = getToSearch($search);
            $totalFunctionalities = $GLOBALS["functionalityDAO"]->countTotalFunctionalities($toSearch);

            if ($search != NULL) {
                $functionalityData = $search;
                $totalFunctionalities = count($functionalityData);
            } else {
                $functionalityData = $GLOBALS["functionalityDAO"]->showAllPaged($currentPage, $itemsPerPage, NULL);
            }

            new FunctionalityShowAllView($functionalityData, $itemsPerPage, $currentPage, $totalFunctionalities, $search);
        } catch (DAOException $e) {
            include '../models/common/messageType.php';
            include '../utils/ShowToast.php';
            new FunctionalityShowAllView(array());
            $message = MessageType::ERROR;
            showToast($message, $e->getMessage());
        }
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