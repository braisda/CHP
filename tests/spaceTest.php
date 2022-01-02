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
include_once '../models/space/spaceDAO.php';
include_once '../models/university/universityDAO.php';
include_once '../models/building/buildingDAO.php';

class SpaceTest {

    private $dao;
    private $action;
    private $academicCourseDAO;
    private $userDAO;
    private $buildingDAO;
    private $universityDAO;

    public function __construct($dao = NULL, $action = NULL) {
        $this->dao = $dao;
        $this->action = $action;
        $this->userDAO = new UserDAO();
        $this->universityDAO = new UniversityDAO();
        $this->buildingDAO = new BuildingDAO();
        $this->academicCourseDAO = new AcademicCourseDAO();
        $this->render();
    }

    function render() {
        switch ($this->action) {
            case "add":
                try {
                    $space = $this->createSpace();
                    $element = $this->dao->show("id", $space->getId());

                    $result = "Elem. añadido: { id: " . $element->getId() . ", nombre: " . $element->getNombre() .
                        ", capacidad: " . $element->getCapacidad() . ", oficina: " . $element->getOficina() .
                        ", edificio: {" . $element->getIdedificio()->getId() . ", nombre: " . $element->getIdedificio()->getNombre() .
                        ", localización: " . $element->getIdedificio()->getLocalizacion() .  ", usuario: " . $element->getIdedificio()->getIdusuario()->getLogin() .
                        "}}";
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
                    $space = $this->createSpace();
                    $this->dao->delete("id", $space->getId());

                    try {
                        $this->dao->show("id", $space->getId());
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
                    $space = $this->createSpace();
                    $space->setNombre("Nombre editado");

                    $this->dao->edit($space);
                    $element = $this->dao->show("id", $space->getId());

                    $result = "Elem. editado: { id: " . $element->getId() . ", nombre: " . $element->getNombre() .
                      ", capacidad: " . $element->getCapacidad() . ", oficina: " . $element->getOficina() .
                      ", edificio: {" . $element->getIdedificio()->getId() . ", nombre: " . $element->getIdedificio()->getNombre() .
                      ", localización: " . $element->getIdedificio()->getLocalizacion() .  ", usuario: " . $element->getIdedificio()->getIdusuario()->getLogin() .
                      "}}";

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
                    $space = $this->createSpace();
                    $element = $this->dao->show("id", $space->getId());

                    $result = "Elem. buscado: { id: " . $element->getId() . ", nombre: " . $element->getNombre() .
                      ", capacidad: " . $element->getCapacidad() . ", oficina: " . $element->getOficina() .
                      ", edificio: {" . $element->getIdedificio()->getId() . ", nombre: " . $element->getIdedificio()->getNombre() .
                      ", localización: " . $element->getIdedificio()->getLocalizacion() .  ", usuario: " . $element->getIdedificio()->getIdusuario()->getLogin() .
                      "}}";

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

    function createSpace() {

        $user = new Usuario("userTest", "userTestPass", "11111111H", "user", "test", "usertest@usertest.com", "Calle user 123", "666666666");
        $this->userDAO->add($user);
        $ac = new CursoAcademico(1, 'test', 2021, 2022);
        $this->academicCourseDAO->add($ac);
        $university = new Universidad(1, 1, "universityTest", $user);
        $this->universityDAO->add($university);
        $building = new Edificio(1, 'building test', 'Vigo', $user);
        $this->buildingDAO->add($building);

        $space = new Espacio(1, 'Space Test', $building, 400, 'Ofice Test');
        $this->dao->add($space);
        return $space;
    }
}
