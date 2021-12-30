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
include_once '../models/user/userDAO.php';

class UserTest {

    private $dao;
    private $action;

    public function __construct($dao=NULL, $action=NULL) {
        $this->dao = $dao;
        $this->action = $action;
        $this->render();
    }

    function render() {
         switch($this->action) {
            case "add":
                try {
                    $user = $this->createUser();
                    $element = $this->dao->show("login", $user->getId());

                    $result = "Elem. añadido: { login: " . $element->getId() . ", pass: " . $element->getPassword() .
                        ", dni: " . $element->getDni() . ", nombre: " . $element->getNombre() . ", apellido: " . $element->getApellido() .
                        ", email: " . $element->getEmail() . ", direccion: " . $element->getDireccion()  .
                        ", tlf: " . $element->getTelefono() . "}";
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
                    $user = $this->createUser();
                    $this->dao->delete("login", $user->getId());

                    try {
                        $this->dao->show("login", $user->getId());
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
                    $user = $this->createUser();
                    $user->setNombre("Nombre editado");

                    $this->dao->edit($user);
                    $element = $this->dao->show("login", $user->getId());

                    $result = "Elem. editado: { login: " . $element->getId() . ", pass: " . $element->getPassword() .
                      ", dni: " . $element->getDni() . ", nombre: " . $element->getNombre() . ", apellido: " . $element->getApellido() .
                      ", email: " . $element->getEmail() . ", direccion: " . $element->getDireccion()  .
                      ", tlf: " . $element->getTelefono() . "}";

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
                    $user = $this->createUser();
                    $element = $this->dao->show("login", $user->getId());

                    $result = "Elem. buscado: { login: " . $element->getId() . ", pass: " . $element->getPassword() .
                      ", dni: " . $element->getDni() . ", nombre: " . $element->getNombre() . ", apellido: " . $element->getApellido() .
                      ", email: " . $element->getEmail() . ", direccion: " . $element->getDireccion()  .
                      ", tlf: " . $element->getTelefono() . "}";

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

    function createUser() {

         $user = new Usuario("userTest", "userTestPass", "11111111H", "user", "test", "usertest@usertest.com", "Calle user 123", "666666666");
         $this->dao->add($user);

        return $user;
    }
}
?>