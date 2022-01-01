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

class UniversityTest
{

    private $dao;
    private $university;
    private $academicCourseDAO;
    private $userDAO;

    public function __construct($dao = NULL, $university = NULL)
    {
        $this->dao = $dao;
        $this->university = $university;
        $this->academicCourseDAO = new AcademicCourseDAO();
        $this->userDAO = new UserDAO();
        $this->render();
    }

    function render()
    {
        switch ($this->university) {
            case "add":
                try {
                    $cent = $this->createUniversity();
                    $element = $this->dao->show("id", $cent->getId());

                    $result = "Elem. añadido: { id: " . $element->getId() . ", curso: " . $element->getIdCursoAcademico()->getId() .
                        ", nombre: " . $element->getNombre() . ", responsable: " . $element->getIdUsuario()->getLogin() .
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
                    $cent = $this->createUniversity();
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
                    $cent = $this->createUniversity();
                    $cent->setNombre("Nombre editado");

                    $this->dao->edit($cent);
                    $element = $this->dao->show("id", $cent->getId());

                    $result = "Elem. editado: { id: " . $element->getId() . ", curso: " . $element->getIdCursoAcademico()->getId() .
                        ", nombre: " . $element->getNombre() . ", responsable: " . $element->getIdUsuario()->getLogin() .
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
                    $cent = $this->createUniversity();
                    $element = $this->dao->show("id", $cent->getId());

                    $result = "Elem. buscado: { id: " . $element->getId() . ", curso: " . $element->getIdCursoAcademico()->getId() .
                        ", nombre: " . $element->getNombre() . ", responsable: " . $element->getIdUsuario()->getLogin() .
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

    function createUniversity()
    {

        $user = new Usuario("userTest", "userTestPass", "11111111H", "user", "test", "usertest@usertest.com", "Calle user 123", "666666666");
        $this->userDAO->add($user);
        $ac = new CursoAcademico(1, 'test', 2021, 2022);
        $this->academicCourseDAO->add($ac);
        $u = new Universidad(1, 1, "universityTest", "userTest");
        $this->dao->add($u);
        print_r("5hola");

        return $u;
    }
}
