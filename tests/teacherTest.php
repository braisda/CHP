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
include_once '../models/teacher/teacherDAO.php';
include_once '../models/space/spaceDAO.php';
include_once '../models/user/userDAO.php';
include_once '../models/university/academicCourseDAO.php';
include_once '../models/university/universityDAO.php';
include_once '../models/building/buildingDAO.php';

class TeacherTest  {

    private $dao;
    private $action;
    private $userDAO;
    private $academicCourseDAO;
    private $universityDAO;
    private $spaceDAO;
    private $buildingDAO;

    public function __construct($dao=NULL, $action=NULL){
        $this->dao = $dao;
        $this->action = $action;
        $this->userDAO = new UserDAO();
        $this->academicCourseDAO = new AcademicCourseDAO();
        $this->universityDAO = new UniversityDAO();
        $this->buildingDAO = new BuildingDAO();
        $this->spaceDAO = new SpaceDAO();
        $this->render();
    }

    function render() {
         switch($this->action) {
            case "add":
                try {
                    $teacher = $this->createTeacher();
                    $element = $this->dao->show("id", $teacher->getId());

                    $result = "Elem. añadido: { id: " . $element->getId() . ", dedicacion: ". $element->getDedicacion() .
                        ", usuario: " . $element->getUsuario()->getLogin() .
                        ", espacio: { id: " . $element->getEspacio()->getId() .
                        ", nombre: " . $element->getEspacio()->getNombre() . ", capacidad: " . $element->getEspacio()->getCapacidad() . ", oficina: " . $element->getEspacio()->getOficina() .
                        ", edificio: { id: " . $element->getEspacio()->getIdedificio()->getId() . ", nombre: " . $element->getEspacio()->getIdedificio()->getNombre() .
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
                    $teacher = $this->createTeacher();
                    $this->dao->delete("id", $teacher->getId());

                    try {
                        $this->dao->show("id", $teacher->getId());
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
                    $teacher = $this->createTeacher();
                    $teacher->setDedicacion("PROF");

                    $this->dao->edit($teacher);
                    $element = $this->dao->show("id", $teacher->getId());

                    $result = "Elem. editado: { id: " . $element->getId() . ", dedicacion: ". $element->getDedicacion() .
                      ", usuario: " . $element->getUsuario()->getLogin() .
                      ", espacio: { id: " . $element->getEspacio()->getId() .
                      ", nombre: " . $element->getEspacio()->getNombre() . ", capacidad: " . $element->getEspacio()->getCapacidad() . ", oficina: " . $element->getEspacio()->getOficina() .
                      ", edificio: { id: " . $element->getEspacio()->getIdedificio()->getId() . ", nombre: " . $element->getEspacio()->getIdedificio()->getNombre() .
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
                    $teacher = $this->createTeacher();
                    $element = $this->dao->show("id", $teacher->getId());

                    $result = "Elem. buscado: { id: " . $element->getId() . ", dedicacion: ". $element->getDedicacion() .
                      ", usuario: " . $element->getUsuario()->getLogin() .
                      ", espacio: { id: " . $element->getEspacio()->getId() .
                      ", nombre: " . $element->getEspacio()->getNombre() . ", capacidad: " . $element->getEspacio()->getCapacidad() . ", oficina: " . $element->getEspacio()->getOficina() .
                      ", edificio: { id: " . $element->getEspacio()->getIdedificio()->getId() . ", nombre: " . $element->getEspacio()->getIdedificio()->getNombre() .
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

    function createTeacher() {

        $user = new Usuario("userTest", "userTestPass", "11111111H", "user", "test", "usertest@usertest.com", "Calle user 123", "666666666");
        $this->userDAO->add($user);
        $ac = new CursoAcademico(1, 'test', 2021, 2022);
        $this->academicCourseDAO->add($ac);
        $university = new Universidad(1, 1, "universityTest", $user);
        $this->universityDAO->add($university);
        $building = new Edificio(1, 'building test', 'Vigo', $user);
        $this->buildingDAO->add($building);
        $space = new Espacio(1, 'Space Test', $building, 400, 'Ofice Test');
        $this->spaceDAO->add($space);


        $teacher = new Profesor(1, $user, 'TEST', $space);
        $this->dao->add($teacher);

        return $teacher;
    }
}
?>