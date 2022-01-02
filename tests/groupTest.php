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
include_once '../models/subject/subjectDAO.php';
include_once '../models/department/departmentDAO.php';
include_once '../models/teacher/teacherDAO.php';
include_once '../models/space/spaceDAO.php';
include_once '../models/university/universityDAO.php';
include_once '../models/building/buildingDAO.php';
include_once '../models/degree/degreeDAO.php';
include_once '../models/center/centerDAO.php';

class GroupTest {

    private $dao;
    private $action;
    private $academicCourseDAO;
    private $userDAO;
    private $subjectDAO;
    private $departmentDAO;
    private $teacherDAO;
    private $spaceDAO;
    private $buildingDAO;
    private $universityDAO;
    private $degreeDAO;
    private $centerDAO;

    public function __construct($dao = NULL, $action = NULL) {
        $this->dao = $dao;
        $this->action = $action;
        $this->subjectDAO = new SubjectDAO();
        $this->departmentDAO = new DepartmentDAO();
        $this->teacherDAO = new TeacherDAO();
        $this->spaceDAO = new SpaceDAO();
        $this->userDAO = new UserDAO();
        $this->universityDAO = new UniversityDAO();
        $this->buildingDAO = new BuildingDAO();
        $this->academicCourseDAO = new AcademicCourseDAO();
        $this->degreeDAO = new DegreeDAO();
        $this->centerDAO = new CenterDAO();
        $this->render();
    }

    function render() {
        switch ($this->action) {
            case "add":
                try {
                    $group = $this->createGroup();
                    $element = $this->dao->show("id", $group->getId());

                    $result = "Elem. añadido: { id: " . $element->getId() . ", nombre: " . $element->getNombre() .
                        ", materia: " . $element->getIdmateria()->getCodigo() .
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
                    $group = $this->createGroup();
                    $this->dao->delete("id", $group->getId());

                    try {
                        $this->dao->show("id", $group->getId());
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
                    $group = $this->createGroup();
                    $group->setNombre("Nombre editado");

                    $this->dao->edit($group);
                    $element = $this->dao->show("id", $group->getId());

                    $result = "Elem. editado: { id: " . $element->getId() . ", nombre: " . $element->getNombre() .
                      ", materia: " . $element->getIdmateria()->getCodigo() .
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
                    $group = $this->createGroup();
                    $element = $this->dao->show("id", $group->getId());

                    $result = "Elem. buscado: { id: " . $element->getId() . ", nombre: " . $element->getNombre() .
                      ", materia: " . $element->getIdmateria()->getCodigo() .
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

    function createGroup() {

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
        $teacher = new Profesor(1, $user, '400', $space);
        $this->teacherDAO->add($teacher);
        $department = new Departamento(1, 'D00x01', 'Departamento test', $teacher);
        $this->departmentDAO->add($department);
        $center = new Centro(1, $university, 'Centro test', $building, $user);
        $this->centerDAO->add($center);
        $degree = new Grado(1, 'Grado Test', $center, 500, 'Descripción test', 25, $user);
        $this->degreeDAO->add($degree);
        $subject = new Materia(1, '1111', 'Test', 'Test', $department, 'Test', '2', '1', 35, 3, 25, 140, '400', '250', '100', 100, $degree, $teacher, 1);
        $this->subjectDAO->add($subject);

        $group = new GrupoMateria(1, 'Grupo Test', $subject);
        $this->dao->add($group);
        return $group;
    }
}
