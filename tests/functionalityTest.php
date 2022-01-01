<?php
include_once '../utils/tests/databaseTest.php';
include_once '../utils/pagination.php';
include_once '../views/common/head.php';
include_once '../views/common/headerMenu.php';
include_once '../views/common/paginationView.php';
include_once '../utils/openDeletionModal.php';
include_once '../utils/confirmDelete.php';
include_once '../models/common/DAOException.php';
include_once '../views/tests/testShowAllView.php';
include_once '../models/functionality/functionalityDAO.php';

class FunctionalityTest {

    private $dao;
    private $functionality;

    public function __construct($dao=NULL, $functionality=NULL) {
        $this->dao = $dao;
        $this->functionality = $functionality;
        $this->render();
    }

    function render() {
         switch($this->functionality) {
            case "add":
                try {
                    $act = $this->createFunctionality();
                    $element = $this->dao->show("id", $act->getId());

                    $result = "Elem. añadido: { id: " . $element->getId() . ", nombre: " . $element->getNombre() .
                        ", description: " . $element->getDescripcion() .
                        "}";
                    goToShowAllAndShowSuccess($result);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                } finally {
                    $_SESSION["env"] = NULL;
                    restoreDB();
                }
                break;
            case "delete":
                try {
                    $act = $this->createFunctionality();
                    $this->dao->delete("id", $act->getId());

                    try {
                        $this->dao->show("id", $act->getId());
                    } catch (DAOException $e) {
                         goToShowAllAndShowSuccess($e->getMessage() . " Se ha eliminado correctamente.");
                    }
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                } finally {
                    $_SESSION["env"] = NULL;
                    restoreDB();
                }
                break;
            case "edit":
                try {
                    $act = $this->createFunctionality();
                    $act->setNombre("Nombre editado");

                    $this->dao->edit($act);
                    $element = $this->dao->show("id", $act->getId());

                    $result = "Elem. editado: { id: " . $element->getId() . ", nombre: " . $element->getNombre() .
                        ", description: " . $element->getDescripcion() .
                        "}";

                    goToShowAllAndShowSuccess($result);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                } finally {
                    $_SESSION["env"] = NULL;
                    restoreDB();
                }
                break;
            case "view":
                try {
                    $act = $this->createFunctionality();
                    $element = $this->dao->show("id", $act->getId());

                    $result = "Elem. buscado: { id: " . $element->getId() . ", nombre: " . $element->getNombre() .
                        ", description: " . $element->getDescripcion() .
                        "}";

                    goToShowAllAndShowSuccess($result);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                } finally {
                    $_SESSION["env"] = NULL;
                    restoreDB();
                }
                break;
            default:
                showAll();
                break;
         }
    }

    function showAll() {
        showAllSearch(NULL);
    }

    function showAllSearch($search) {
        try {
            new TestShowAllView();
        } catch (DAOException $e) {
            include '../models/common/messageType.php';
            include '../utils/ShowToast.php';
            new TestShowAllView();
            $message = MessageType::ERROR;
            showToast($message, $e->getMessage());
        }
    }

    function goToShowAllAndShowError($message) {
        showAll();
        include '../models/common/messageType.php';
        include '../utils/ShowToast.php';
        $messageType = MessageType::ERROR;
        showTestToast($messageType, $message);
    }

    function goToShowAllAndShowSuccess($message) {
        showAll();
        include '../models/common/messageType.php';
        include '../utils/ShowToast.php';
        $messageType = MessageType::SUCCESS;
        showTestToast($messageType, $message);
    }

    function createFunctionality() {

        $act = new Funcionalidad(1, 'functionalityTest', 'Functionality to test');
        $this->dao->add($act);

        return $act;
    }
}
?>