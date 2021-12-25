<?php
session_start();
include_once '../utils/auth.php';
include_once '../utils/CheckPermission.php';

if (!IsAuthenticated()){
    header('Location:../index.php');
}

include_once '../utils/pagination.php';
include_once '../models/common/DAOException.php';
include_once '../models/attendance/attendanceDAO.php';
include_once '../models/group/groupDAO.php';
include_once '../models/schedule/scheduleDAO.php';
include_once '../views/common/head.php';
include_once '../views/common/headerMenu.php';
include_once '../views/common/paginationView.php';
include_once '../utils/confirmDelete.php';
include_once '../views/attendance/attendanceShowAllView.php';
include_once '../views/attendance/attendanceEditView.php';

$groupDAO = new groupDAO();
$attendanceDAO = new AttendanceDAO();
$scheduleDAO = new ScheduleDAO();

$scheduleId = $_REQUEST['schedule'];
$subjectId = $_REQUEST['subject'];
$subjectData = $groupDAO->show("idmateria", $subjectId);
$scheduleData = $scheduleDAO->show("id", $scheduleId);
$attendancePK = "id";
$value = $_REQUEST[$attendancePK];

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "edit":
        if (checkPermission("horario", "EDIT")) {
            try {
                $attendance = $attendanceDAO->show($attendancePK, $value);
                if (!isset($_POST["submit"])) {
                    new AttendanceEditView($attendance, $subjectData);
                } else {
                    $attendance->setNumAlumnos($_POST["numStudents"]);
                    $attendance->setAsiste(1);
                    $attendanceDAO->edit($attendance);
                    goToShowAllAndShowSuccess("Asistencia editada correctamente.", $subjectData, $scheduleData);
                }
            } catch (DAOException $e) {
                goToShowAllAndShowError($e->getMessage(), $subjectData, $scheduleData);
            } catch (Exception $ve) {
                goToShowAllAndShowError($ve->getMessage(), $subjectData, $scheduleData);
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para editar.", $subjectData, $scheduleData);
        }
        break;
    default:
        showAll($subjectData, $scheduleData);
        break;
}

function showAll($subjectData, $scheduleData) {
    showAllSearch(NULL, $subjectData, $scheduleData);
}

function showAllSearch($search, $subjectData, $scheduleData) {
    if (checkPermission("horario", "SHOWALL")) {
        try {
            $currentPage = getPage();
            $itemsPerPage = getNumberItems();
            $totalAttendance = $GLOBALS["attendanceDAO"]->countTotalAttendance();

            if ($search != NULL) {
                $attendanceData = $search;
                $totalAttendance = count($attendanceData);
            } else {
                $attendanceData = $GLOBALS["attendanceDAO"]->showAllPaged($currentPage, $itemsPerPage, $GLOBALS["subjectId"], $GLOBALS["scheduleId"]);
            }
            new AttendanceShowAllView($attendanceData, $subjectData, $itemsPerPage, $currentPage, $totalAttendance, $search, $scheduleData);
        } catch (DAOException $e) {
            include '../models/common/messageType.php';
            include '../utils/ShowToast.php';
            new AttendanceShowAllView(array(), $subjectData, $scheduleData);
            $message = MessageType::ERROR;
            showToast($message, $e->getMessage());
        }
    } else {
        accessDenied();
    }
}

function goToShowAllAndShowError($message, $subjectData, $scheduleData)
{
    showAll($subjectData, $scheduleData);
    include '../models/common/messageType.php';
    include '../utils/ShowToast.php';
    $messageType = MessageType::ERROR;
    showToast($messageType, $message);
}

function goToShowAllAndShowSuccess($message, $subjectData, $scheduleData)
{
    showAll($subjectData, $scheduleData);
    include '../models/common/messageType.php';
    include '../utils/ShowToast.php';
    $messageType = MessageType::SUCCESS;
    showToast($messageType, $message);
}
?>