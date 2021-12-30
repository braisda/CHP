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
include_once '../models/roleDAO/roleDAO.php';
include_once '../models/user/userDAO.php';

class UserRoleTest {

    private $dao;
    private $action;
    private $roleDAO;
    private $userDAO;

    public function __construct($dao=NULL, $action=NULL) {
        $this->dao = $dao;
        $this->action = $action;
        $this->roleDAO = new RoleDAO();
        $this->userDAO = new userDAO();
        $this->render();
    }

    function render() {
         switch($this->action) {
            case "add":
                try {
                    $userRole = $this->createUserRole();
                    $element = $this->dao->show("id", $userRole->getId());

                    $result = "Elem. añadido: { id: " . $element->getId() . ", idRol: " . $element->getIdrol()->getId() .
                        ", idUsuario: " . $element->getIdusuario()->getId() .
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
                    $userRole = $this->createUserRole();
                    $this->dao->delete("id", $userRole->getId());

                    try {
                        $this->dao->show("id", $userRole->getId());
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
                    $userRole = $this->createUserRole();
                    $role = new Rol(2, "role to edit", "Role to edit");
                    $this->roleDAO->add($role);
                    $userRole->setIdrol($role);

                    $this->dao->edit($userRole);
                    $element = $this->dao->show("id", $userRole->getId());

                    $result = "Elem. editado: { id: " . $element->getId() . ", idRol: " . $element->getIdrol()->getId() .
                      ", idUsuario: " . $element->getIdusuario()->getId() .
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
                    $userRole = $this->createUserRole();
                    $element = $this->dao->show("id", $userRole->getId());

                    $result = "Elem. buscado: { id: " . $element->getId() . ", idRol: " . $element->getIdrol()->getId() .
                      ", idUsuario: " . $element->getIdusuario()->getId() .
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

    function createUserRole() {

         $role = new Rol(1, 'roleTest', 'Role to test');
         $this->roleDAO->add($role);
         $user = new Usuario("userTest", "userTestPass", "11111111H", "user", "test", "usertest@usertest.com", "Calle user 123", "666666666");
         $this->userDAO->add($user);

        $userRole = new UsuarioRol(1, $role, $user);
        $this->dao->add($userRole);

        return $userRole;
    }
}
?>