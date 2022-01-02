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
include_once '../models/university/academicCourseDAO.php';
include_once '../models/user/userDAO.php';
include_once '../models/university/universityDAO.php';
include_once '../models/building/buildingDAO.php';

class BuildingTest {

    private $dao;
    private $action;
    private $academicCourseDAO;
    private $userDAO;
    private $universityDAO;

    public function __construct($dao = NULL, $action = NULL) {
        $this->dao = $dao;
        $this->action = $action;
        $this->userDAO = new UserDAO();
        $this->universityDAO = new UniversityDAO();
        $this->academicCourseDAO = new AcademicCourseDAO();
        $this->render();
    }

    function render() {
        switch ($this->action) {
            case "add":
                try {
                    $building = $this->createBuilding();
                    $element = $this->dao->show("id", $building->getId());

                    $result = "Elem. añadido: { id: " . $element->getId() . ", nombre: " . $element->getNombre() .
                        ", localización: " .  $element->getLocalizacion() . ", usuario: " . $element->getIdusuario()->getLogin() .
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
                    $building = $this->createBuilding();
                    $this->dao->delete("id", $building->getId());

                    try {
                        $this->dao->show("id", $building->getId());
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
                    $building = $this->createBuilding();
                    $building->setNombre("Nombre editado");

                    $this->dao->edit($building);
                    $element = $this->dao->show("id", $building->getId());

                    $result = "Elem. editado: { id: " . $element->getId() . ", nombre: " . $element->getNombre() .
                      ", localización: " .  $element->getLocalizacion() . ", usuario: " . $element->getIdusuario()->getLogin() .
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
                    $building = $this->createBuilding();
                    $element = $this->dao->show("id", $building->getId());

                    $result = "Elem. buscado: { id: " . $element->getId() . ", nombre: " . $element->getNombre() .
                        ", localización: " .  $element->getLocalizacion() . ", usuario: " . $element->getIdusuario()->getLogin() .
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

    function createBuilding() {

        $user = new Usuario("userTest", "userTestPass", "11111111H", "user", "test", "usertest@usertest.com", "Calle user 123", "666666666");
        $this->userDAO->add($user);
        $ac = new CursoAcademico(1, 'test', 2021, 2022);
        $this->academicCourseDAO->add($ac);
        $university = new Universidad(1, 1, "universityTest", $user);
        $this->universityDAO->add($university);

        $building = new Edificio(1, 'building test', 'Vigo', $user);
        $this->dao->add($building);
        return $building;
    }
}
