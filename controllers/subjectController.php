<?php

session_start();
include_once '../utils/auth.php';
include_once '../utils/CheckPermission.php';

if (!IsAuthenticated()) {
    header('Location:../index.php');
}

include_once '../utils/pagination.php';
include_once '../models/functionality/functionalityDAO.php';
include_once '../models/common/DAOException.php';
include_once '../views/common/head.php';
include_once '../views/common/headerMenu.php';
include_once '../views/common/paginationView.php';
include_once '../models/subject/subjectDAO';
include_once '../models/degree/degreeDAO';
include_once '../models/department/departmentDAO';
include_once '../models/teacher/teacherDAO';
include_once '../utils/isAdmin.php';
include_once '../utils/isDepartmentOwner.php';
include_once '../utils/isSubjectOwner.php';
include_once '../views/subject/subjectShowAllView.php';

$subjectDAO = new SubjectDAO();
$degreeDAO = new DegreeDAO();
$departmentDAO = new DepartmentDAO();
$teacherDAO = new TeacherDAO();

$degreeData = $degreeDAO->showAll();
$departmentData = $departmentDAO->showAll();
$teacherData = $teacherDAO->showAll();
$subjectPK = "id";
$value = $_REQUEST[$subjectPK];
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
/*     case "add":
        if (HavePermission("Subject", "ADD") and (IsDepartmentOwner()!==false or IsAdmin())) {
            if (!isset($_POST["submit"])) {
                new SubjectAddView($degreeData, $departmentData, $teacherData);
            } else {
                try {
                    $subject = new Subject();
                    $subject->setCode($_POST["code"]);
                    $subject->setContent($_POST["content"]);
                    $subject->setType($_POST["type"]);
                    $subject->setDepartment($departmentDAO->show("id", $_POST["department_id"]));
                    $subject->setArea($_POST["area"]);
                    $subject->setCourse($_POST["course"]);
                    $subject->setQuarter($_POST["quarter"]);
                    $subject->setCredits($_POST["credits"]);
                    $subject->setNewRegistration($_POST["new_registration"]);
                    $subject->setRepeaters($_POST["repeaters"]);
                    $subject->setEffectiveStudents($_POST["effective_students"]);
                    $subject->setEnrolledHours($_POST["enrolled_hours"]);
                    $subject->setTaughtHours($_POST["taught_hours"]);
                    $subject->setHours($_POST["hours"]);
                    $subject->setStudents($_POST["students"]);
                    $subject->setDegree($degreeDAO->show("id", $_POST["degree_id"]));
                    $subject->setTeacher($teacherDAO->show("id", $_POST["teacher_id"]));
                    $subjectDAO->add($subject);
                    goToShowAllAndShowSuccess("Asignatura añadida correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                } catch (ValidationException $ve) {
                    goToShowAllAndShowError($ve->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para añadir.");
        }
        break;
    case "delete":
        if (HavePermission("Subject", "DELETE") and (IsDepartmentOwner()!==false or IsAdmin())) {
            $subject = $subjectDAO->show($subjectPrimaryKey, $value);
            if (isset($_REQUEST["confirm"])) {
                try {
                    $subjectDAO->delete($subjectPrimaryKey, $value);
                    goToShowAllAndShowSuccess("Asignatura eliminada correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    $subjectDAO->checkDependencies($value);
                    showAll();
                    openDeletionModal("Eliminar asignatura", "¿Está seguro de que desea eliminar " .
                        "la asignatura %" . $value . "%? Esta acción es permanente y no se puede recuperar.",
                        "../Controllers/SubjectController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "show":
        if (HavePermission("Subject", "SHOWCURRENT")) {
            try {
                $subjectData = $subjectDAO->show($subjectPrimaryKey, $value);
                new SubjectShowView($subjectData);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage());
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para visualizar la entidad.");
        }
        break;
    case "edit":
        if (HavePermission("Subject", "EDIT") and (IsDepartmentOwner()!==false or IsAdmin())) {
            try {
                $subject = $subjectDAO->show($subjectPrimaryKey, $value);
                if (!isset($_POST["submit"])) {
                    new SubjectEditView($subject, $degreeData, $departmentData, $teacherData);
                } else {
                    $subject->setId($value);
                    $subject->setCode($_POST["code"]);
                    $subject->setContent($_POST["content"]);
                    $subject->setType($_POST["type"]);
                    $subject->setDepartment($departmentDAO->show("id", $_POST["department_id"]));
                    $subject->setArea($_POST["area"]);
                    $subject->setCourse($_POST["course"]);
                    $subject->setQuarter($_POST["quarter"]);
                    $subject->setCredits($_POST["credits"]);
                    $subject->setNewRegistration($_POST["new_registration"]);
                    $subject->setRepeaters($_POST["repeaters"]);
                    $subject->setEffectiveStudents($_POST["effective_students"]);
                    $subject->setEnrolledHours($_POST["enrolled_hours"]);
                    $subject->setTaughtHours($_POST["taught_hours"]);
                    $subject->setHours($_POST["hours"]);
                    $subject->setStudents($_POST["students"]);
                    $subject->setDegree($degreeDAO->show("id", $_POST["degree_id"]));
                    $subject->setTeacher($teacherDAO->show("id", $_POST["teacher_id"]));
                    $subjectDAO->edit($subject);
                    goToShowAllAndShowSuccess("Asignatura editada correctamente.");
                }
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage());
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para editar.");
        }
        break;
    case "search":
        if (HavePermission("Subject", "SHOWALL")) {
            if (!isset($_POST["submit"])) {
                new SubjectSearchView($degreeData, $departmentData, $teacherData);
            } else {
                try {
                    $subject = new Subject();
                    if (!empty($_POST["code"])) {
                        $subject->setCode($_POST["content"]);
                    }
                    if (!empty($_POST["acronym"])) {
                        $subject->setAcronym($_POST["acronym"], NULL);
                    }
                    if (!empty($_POST["content"])) {
                        $subject->setContent($_POST["content"]);
                    }
                    if (!empty($_POST["type"])) {
                        $subject->setType($_POST["type"]);
                    }
                    if (!empty($_POST["department_id"])) {
                        $subject->setDepartment($departmentDAO->show("id", $_POST["department_id"]));
                    }
                    if (!empty($_POST["area"])) {
                        $subject->setArea($_POST["area"]);
                    }
                    if (!empty($_POST["course"])) {
                        $subject->setCourse($_POST["course"]);
                    }
                    if (!empty($_POST["quarter"])) {
                        $subject->setQuarter($_POST["quarter"]);
                    }
                    if (!empty($_POST["credits"])) {
                        $subject->setCredits($_POST["credits"]);
                    }
                    if (!empty($_POST["new_registration"])) {
                        $subject->setNewRegistration($_POST["new_registration"]);
                    }
                    if (!empty($_POST["repeaters"])) {
                        $subject->setRepeaters($_POST["repeaters"]);
                    }
                    if (!empty($_POST["effective_students"])) {
                        $subject->setEffectiveStudents($_POST["effective_students"]);
                    }
                    if (!empty($_POST["enrolled_hours"])) {
                        $subject->setEnrolledHours($_POST["enrolled_hours"]);
                    }
                    if (!empty($_POST["taught_hours"])) {
                        $subject->setTaughtHours($_POST["taught_hours"]);
                    }
                    if (!empty($_POST["hours"])) {
                        $subject->setHours($_POST["hours"]);
                    }
                    if (!empty($_POST["students"])) {
                        $subject->setStudents($_POST["students"]);
                    }
                    if (!empty($_POST["degree_id"])) {
                        $subject->setDegree($degreeDAO->show("id", $_POST["degree_id"]));
                    }
                    if (!empty($_POST["teacher_id"])) {
                        $subject->setTeacher($teacherDAO->show("id", $_POST["teacher_id"]));
                    }
                    showAllSearch($subject);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                } catch (ValidationException $ve) {
                    goToShowAllAndShowError($ve->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para buscar.");
        }
        break; */
    default:
        showAll();
        break;
}

