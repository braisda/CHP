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
include_once '../models/permission/permissionDAO.php';
include_once '../models/role/roleDAO.php';
include_once '../models/funcAction/funActionDAO.php';
include_once '../models/action/actionDAO.php';
include_once '../models/role/roleDAO.php';

class PermissionTest  {

    private $dao;
    private $action;
    private $actionDAO;
    private $funcActionDAO;
    private $functionalityDAO;
    private $roleDAO;

    public function __construct($dao=NULL, $action=NULL){
        $this->dao = $dao;
        $this->action = $action;
        $this->actionDAO = new ActionDAO();
        $this->funcActionDAO = new FuncActionDAO();
        $this->functionalityDAO = new FunctionalityDAO();
        $this->roleDAO = new RoleDAO();
        $this->render();
    }

    function render() {
         switch($this->action) {
            case "add":
                try {
                    $permission = $this->createPermission();
                    $element = $this->dao->show("id", $permission->getId());

                    $result = "Elem. añadido: { id: " . $element->getId() . ",rol: { id: " .
                        $element->getRol()->getId() . ", nombre: ". $element->getRol()->getNombre() . " , descripción: " . $element->getRol()->getDescripcion() .
                        "},funcAccion: { id: " . $element->getFuncAccion()->getId() . ",accion: { id: " . $element->getFuncAccion()->getAccion()->getId() .
                        ", nombre: " . $element->getFuncAccion()->getAccion()->getNombre() . ", descripción: " . $element->getFuncAccion()->getAccion()->getDescripcion() . "}" .
                        ", funcionalidad: { id: " . $element->getFuncAccion()->getFuncionalidad()->getId() .
                        ", nombre: " . $element->getFuncAccion()->getFuncionalidad()->getNombre() . ", descripción: " . $element->getFuncAccion()->getFuncionalidad()->getDescripcion() .
                        "}}}";

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
                    $permission = $this->createPermission();
                    $this->dao->delete("id", $permission->getId());

                    try {
                        $this->dao->show("id", $permission->getId());
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
                    $permission = $this->createPermission();
                    $role = new Rol(2, 'roleEdit', 'Role edited');
                    $this->roleDAO->add($role);
                    $permission->setRol($role);

                    $this->dao->edit($permission);
                    $element = $this->dao->show("id", $permission->getId());

                    $result = "Elem. editado: { id: " . $element->getId() . ",rol: { id: " .
                        $element->getRol()->getId() . ", nombre: ". $element->getRol()->getNombre() . " , descripción: " . $element->getRol()->getDescripcion() .
                        "},funcAccion: { id: " . $element->getFuncAccion()->getId() . ",accion: { id: " . $element->getFuncAccion()->getAccion()->getId() .
                        ", nombre: " . $element->getFuncAccion()->getAccion()->getNombre() . ", descripción: " . $element->getFuncAccion()->getAccion()->getDescripcion() . "}" .
                        ", funcionalidad: { id: " . $element->getFuncAccion()->getFuncionalidad()->getId() .
                        ", nombre: " . $element->getFuncAccion()->getFuncionalidad()->getNombre() . ", descripción: " . $element->getFuncAccion()->getFuncionalidad()->getDescripcion() .
                        "}}}";

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
                    $permission = $this->createPermission();
                    $element = $this->dao->show("id", $permission->getId());

                    $result = "Elem. buscado: { id: " . $element->getId() . ",rol: { id: " .
                        $element->getRol()->getId() . ", nombre: ". $element->getRol()->getNombre() . " , descripción: " . $element->getRol()->getDescripcion() .
                        "},funcAccion: { id: " . $element->getFuncAccion()->getId() . ",accion: { id: " . $element->getFuncAccion()->getAccion()->getId() .
                        ", nombre: " . $element->getFuncAccion()->getAccion()->getNombre() . ", descripción: " . $element->getFuncAccion()->getAccion()->getDescripcion() . "}" .
                        ", funcionalidad: { id: " . $element->getFuncAccion()->getFuncionalidad()->getId() .
                        ", nombre: " . $element->getFuncAccion()->getFuncionalidad()->getNombre() . ", descripción: " . $element->getFuncAccion()->getFuncionalidad()->getDescripcion() .
                        "}}}";

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

    function createPermission() {

        $act = new Accion(1, 'actionTest', 'Action to test');
        $this->actionDAO->add($act);
        $functionality = new Funcionalidad(1, "functionalityTest", "Functionality to test");
        $this->functionalityDAO->add($functionality);
        $funcAction = new Funcaccion(1, $act, $functionality);
        $this->funcActionDAO->add($funcAction);
        $role = new Rol(1, 'roleTest', 'Role to test');
        $this->roleDAO->add($role);

        $permission = new Permiso();
        $permission->setId(1);
        $permission->setRol($role);
        $permission->setFuncAccion($funcAction);

        $this->dao->add($permission);

        return $permission;
    }
}
?>