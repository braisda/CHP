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
include_once '../models/academicCourse/academicCourseDAO.php';

class AcademicCourseTest
{

    private $dao;
    private $academicCourse;

    public function __construct($dao = NULL, $academicCourse = NULL)
    {
        $this->dao = $dao;
        $this->academicCourse = $academicCourse;
        $this->render();
    }

    function render()
    {
        switch ($this->academicCourse) {
            case "add":
                try {
                    $act = $this->createAcademicCourse();
                    $element = $this->dao->show("id", $act->getId());
                    $result = "Elem. añadido: { id: " . $element->getId() . ", nombre: " . $element->getNombre() .
                        ", inicio: " . $element->getAnoinicio() . ", fin: " . $element->getAnofin() .
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
                    $act = $this->createAcademicCourse();
                    $this->dao->delete("id", $act->getId());

                    try {
                        $this->dao->show("id", $act->getId());
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
                    $act = $this->createAcademicCourse();
                    $act->setNombre("Nombre editado");

                    $this->dao->edit($act);
                    $element = $this->dao->show("id", $act->getId());

                    $result = "Elem. editado: { id: " . $element->getId() . ", nombre: " . $element->getNombre() .
                        ", inicio: " . $element->getAnoinicio() . ", fin: " . $element->getAnofin() .
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
                    $act = $this->createAcademicCourse();
                    $element = $this->dao->show("id", $act->getId());

                    $result = "Elem. buscado: { id: " . $element->getId() . ", nombre: " . $element->getNombre() .
                        ", inicio: " . $element->getAnoinicio() . ", fin: " . $element->getAnofin() .
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

    function createAcademicCourse()
    {

        $ac = new CursoAcademico(1, 'test', 2021, 2022);
        $this->dao->add($ac);

        return $ac;
    }
}
