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
include_once '../models/tutorial/tutorialDAO.php';
include_once '../models/space/spaceDAO.php';
include_once '../models/user/userDAO.php';
include_once '../models/teacher/teacherDAO.php';
include_once '../models/building/buildingDAO.php';

class TutorialTest
{

    private $dao;
    private $action;
    private $spaceDAO;
    private $userDAO;
    private $teacherDAO;
    private $buildingDAO;

    public function __construct($dao = NULL, $action = NULL)
    {
        $this->dao = $dao;
        $this->action = $action;
        $this->spaceDAO = new SpaceDAO();
        $this->userDAO = new UserDAO();
        $this->teacherDAO = new TeacherDAO();
        $this->buildingDAO = new BuildingDAO();
        $this->render();
    }

    function render()
    {
        switch ($this->action) {
            case "add":
                try {
                    $tutorial = $this->createTutorial();
                    $element = $this->dao->show("idtutoria", $tutorial->getIdtutoria());
                    $result = "Elem. añadido { id: " . $element->getIdtutoria() . ", profesor: " . $element->getIdprofesor()->getUsuario()->getLogin() .
                        ", inicio: " . $element->getFechainicio() . ", fin: " . $element->getFechafin() .
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
                    $tutorial = $this->createTutorial();
                    $this->dao->delete("idtutoria", $tutorial->getIdtutoria());

                    try {
                        $this->dao->show("idtutoria", $tutorial->getIdtutoria());
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
                    $tutorial = $this->createTutorial();
                    $tutorial->setFechainicio("2021-12-28 13:00:00");

                    $this->dao->edit($tutorial);
                    $element = $this->dao->show("idtutoria", $tutorial->getIdtutoria());

                    $result = "Elem. editado: { id: " . $element->getIdtutoria() . ", profesor: " . $element->getIdprofesor()->getUsuario()->getLogin() .
                        ", inicio: " . $element->getFechainicio() . ", fin: " . $element->getFechafin() .
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
                    $tutorial = $this->createTutorial();
                    $element = $this->dao->show("idtutoria", $tutorial->getIdtutoria());

                    $result = "Elem. buscado: { id: " . $element->getIdtutoria() . ", profesor: " . $element->getIdprofesor()->getUsuario()->getLogin() .
                        ", inicio: " . $element->getFechainicio() . ", fin: " . $element->getFechafin() .
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

    function createTutorial()
    {

        $user = new Usuario("userTest", "userTestPass", "11111111H", "user", "test", "usertest@usertest.com", "Calle user 123", "666666666");
        $this->userDAO->add($user);
        $building = new Edificio(1, 'building test', 'Vigo', $user);
        $this->buildingDAO->add($building);
        $space = new Espacio(1, 'Space Test', $building, 400, 'Ofice Test');
        $this->spaceDAO->add($space);
        $teacher = new Profesor(1, $user, 'TEST', $space);
        $this->teacherDAO->add($teacher);

        $tutorial = new Tutoria(1, $teacher, "2021-12-28 12:00:00", "2021-12-28 14:00:00");
        $this->dao->add($tutorial);

        return $tutorial;
    }
}
