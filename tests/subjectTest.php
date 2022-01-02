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
include_once '../models/teacher/teacherDAO.php';
include_once '../models/space/spaceDAO.php';
include_once '../models/building/buildingDAO.php';
include_once '../models/department/departmentDAO.php';
include_once '../models/academicCourse/academicCourseDAO.php';
include_once '../models/university/universityDAO.php';
include_once '../models/center/centerDAO.php';
include_once '../models/degree/degreeDAO.php';

class SubjectTest
{

    private $dao;
    private $action;
    private $userDAO;
    private $teacherDAO;
    private $spaceDAO;
    private $buildingDAO;
    private $departmentDAO;
    private $academicCourseDAO;
    private $universityDAO;
    private $centerDAO;
    private $degreeDAO;

    public function __construct($dao = NULL, $action = NULL)
    {
        $this->dao = $dao;
        $this->action = $action;
        $this->userDAO = new UserDAO();
        $this->teacherDAO = new TeacherDAO();
        $this->spaceDAO = new SpaceDAO();
        $this->buildingDAO = new BuildingDAO();
        $this->departmentDAO = new DepartmentDAO();
        $this->academicCourseDAO = new AcademicCourseDAO();
        $this->universityDAO = new UniversityDAO();
        $this->centerDAO = new CenterDAO();
        $this->degreeDAO = new DegreeDAO();
        $this->render();
    }

    function render()
    {
        switch ($this->action) {
            case "add":
                try {
                    $subject = $this->createSubject();
                    $element = $this->dao->show("id", $subject->getId());
                    $result = "Elem. añadido { id: " . $element->getId() . ", profesor: " . $element->getIdprofesor()->getUsuario()->getLogin() .
                        ", codigo: " . $element->getCodigo() . ", nombre: " . $element->getNombre() .
                        "}";
                    goToShowAllAndShowSuccess($result);
                } catch (DAOException $e) {
                    print_r($e->getMessage());
                    goToShowAllAndShowError($e->getMessage());
                } finally {
                    $_SESSION["env"] = NULL;
                    restoreDB();
                }
                break;
            case "delete":
                try {
                    $subject = $this->createSubject();
                    $this->dao->delete("id", $subject->getId());

                    try {
                        $this->dao->show("id", $subject->getId());
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
                    $subject = $this->createSubject();
                    $subject->setCodigo("edit");

                    $this->dao->edit($subject);
                    $element = $this->dao->show("id", $subject->getId());

                    $result = "Elem. editado: { id: " . $element->getId() . ", profesor: " . $element->getIdprofesor()->getUsuario()->getLogin() .
                        ", codigo: " . $element->getCodigo() . ", nombre: " . $element->getNombre() .
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
                    $subject = $this->createSubject();
                    $element = $this->dao->show("id", $subject->getId());

                    $result = "Elem. buscado: { id: " . $element->getId() . ", profesor: " . $element->getIdprofesor()->getUsuario()->getLogin() .
                        ", codigo: " . $element->getCodigo() . ", nombre: " . $element->getNombre() .
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

    function showAll()
    {
        showAllSearch(NULL);
    }

    function showAllSearch($search)
    {
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

    function goToShowAllAndShowError($message)
    {
        showAll();
        include '../models/common/messageType.php';
        include '../utils/ShowToast.php';
        $messageType = MessageType::ERROR;
        showTestToast($messageType, $message);
    }

    function goToShowAllAndShowSuccess($message)
    {
        showAll();
        include '../models/common/messageType.php';
        include '../utils/ShowToast.php';
        $messageType = MessageType::SUCCESS;
        showTestToast($messageType, $message);
    }

    function createSubject()
    {

        $user = new Usuario("userTest", "userTestPass", "11111111H", "user", "test", "usertest@usertest.com", "Calle user 123", "666666666");
        $this->userDAO->add($user);
        $building = new Edificio(1, 'building test', 'Vigo', $user);
        $this->buildingDAO->add($building);
        $space = new Espacio(1, 'Space Test', $building, 400, 'Ofice Test');
        $this->spaceDAO->add($space);
        $teacher = new Profesor(1, $user, 'TEST', $space);
        $this->teacherDAO->add($teacher);

        $dep = new Departamento(1, "Dtest", "test", $teacher);
        $this->departmentDAO->add($dep);

        $ac = new CursoAcademico(1, 'test', 2021, 2022);
        $this->academicCourseDAO->add($ac);
        $u = new Universidad(1, 1, "universityTest", "userTest");
        $this->universityDAO->add($u);

        $center = new Centro(1, $u, "test", $building, $user);
        $this->centerDAO->add($center);

        $degree = new Grado(1, 'Titulacion Test', $center, 500, 'Descripcion test', 30, $user);
        $this->degreeDAO->add($degree);

        /*$subject = new Materia(
            1,
            "test",
            "test",
            "te",
            $dep,
            "test",
            "test",
            "1",
            "90",
            1,
            1,
            1,
            "test",
            "test",
            "test",
            5,
            $degree,
            $teacher
        );*/

        $subject = new Materia();
        $subject->setCodigo(1);
        $subject->setCodigo("test");
        $subject->setContenido("test");
        $subject->setTipo("te");
        $subject->setDepartamento($dep);
        $subject->setArea("test");
        $subject->setCurso("test");
        $subject->setCuatrimestre(1);
        $subject->setCreditos(90);
        $subject->setNuevoRegistro(1);
        $subject->setRepeticiones(1);
        $subject->setEstudiantesEfectivos(1);
        $subject->setHorasInscritas("test");
        $subject->setHorasEnseño("test");
        $subject->setHoras("test");
        $subject->setAlumnos(5);
        $subject->setGrado($degree);
        $subject->setProfesor($teacher);

        $this->dao->add($subject);

        return $subject;
    }
}
