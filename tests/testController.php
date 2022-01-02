<?php
session_start();
include_once '../utils/auth.php';
include_once '../utils/isAdmin.php';
if (!IsAuthenticated()) {
    header('Location:../index.php');
}

include_once '../utils/tests/databaseTest.php';
include_once '../utils/pagination.php';
include_once '../views/common/head.php';
include_once '../views/common/headerMenu.php';
include_once '../views/common/paginationView.php';
include_once '../utils/openDeletionModal.php';
include_once '../utils/confirmDelete.php';
include_once '../models/common/DAOException.php';
include_once '../views/tests/testShowAllView.php';

$controller = isset($_REQUEST['controller']) ? $_REQUEST['controller'] : "";
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($controller) {

    case "permission":
        if (IsAdmin()) {
            try {
                $_SESSION["env"] = "test";
                include_once '../models/permission/permissionDAO.php';
                include_once 'permissionTest.php';
                initTestDB();
                new PermissionTest(new PermissionDAO(), $action);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            } finally {
                $_SESSION["env"] = NULL;
                restoreDB();
            }
        }
        break;
    case "role":
        try {
            $_SESSION["env"] = "test";
            include_once '../models/role/roleDAO.php';
            include_once 'roleTest.php';
            initTestDB();
            new RoleTest(new RoleDAO(), $action);
        } catch (DAOException $e) {
            goToShowAllAndShowError($e->getMessage());
        } finally {
            $_SESSION["env"] = NULL;
            restoreDB();
        }
        break;
    case "action":
        try {
            $_SESSION["env"] = "test";
            include_once '../models/action/actionDAO.php';
            include_once 'actionTest.php';
            initTestDB();
            new ActionTest(new ActionDAO(), $action);
        } catch (DAOException $e) {
            goToShowAllAndShowError($e->getMessage());
        } finally {
            $_SESSION["env"] = NULL;
            restoreDB();
        }
        break;
    case "funcAction":
        try {
            $_SESSION["env"] = "test";
            include_once '../models/funcAction/funcActionDAO.php';
            include_once 'funcActionTest.php';
            initTestDB();
            new FuncActionTest(new FuncActionDAO(), $action);
        } catch (DAOException $e) {
            goToShowAllAndShowError($e->getMessage());
        } finally {
            $_SESSION["env"] = NULL;
            restoreDB();
        }
        break;
    case "userRole":
        try {
            $_SESSION["env"] = "test";
            include_once '../models/userRole/userRoleDAO.php';
            include_once 'userRoleTest.php';
            initTestDB();
            new UserRoleTest(new UserRoleDAO(), $action);
        } catch (DAOException $e) {
            goToShowAllAndShowError($e->getMessage());
        } finally {
            $_SESSION["env"] = NULL;
            restoreDB();
        }
        break;
    case "user":
        try {
            $_SESSION["env"] = "test";
            include_once '../models/user/userDAO.php';
            include_once 'userTest.php';
            initTestDB();
            new UserTest(new UserDAO(), $action);
        } catch (DAOException $e) {
            goToShowAllAndShowError($e->getMessage());
        } finally {
            $_SESSION["env"] = NULL;
            restoreDB();
        }
        break;
    case "functionality":
        try {
            $_SESSION["env"] = "test";
            include_once '../models/functionality/functionalityDAO.php';
            include_once 'functionalityTest.php';
            initTestDB();
            new FunctionalityTest(new FunctionalityDAO(), $action);
        } catch (DAOException $e) {
            goToShowAllAndShowError($e->getMessage());
        } finally {
            $_SESSION["env"] = NULL;
            restoreDB();
        }
        break;
    case "academicCourse":
        try {
            $_SESSION["env"] = "test";
            include_once '../models/academicCourse/academicCourseDAO.php';
            include_once 'academicCourseTest.php';
            initTestDB();
            new AcademicCourseTest(new AcademicCourseDAO(), $action);
        } catch (DAOException $e) {
            goToShowAllAndShowError($e->getMessage());
        } finally {
            $_SESSION["env"] = NULL;
            restoreDB();
        }
        break;
    case "center":
        try {
            $_SESSION["env"] = "test";
            include_once '../models/center/centerDAO.php';
            include_once 'centerTest.php';
            initTestDB();
            new CenterTest(new CenterDAO(), $action);
        } catch (DAOException $e) {
            goToShowAllAndShowError($e->getMessage());
        } finally {
            $_SESSION["env"] = NULL;
            restoreDB();
        }
        break;
    case "university":
        try {
            $_SESSION["env"] = "test";
            include_once '../models/university/universityDAO.php';
            include_once 'universityTest.php';
            initTestDB();
            new UniversityTest(new UniversityDAO(), $action);
        } catch (DAOException $e) {
            goToShowAllAndShowError($e->getMessage());
        } finally {
            $_SESSION["env"] = NULL;
            restoreDB();
        }
        break;
    case "degree":
        try {
            $_SESSION["env"] = "test";
            include_once '../models/degree/degreeDAO.php';
            include_once 'degreeTest.php';
            initTestDB();
            new DegreeTest(new DegreeDAO(), $action);
        } catch (DAOException $e) {
            goToShowAllAndShowError($e->getMessage());
        } finally {
            $_SESSION["env"] = NULL;
            restoreDB();
        }
        break;
    case "teacher":
        try {
            $_SESSION["env"] = "test";
            include_once '../models/teacher/teacherDAO.php';
            include_once 'teacherTest.php';
            initTestDB();
            new TeacherTest(new TeacherDAO(), $action);
        } catch (DAOException $e) {
            goToShowAllAndShowError($e->getMessage());
        } finally {
            $_SESSION["env"] = NULL;
            restoreDB();
        }
        break;
    case "tutorial":
        try {
            $_SESSION["env"] = "test";
            include_once '../models/tutorial/tutorialDAO.php';
            include_once 'tutorialTest.php';
            initTestDB();
            new TutorialTest(new TutorialDAO(), $action);
        } catch (DAOException $e) {
            goToShowAllAndShowError($e->getMessage());
        } finally {
            $_SESSION["env"] = NULL;
            restoreDB();
        }
        break;
    case "department":
        try {
            $_SESSION["env"] = "test";
            include_once '../models/department/departmentDAO.php';
            include_once 'departmentTest.php';
            initTestDB();
            new DepartmentTest(new DepartmentDAO(), $action);
        } catch (DAOException $e) {
            goToShowAllAndShowError($e->getMessage());
        } finally {
            $_SESSION["env"] = NULL;
            restoreDB();
        }
        break;
    case "subject":
        try {
            $_SESSION["env"] = "test";
            include_once '../models/subject/subjectDAO.php';
            include_once 'subjectTest.php';
            initTestDB();
            new SubjectTest(new SubjectDAO(), $action);
        } catch (DAOException $e) {
            goToShowAllAndShowError($e->getMessage());
        } finally {
            $_SESSION["env"] = NULL;
            restoreDB();
        }
        break;
    case "building":
        try {
            $_SESSION["env"] = "test";
            include_once '../models/building/buildingDAO.php';
            include_once 'buildingTest.php';
            initTestDB();
            new BuildingTest(new BuildingDAO(), $action);
        } catch (DAOException $e) {
            goToShowAllAndShowError($e->getMessage());
        } finally {
            $_SESSION["env"] = NULL;
            restoreDB();
        }
        break;
    case "space":
        try {
            $_SESSION["env"] = "test";
            include_once '../models/space/spaceDAO.php';
            include_once 'spaceTest.php';
            initTestDB();
            new SpaceTest(new SpaceDAO(), $action);
        } catch (DAOException $e) {
            goToShowAllAndShowError($e->getMessage());
        } finally {
            $_SESSION["env"] = NULL;
            restoreDB();
        }
        break;
    case "group":
        try {
            $_SESSION["env"] = "test";
            include_once '../models/group/groupDAO.php';
            include_once 'groupTest.php';
            initTestDB();
            new GroupTest(new GroupDAO(), $action);
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
