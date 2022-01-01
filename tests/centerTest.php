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
include_once '../models/center/centerDAO.php';
include_once '../models/center/universityDAO.php';
include_once '../models/center/buildingDAO.php';
include_once '../models/center/userDAO.php';

class CenterTest
{

    private $dao;
    private $center;
    private $academicCourseDAO;
    private $universityDAO;
    private $buildingDAO;
    private $userDAO;

    public function __construct($dao = NULL, $center = NULL)
    {
        $this->dao = $dao;
        $this->center = $center;
        $this->academicCourseDAO = new AcademicCourseDAO();
        $this->universityDAO = new UniversityDAO();
        $this->buildingDAO = new BuildingDAO();
        $this->userDAO = new UserDAO();
        $this->render();
    }

    function render()
    {
        switch ($this->center) {
            case "add":
                try {
                    $cent = $this->createCenter();
                    $element = $this->dao->show("id", $cent->getId());

                    $result = "Elem. añadido: { id: " . $element->getId() . ", universidad: " . $element->getUniversidad()->getId() .
                        ", nombre: " . $element->getNombre() . ", edificio: " . $element->getEdificio()->getId() . ", usuario: " . $element->getUsuario()->getLogin() .
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
                    $cent = $this->createCenter();
                    $this->dao->delete("id", $cent->getId());

                    try {
                        $this->dao->show("id", $cent->getId());
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
                    $cent = $this->createCenter();
                    $cent->setNombre("Nombre editado");

                    $this->dao->edit($cent);
                    $element = $this->dao->show("id", $cent->getId());

                    $result = "Elem. editado: { id: " . $element->getId() . ", universidad: " . $element->getUniversidad()->getId() .
                        ", nombre: " . $element->getNombre() . ", edificio: " . $element->getEdificio()->getId() . ", usuario: " . $element->getUsuario()->getLogin() .
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
                    $cent = $this->createCenter();
                    $element = $this->dao->show("id", $cent->getId());

                    $result = "Elem. buscado: { id: " . $element->getId() . ", universidad: " . $element->getUniversidad()->getId() .
                        ", nombre: " . $element->getNombre() . ", edificio: " . $element->getEdificio()->getId() . ", usuario: " . $element->getUsuario()->getLogin() .
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

    function createCenter()
    {

        $user = new Usuario("userTest", "userTestPass", "11111111H", "user", "test", "usertest@usertest.com", "Calle user 123", "666666666");
        $this->userDAO->add($user);
        $b = new Edificio(1, "test", "test", "userTest");
        $this->buildingDAO->add($b);
        $ac = new CursoAcademico(1, 'test', 2021, 2022);
        $this->academicCourseDAO->add($ac);
        $u = new Universidad(1, 1, "universityTest", "userTest");
        $this->universityDAO->add($u);
        $cent = new Centro(1, $u, 'centerTest', $b, $user);
        $this->dao->add($cent);

        return $cent;
    }
}
