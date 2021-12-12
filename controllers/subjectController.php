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
include_once '../views/subject/subjectAddView.php';
include_once '../views/subject/subjectShowView.php';
include_once '../views/subject/subjectEditView.php';
include_once '../utils/confirmDelete.php';
include_once '../utils/openDeletionModal.php';

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
     case "add":
        if (checkPermission("materia", "ADD") and (IsDepartmentOwner() or IsAdmin())) {
            if (!isset($_POST["submit"])) {
                new SubjectAddView($degreeData, $departmentData, $teacherData);
            } else {
                try {
                    $subject = new Materia();
                    $subject->setCodigo($_POST["code"]);
                    $subject->setContenido($_POST["content"]);
                    $subject->setTipo($_POST["type"]);
                    $subject->setDepartamento($departmentDAO->show("id", $_POST["department_id"]));
                    $subject->setArea($_POST["area"]);
                    $subject->setCurso($_POST["course"]);
                    $subject->setCuatrimestre($_POST["quarter"]);
                    $subject->setCreditos($_POST["credits"]);
                    $subject->setNuevoRegistro($_POST["new_registration"]);
                    $subject->setRepeticiones($_POST["repeaters"]);
                    $subject->setEstudiantesEfectivos($_POST["effective_students"]);
                    $subject->setHorasInscritas($_POST["enrolled_hours"]);
                    $subject->setHorasEnseño($_POST["taught_hours"]);
                    $subject->setHoras($_POST["hours"]);
                    $subject->setAlumnos($_POST["students"]);
                    $subject->setGrado($degreeDAO->show("id", $_POST["degree_id"]));
                    $subject->setProfesor($teacherDAO->show("id", $_POST["teacher_id"]));
                    $subjectDAO->add($subject);
                    goToShowAllAndShowSuccess("Materia añadida correctamente.");
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
        if (checkPermission("materia", "DELETE") and (IsDepartmentOwner() or IsAdmin())) {
            $subject = $subjectDAO->show($subjectPK, $value);
            if (isset($_REQUEST["confirm"])) {
                try {
                    $subjectDAO->delete($subjectPK, $value);
                    goToShowAllAndShowSuccess("Materia eliminada correctamente.");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            } else {
                try {
                    $subjectDAO->checkDependencies($value);
                    showAll();
                    openDeletionModal("Eliminar materia", "¿Está seguro de que desea eliminar " .
                        "la materia %" . $subject->getCodigo() . "%? Esta acción es permanente y no se puede recuperar.",
                        "../controllers/subjectController.php?action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.");
        }
        break;
    case "show":
        if (checkPermission("materia", "SHOWCURRENT")) {
            try {
                $subjectData = $subjectDAO->show($subjectPK, $value);
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
        if (checkPermission("materia", "EDIT") and (IsDepartmentOwner() or IsAdmin())) {
            try {
                $subject = $subjectDAO->show($subjectPK, $value);
                if (!isset($_POST["submit"])) {
                    new SubjectEditView($subject, $degreeData, $departmentData, $teacherData);
                } else {
                    $subject->setId($value);
                    $subject->setCodigo($_POST["code"]);
                    $subject->setContenido($_POST["content"]);
                    $subject->setTipo($_POST["type"]);
                    $subject->setDepartamento($departmentDAO->show("id", $_POST["department_id"]));
                    $subject->setArea($_POST["area"]);
                    $subject->setCurso($_POST["course"]);
                    $subject->setCuatrimestre($_POST["quarter"]);
                    $subject->setCreditos($_POST["credits"]);
                    $subject->setNuevoRegistro($_POST["new_registration"]);
                    $subject->setRepeticiones($_POST["repeaters"]);
                    $subject->setEstudiantesEfectivos($_POST["effective_students"]);
                    $subject->setHorasInscritas($_POST["enrolled_hours"]);
                    $subject->setHorasEnseño($_POST["taught_hours"]);
                    $subject->setHoras($_POST["hours"]);
                    $subject->setAlumnos($_POST["students"]);
                    $subject->setGrado($degreeDAO->show("id", $_POST["degree_id"]));
                    $subject->setProfesor($teacherDAO->show("id", $_POST["teacher_id"]));
                    $subjectDAO->edit($subject);
                    goToShowAllAndShowSuccess("Materia editada correctamente.");
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
        if (checkPermission("materia", "SHOWALL")) {
            try {
                // TODO Bruno
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage());
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage());
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para buscar.");
        }
        break;
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