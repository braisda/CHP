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
include_once '../models/role/roleDAO.php';
include_once '../models/action/actionDAO.php';
include_once '../models/functionality/functionalityDAO.php';

class FuncActionTest {

    private $dao;
    private $action;
    private $actionDAO;
    private $functionalityDAO;

    public function __construct($dao=NULL, $action=NULL) {
        $this->dao = $dao;
        $this->action = $action;
        $this->actionDAO = new ActionDAO();
        $this->functionalityDAO = new FunctionalityDAO();
        $this->render();
    }

    function render() {
         switch($this->action) {
            case "add":
                try {
                    $funcAction = $this->createFuncAction();
                    $element = $this->dao->show("id", $funcAction->getId());

                    $result = "Elem. añadido: { id: " . $element->getId() . ", idAcción: " . $element->getAccion()->getId() .
                        ", idFuncionalidad: " . $element->getFuncionalidad()->getId() .
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
                    $funcAction = $this->createFuncAction();
                    $this->dao->delete("id", $funcAction->getId());

                    try {
                        $this->dao->show("id", $funcAction->getId());
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
                    $funcAction = $this->createFuncAction();
                    $act = new Accion(2, "action to edit", "Action to edit");
                    $this->actionDAO->add($act);
                    $funcAction->setAccion($act);

                    $this->dao->edit($funcAction);
                    $element = $this->dao->show("id", $funcAction->getId());

                    $result = "Elem. editado: { id: " . $element->getId() . ", idAcción: " . $element->getAccion()->getId() .
                      ", idFuncionalidad: " . $element->getFuncionalidad()->getId() .
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
                    $funcAction = $this->createFuncAction();
                    $element = $this->dao->show("id", $funcAction->getId());

                    $result = "Elem. buscado: { id: " . $element->getId() . ", idAcción: " . $element->getAccion()->getId() .
                      ", idFuncionalidad: " . $element->getFuncionalidad()->getId() .
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

    function createFuncAction() {

         $act = new Accion(1, 'actionTest', 'Action to test');
         $this->actionDAO->add($act);
         $functionality = new Funcionalidad(1, "functionalityTest", "Functionality to test");
         $this->functionalityDAO->add($functionality);

        $funcAction = new Funcaccion(1, $act, $functionality);
        $this->dao->add($funcAction);

        return $funcAction;
    }
}
?>