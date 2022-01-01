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
include_once '../models/degree/degreeDAO.php';
include_once '../models/center/centerDAO.php';
include_once '../models/user/userDAO.php';
include_once '../models/university/academicCourseDAO.php';
include_once '../models/university/universityDAO.php';
include_once '../models/building/buildingDAO.php';

class DegreeTest  {

    private $dao;
    private $action;
    private $centerDAO;
    private $userDAO;
    private $academicCourseDAO;
    private $universityDAO;
    private $buildingDAO;

    public function __construct($dao=NULL, $action=NULL){
        $this->dao = $dao;
        $this->action = $action;
        $this->centerDAO = new CenterDAO();
        $this->userDAO = new UserDAO();
        $this->academicCourseDAO = new AcademicCourseDAO();
        $this->universityDAO = new UniversityDAO();
        $this->buildingDAO = new BuildingDAO();
        $this->render();
    }

    function render() {
         switch($this->action) {
            case "add":
                try {
                    $degree = $this->createDegree();
                    $element = $this->dao->show("id", $degree->getId());

                    $result = "Elem. añadido: { id: " . $element->getId() . ", nombre: ". $element->getNombre() . " , descripción: " . $element->getDescripcion() .
                        ", capacidad: " . $element->getCapacidad() . ", creditos" . $element->getCreditos() .
                        ", usuario: " . $element->getUsuario()->getLogin() . ", centro: { id: " . $element->getCentro()->getId() .
                        ", universidad: " . $element->getCentro()->getUniversidad()->getNombre() .
                        ", nombre: " . $element->getCentro()->getNombre() . ", edificio: " . $element->getCentro()->getEdificio()->getNombre() . ", usuario: " . $element->getCentro()->getUsuario()->getLogin() .
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
                    $degree = $this->createDegree();
                    $this->dao->delete("id", $degree->getId());

                    try {
                        $this->dao->show("id", $degree->getId());
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
                    $degree = $this->createDegree();
                    $degree->setNombre("Nombre editado");

                    $this->dao->edit($degree);
                    $element = $this->dao->show("id", $degree->getId());

                    $result = "Elem. editado: { id: " . $element->getId() . ", nombre: ". $element->getNombre() . " , descripción: " . $element->getDescripcion() .
                      ", capacidad: " . $element->getCapacidad() . ", creditos" . $element->getCreditos() .
                      ", usuario: " . $element->getUsuario()->getLogin() . ", centro: { id: " . $element->getCentro()->getId() .
                      ", universidad: " . $element->getCentro()->getUniversidad()->getNombre() .
                      ", nombre: " . $element->getCentro()->getNombre() . ", edificio: " . $element->getCentro()->getEdificio()->getNombre() . ", usuario: " . $element->getCentro()->getUsuario()->getLogin() .
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
                    $degree = $this->createDegree();
                    $element = $this->dao->show("id", $degree->getId());

                    $result = "Elem. buscado: { id: " . $element->getId() . ", nombre: ". $element->getNombre() . " , descripción: " . $element->getDescripcion() .
                      ", capacidad: " . $element->getCapacidad() . ", creditos" . $element->getCreditos() .
                      ", usuario: " . $element->getUsuario()->getLogin() . ", centro: { id: " . $element->getCentro()->getId() .
                      ", universidad: " . $element->getCentro()->getUniversidad()->getNombre() .
                      ", nombre: " . $element->getCentro()->getNombre() . ", edificio: " . $element->getCentro()->getEdificio()->getNombre() . ", usuario: " . $element->getCentro()->getUsuario()->getLogin() .
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

    function createDegree() {

        $user = new Usuario("userTest", "userTestPass", "11111111H", "user", "test", "usertest@usertest.com", "Calle user 123", "666666666");
        $this->userDAO->add($user);
        $ac = new CursoAcademico(1, 'test', 2021, 2022);
        $this->academicCourseDAO->add($ac);
        $university = new Universidad(1, 1, "universityTest", $user);
        $this->universityDAO->add($university);
        $building = new Edificio(1, 'building test', 'Vigo', $user);
        $this->buildingDAO->add($building);
        $center = new Centro(1, $university, 'center Test', $building, $user);
        $this->centerDAO->add($center);

        $degree = new Grado(1, 'Titulación Test', $center, 500, 'Descripción test', 30, $user);
        $this->dao->add($degree);

        return $degree;
    }
}
?>