function showAll() {
    showAllSearch(NULL);
}

function showAllSearch($search) {
    if (checkPermission("materia", "SHOWALL")) {
        try {
            $break = false;
            $searching = false;
            $departmentOwner = false;

            if(!empty($search)){
                $searching=true;
            }
            if (!IsAdmin()) {
                $department = IsDepartmentOwner();
                if (empty($department)) {
                    $test = IsSubjectOwner();
                    if (empty($test)) {
                        $sub = IsSubjectTeacher();
                        if (empty($sub)) {
                            $break = true;
                            new SubjectShowAllView(array());
                        } else {
                            $return = $sub;
                            $searching=false;
                        }
                    } else {
                        $sub = IsSubjectTeacher();
                        if (!empty($sub)) {
                            foreach ($sub as $s) {
                                array_push($test, $s);
                            }
                        }
                        $return = $test;
                    }
                } else {
                    $departmentOwner=true;
                    $return = array();
                    $sub = new Materia();

                    foreach ($department as $dep) {
                        $sub = new Materia();
                        $sub->setDepartamento($dep);
                        array_push($return, $sub);
                    }
                    $sub1 = IsSubjectOwner();
                    if (!empty($sub1)) {
                        foreach ($sub1 as $s1) {
                            array_push($return, $s1);
                        }
                    }

                    $sub2 = IsSubjectTeacher();
                    if (!empty($sub2)) {
                        foreach ($sub2 as $s2) {
                            array_push($return, $s2);
                        }
                    }
                }
            }else{
                $departmentOwner=true;
            }

            if (!$break) {
                $currentPage = getPage();
                $itemsPerPage = getNumberItems();
                $totalSubjects = 0;

                if (!empty($return) && count($return) == 1) {

                    $search = $return[0];
                    $totalSubjects = $GLOBALS["subjectDAO"]->countTotalSubjects($toSearch);
                    $subjectsData = $GLOBALS["subjectDAO"]->showAllPaged($currentPage, $itemsPerPage);

                    new SubjectShowAllView(unique_array($subjectsData), $itemsPerPage, $currentPage, $totalSubjects, $search, $searching, $departmentOwner);
                } elseif (count($return) > 1) {

                    $subjectsData = array();
                    foreach ($return as $sub) {
                        $search = $sub;
                        $toSearch = getToSearch($search);
                        $totalSubjects += $GLOBALS["subjectDAO"]->countTotalSubjects($toSearch);
                        $data = $GLOBALS["subjectDAO"]->showAllPaged($currentPage, $itemsPerPage);
                        foreach ($data as $dat) {
                            array_push($subjectsData, $dat);
                        }
                    }
                    new SubjectShowAllView(unique_array($subjectsData), $itemsPerPage, $currentPage, $totalSubjects, $search, $searching, $departmentOwner);
                } else {

                    $totalSubjects = $GLOBALS["subjectDAO"]->countTotalSubjects();
                    $subjectsData = $GLOBALS["subjectDAO"]->showAllPaged($currentPage, $itemsPerPage);
                    new SubjectShowAllView($subjectsData, $itemsPerPage, $currentPage, $totalSubjects, $search, $searching, $departmentOwner);
                }
            }

        } catch (DAOException $e) {
            new SubjectShowAllView(array());
            errorMessage($e->getMessage());
        }
    } else {
        accessDenied();
    }
}

function unique_array($return) {
    if (!empty($return)) {
        $aux = array($return[0]);
        foreach ($return as $sub) {
            $distinct = true;
            foreach ($aux as $s) {
                if ($sub->getId() == $s->getId()) {
                    $distinct=false;
                }
            }
            if($distinct){
                array_push($aux, $sub);
            }

        }
        $return = $aux;
    }
    return $return;
}

function goToShowAllAndShowError($message) {
    showAll();
    include '../models/common/messageType.php';
    include '../utils/ShowToast.php';
    $messageType = MessageType::ERROR;
    showToast($messageType, $message);
}

function goToShowAllAndShowSuccess($message) {
    showAll();
    include '../models/common/messageType.php';
    include '../utils/ShowToast.php';
    $messageType = MessageType::SUCCESS;
    showToast($messageType, $message);
}