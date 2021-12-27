<?php
session_start();
include_once '../utils/auth.php';
include_once '../utils/CheckPermission.php';

if (!IsAuthenticated()){
    header('Location:../index.php');
}

include_once '../utils/pagination.php';
include_once '../models/common/DAOException.php';
include_once '../views/common/head.php';
include_once '../views/common/headerMenu.php';
include_once '../views/common/paginationView.php';
include_once '../utils/confirmDelete.php';
include_once '../utils/openDeletionModal.php';
include_once '../models/schedule/scheduleDAO.php';
include_once '../models/teacher/teacherDAO.php';
include_once '../models/group/groupDAO.php';
include_once '../models/space/spaceDAO.php';
include_once '../views/schedule/scheduleShowAllView.php';
include_once '../views/schedule/scheduleAddView.php';
include_once '../views/schedule/scheduleShowView.php';
include_once '../views/schedule/scheduleEditView.php';
include_once '../views/schedule/scheduleEditByRangeView.php';

$scheduleDAO = new ScheduleDAO();
$teacherDAO = new TeacherDAO();
$subjectGroupDAO = new GroupDAO();
$subjectDAO = new SubjectDAO();
$spaceDAO = new SpaceDAO();
$teacherData = $teacherDAO->showAll();
$spaceData = $spaceDAO->showAll();
$allSubjectGroupData = $subjectGroupDAO->showAll();
$subjectGroupData = array();

if(isset($_REQUEST["subject"])) {
    $subjectId = $_REQUEST["subject"];
    $subject = $subjectDAO->show("id", $subjectId);

    foreach($allSubjectGroupData as $subjectGroup) {
        if ($subjectGroup->getIdmateria()->getId() == $subject->getId()) {
            array_push($subjectGroupData, $subjectGroup);
        }
    }
}

$schedulePK = "id";
$value = $_REQUEST[$schedulePK];

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (checkPermission("horario", "ADD")) {
            if (!isset($_POST["submit"])) {
                        new ScheduleAddView($teacherData, $spaceData, $subjectGroupData);
                    } else {
                        try {
                            $weekday = "";
                            $startDate = strtotime($_POST["start_day"]);
                            $endDate = strtotime($_POST["end_day"]);
                            $startHour = strtotime($_POST["start_hour"]);
                            $endHour = strtotime($_POST["end_hour"]);
                            $busyTeacher = array();
                            $busySpace = array();
                    $freeSchedule = array();
                    for ($i = $startDate; $i <= $endDate; $i += 86400) {
                        if ($i === $startDate) {
                          $weekday = getWeekday($i);
                        }
                        if ($weekday === getWeekday($i)) {
                            $schedule = new Horario();
                            $schedule->setEspacio($spaceDAO->show("id", $_POST["space_id"]));
                            $schedule->setProfesor($teacherDAO->show("id", $_POST["teacher_id"]));
                            $schedule->setGrupoMateria($subjectGroupDAO->show("id", $_POST["subject_group_id"]));
                            $schedule->setDia(date("Y-m-d", $i));
                            $schedule->setHoraInicio($_POST["start_hour"]);
                            $schedule->setHoraFin($_POST["end_hour"]);
                            $isTeacherUsed = $scheduleDAO->checkIfTeacherIsUsed($_POST["teacher_id"], date("Y-m-d", $i), date("H:i:s", $startHour),
                                date("H:i:s", $endHour));
                            $isSpaceUsed = $scheduleDAO->checkIfSpaceIsUsed($_POST["teacher_id"], date("Y-m-d", $i), date("H:i:s", $startHour),
                                date("H:i:s", $endHour));

                            if ($isTeacherUsed || $isSpaceUsed) {
                                if ($isSpaceUsed) {
                                    array_push($busySpace, $schedule);
                                }
                                if ($isTeacherUsed) {
                                    array_push($busyTeacher, $schedule);
                                }
                            } else {
                                array_push($freeSchedule, $schedule);
                            }
                        }
                    }
                    $busyTeacherString = "";
                    $busySpaceString = "";
                    if(!empty($busyTeacher)) {
                        foreach ($busyTeacher as $scheduleTeacher) {
                            if($busyTeacherString === "") {
                                $busyTeacherString .= "El profesor %" . $scheduleTeacher->getProfesor()->getUsuario()->getNombre() .
                                    " " . $scheduleTeacher->getProfesor()->getUsuario()->getApellido() . "% está ocupado los días %" .
                                    $scheduleTeacher->getDia();
                            } else {
                                $busyTeacherString .= ", " . $scheduleTeacher->getDia();
                            }
                        }
                        if($busyTeacherString !== "") {
                            $busyTeacherString .= "%";
                        }
                    }
                    if(!empty($busySpace)) {
                        foreach ($busySpace as $scheduleSpace) {
                            if($busySpaceString === "") {
                                $busySpaceString .= "El aula %" . $scheduleSpace->getEspacio()->getNombre() ."% está ocupada los días %" .
                                    $scheduleSpace->getDia();
                            } else {
                                $busySpaceString .= ", " . $scheduleSpace->getDia();
                            }
                        }
                        if($busySpaceString !== "") {
                            $busySpaceString .= "%";
                        }
                    }
                    if($busySpaceString !== "" || $busyTeacherString !== "") {
                        showConfirmationModal($busyTeacherString, $busySpaceString, $freeSchedule, $subjectId, "addConfirmed", $subjectGroupData, $spaceData, $teacherData);
                    } else {
                        addSchedule($freeSchedule);
                        goToShowAllAndShowSuccess("Horario añadido correctamente.", $subjectGroupData, $spaceData, $teacherData);
                    }
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage(), $subjectGroupData, $spaceData, $teacherData);
                } catch (ValidationException $ve) {
                    goToShowAllAndShowError($ve->getMessage(), $subjectGroupData, $spaceData, $teacherData);
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para añadir.", $subjectGroupData, $spaceData, $teacherData);
        }
        break;
    case "show":
        if (checkPermission("horario", "SHOWCURRENT")) {
            try {
                $scheduleData = $scheduleDAO->show($schedulePK, $value);
                new ScheduleShowView($scheduleData);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $subjectGroupData, $spaceData, $teacherData);
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage(), $subjectGroupData, $spaceData, $teacherData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para visualizar la entidad.", $subjectGroupData, $spaceData, $teacherData);
        }
        break;
    case "edit":
        if (checkPermission("horario", "EDIT")) {
            try {
                $schedule = $scheduleDAO->show($schedulePK, $value);
                if (!isset($_POST["submit"])) {
                    new ScheduleEditView($schedule, $teacherData, $spaceData, $subjectGroupData);
                } else {
                    $schedule->setId($value);
                    $schedule->setEspacio($spaceDAO->show("id", $_POST["space_id"]));
                    $schedule->setProfesor($teacherDAO->show("id", $_POST["teacher_id"]));
                    $schedule->setGrupoMateria($subjectGroupDAO->show("id", $_POST["subject_group_id"]));
                    $schedule->setDia($_POST["day"]);
                    $schedule->setHoraInicio($_POST["start_hour"]);
                    $schedule->setHoraFin($_POST["end_hour"]);
                    $scheduleDAO->edit($schedule);
                    goToShowAllAndShowSuccess("Horario editado correctamente.", $subjectGroupData, $spaceData, $teacherData);
                }
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $subjectGroupData, $spaceData, $teacherData);
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage(), $subjectGroupData, $spaceData, $teacherData);
            }
        } else{
            goToShowAllAndShowError("No tienes permiso para editar.", $subjectGroupData, $spaceData, $teacherData);
        }
        break;
    case "delete":
        if (checkPermission("horario", "DELETE")) {
            $schedule = $scheduleDAO->show($schedulePK, $value);
            if (isset($_REQUEST["confirm"])) {
                try {
                    $scheduleDAO->delete($schedulePK, $value);
                    goToShowAllAndShowSuccess("Horario eliminado correctamente.", $subjectGroupData, $spaceData, $teacherData);
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage(), $subjectGroupData, $spaceData, $teacherData);
                }
            } else {
                try {
                    showAll(NULL, $subjectGroupData, $spaceData, $teacherData);
                    openDeletionModal("Eliminar horario", "¿Está seguro de que desea eliminar " .
                        "el horario %" . $schedule->getGrupoMateria()->getIdmateria()->getAcronimo() .'_'. $schedule->getGrupoMateria()->getNombre() . "%? Esta acción es permanente y no se puede recuperar.",
                        "../controllers/scheduleController.php?subject=". $subjectId . "&action=delete&id=" . $value . "&confirm=true");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage(), $subjectGroupData, $spaceData, $teacherData);
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para eliminar.", $subjectGroupData, $spaceData, $teacherData);
        }
        break;
    case "addConfirmed":
        addSchedule(unserialize(base64_decode($_POST["schedules_to_insert"])));
        goToShowAllAndShowSuccess("Horario añadido correctamente.", $subjectGroupData, $spaceData, $teacherData);
        break;
    case "editConfirmed":
        editSchedule(unserialize(base64_decode($_POST["schedules_to_insert"])));
        goToShowAllAndShowSuccess("Horario añadido correctamente.", $subjectGroupData, $spaceData, $teacherData);
        break;
    case "editByRange":
        if (checkPermission("horario", "EDIT")) {
            if (!isset($_POST["submit"])) {
                new ScheduleEditByRangeView($teacherData, $spaceData, $subjectGroupData);
            } else {
                try {
                    $startDate=strtotime($_POST["start_day"]);
                    $endDate=strtotime($_POST["end_day"]);
                    $group=$_POST["subject_group_id"];
                    if(!empty($_POST["start_hour"])) {
                        $startHour = strtotime($_POST["start_hour"]);
                    }
                    if(!empty($_POST["end_hour"])) {
                        $endHour = strtotime($_POST["end_hour"]);
                    }
                    $busyTeacher=array();
                    $busySpace=array();
                    $schedulesToEdit = $scheduleDAO->getAllSchedulesByRange(date("Y-m-d", $startDate), date("Y-m-d", $endDate), $group);
                    $freeSchedule=array();
                    foreach ($schedulesToEdit as $scheduleToEdit) {
                        if(!empty($_POST["space_id"])) {
                            $scheduleToEdit->setEspacio($spaceDAO->show("id", $_POST["space_id"]));
                        }
                        if(!empty($_POST["teacher_id"])) {
                            $scheduleToEdit->setProfesor($teacherDAO->show("id", $_POST["teacher_id"]));
                        }
                        if(!empty($_POST["start_hour"])) {
                            $scheduleToEdit->setHoraInicio($_POST["start_hour"]);
                        }
                        if(!empty($_POST["end_hour"])) {
                            $scheduleToEdit->setHoraFin($_POST["end_hour"]);
                        }

                        $isTeacherUsed = false;
                        $isSpaceUsed = false;

                        $isTeacherUsed = $scheduleDAO->checkIfTeacherIsUsedLessId($scheduleToEdit->getProfesor()->getId(),
                            date("Y-m-d", strtotime($scheduleToEdit->getDia())), date("H:i:s", $startHour),
                            date("H:i:s", $endHour), $scheduleToEdit->getId());

                        $isSpaceUsed = $scheduleDAO->checkIfSpaceIsUsedLessId($scheduleToEdit->getEspacio()->getId(),
                            date("Y-m-d", strtotime($scheduleToEdit->getDia())), date("H:i:s", $startHour),
                            date("H:i:s", $endHour), $scheduleToEdit->getId());

                        if ($isTeacherUsed || $isSpaceUsed) {
                            if ($isSpaceUsed) {
                                array_push($busySpace, $scheduleToEdit);
                            }
                            if ($isTeacherUsed) {
                                array_push($busyTeacher, $scheduleToEdit);
                            }
                        } else {
                            array_push($freeSchedule, $scheduleToEdit);
                        }
                    }
                    $busyTeacherString = "";
                    $busySpaceString = "";
                    if(!empty($busyTeacher)) {
                        foreach ($busyTeacher as $scheduleTeacher) {
                            if($busyTeacherString === "") {
                                $busyTeacherString .= "El profesor %" . $scheduleTeacher->getProfesor()->getUsuario()->getNombre() .
                                    " " . $scheduleTeacher->getProfesor()->getUsuario()->getApellido() . "% está ocupado los días %" .
                                    $scheduleTeacher->getDia();
                            } else {
                                $busyTeacherString .= ", " . $scheduleTeacher->getDia();
                            }
                        }
                        if($busyTeacherString !== "") {
                            $busyTeacherString .= "%";
                        }
                    }
                    if(!empty($busySpace)) {
                        foreach ($busySpace as $scheduleSpace) {
                            if($busySpaceString === "") {
                                $busySpaceString .= "El aula %" . $scheduleSpace->getEspacio()->getNombre() ."% está ocupada los días %" .
                                    $scheduleSpace->getDia();
                            } else {
                                $busySpaceString .= ", " . $scheduleSpace->getDia();
                            }
                        }
                        if($busySpaceString !== "") {
                            $busySpaceString .= "%";
                        }
                    }
                    if($busySpaceString !== "" || $busyTeacherString !== "") {
                        showConfirmationModal($busyTeacherString, $busySpaceString, $freeSchedule, $subjectId, "editConfirmed", $subjectGroupData, $spaceData, $teacherData);
                    } else {
                        editSchedule($freeSchedule);
                        goToShowAllAndShowSuccess("Horario editado correctamente.", $subjectGroupData, $spaceData, $teacherData);
                    }
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage(), $subjectGroupData, $spaceData, $teacherData);
                } catch (ValidationException $ve) {
                    goToShowAllAndShowError($ve->getMessage(), $subjectGroupData, $spaceData, $teacherData);
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para editar.", $subjectGroupData, $spaceData, $teacherData);
        }
        break;
    case "search":
        if (checkPermission("horario", "SHOWALL")) {
            try {

                $schedule = $scheduleDAO->search($_POST["subject_group_id"], $_POST["space_id"], $_POST["teacher_id"], $_POST["day"], $_POST["start_hour"], $_POST["end_hour"]);
                $schedules = array();
                foreach($schedule as $sch) {
                    array_push($schedules, $scheduleDAO->show($schedulePK, $sch["id"]));
                }

                showAllSearch($schedules, $subjectGroupData, $spaceData, $teacherData);
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $subjectGroupData, $spaceData, $teacherData);
            } catch (ValidationException $ve) {
                goToShowAllAndShowError($ve->getMessage(), $subjectGroupData, $spaceData, $teacherData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para buscar.", $subjectGroupData, $spaceData, $teacherData);
        }
        break;
    default:
        showAll(NULL, $subjectGroupData, $spaceData, $teacherData);
        break;
}

function showAll($search, $subjectGroupData, $spaceData, $teacherData) {
    showAllSearch($search, $subjectGroupData, $spaceData, $teacherData);
}

function showAllSearch($search, $subjectGroupData, $spaceData, $teacherData) {
    if (checkPermission("horario", "SHOWALL")) {
        try {
            $currentPage = getPage();
            $itemsPerPage = getNumberItems();

            $subject = $GLOBALS["subject"];
            $totalSchedules = $GLOBALS["scheduleDAO"]->countTotalSchedules();

            if ($search != NULL) {
                $scheduleData = $search;
                $totalSchedules = count($scheduleData);
            } else {
                $scheduleData = $GLOBALS["scheduleDAO"]->showAllPaged($currentPage, $itemsPerPage, $subject->getId());
                $totalSchedules = count($scheduleData);
            }
            new ScheduleShowAllView($scheduleData, $itemsPerPage, $currentPage, $totalSchedules, $search, $subject, $subjectGroupData, $spaceData, $teacherData);
        } catch (DAOException $e) {
            new ScheduleShowAllView(array());
            errorMessage($e->getMessage());
        }
    } else {
        accessDenied();
    }
}

function goToShowAllAndShowError($message, $subjectGroupData, $spaceData, $teacherData) {
    showAll(NULL, $subjectGroupData, $spaceData, $teacherData);
    include '../models/common/messageType.php';
    include '../utils/ShowToast.php';
    $messageType = MessageType::ERROR;
    showToast($messageType, $message);
}

function goToShowAllAndShowSuccess($message, $subjectGroupData, $spaceData, $teacherData) {
    showAll(NULL, $subjectGroupData, $spaceData, $teacherData);
    include '../models/common/messageType.php';
    include '../utils/ShowToast.php';
    $messageType = MessageType::SUCCESS;
    showToast($messageType, $message);
}

function editSchedule($freeSchedule) {
    foreach ($freeSchedule as $schedule) {
        $GLOBALS["scheduleDAO"]->edit($schedule);
    }
}

function addSchedule($freeSchedule) {
    foreach ($freeSchedule as $schedule) {
        $GLOBALS["scheduleDAO"]->add($schedule);
    }
}

function getWeekday($date) {
    return date('l', $date);
}

function showConfirmationModal($busyTeacherString, $busySpaceString, $freeSchedule, $subjectId, $action, $subjectGroupData, $spaceData, $teacherData) {
    showAll(NULL, $subjectGroupData, $spaceData, $teacherData);
    echo '<div id="confirmation-modal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" data-translate="Error al insertar horario"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p data-translate="' . $busySpaceString . '"></p>
        <p data-translate="' . $busyTeacherString . '"></p>
      </div>
      <div class="modal-footer">
      <form action="../controllers/scheduleController.php?subject=' . $subjectId . '&action=' . $action .'" method="POST" style="margin-bottom: 0">
        <input id="array-schedules" type="hidden" name="schedules_to_insert" value=\'' . base64_encode(serialize($freeSchedule)). '\' />
        <button id="confirm-btn" type="submit" class="btn btn-primary"><p style="margin-bottom: 0" data-translate="Ignorar días ocupados e insertar los demás"></p></button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><p style="margin-bottom: 0" data-translate="Cancelar todo"></p></button>
      </form>
      </div>
    </div>
  </div>
</div>';
    echo "<script> $('#confirmation-modal').modal('show');</script>";
}


?>
