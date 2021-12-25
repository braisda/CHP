<?php
include_once '../models/common/defaultDAO.php';
include_once '../models/group/groupDAO.php';
include_once '../models/schedule/scheduleDAO.php';
include_once 'asistencia.php';

class AttendanceDAO {

    private $defaultDAO;
    private $groupDAO;
    private $scheduleDAO;

    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
        $this->groupDAO = new GroupDAO();
        $this->scheduleDAO = new ScheduleDAO();
    }

    function showAll() {
        $attendance_db = $this->defaultDAO->showAll("asistencia");
        return $this->getAttendanceFromDB($attendance_db);
    }

    function add($attendance) {
        $this->defaultDAO->insert($attendance, "id");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("asistencia", $key, $value);
    }

    function deleteByScheduleId($schedule_id) {
        $this->delete("idhorario", $schedule_id);
    }

    function show($key, $value) {
        $attendance = $this->defaultDAO->show("asistencia", $key, $value);
        $subject = $this->groupDAO->show("id", $attendance["idmateria"]);
        $schedule = $this->scheduleDAO->show("id", $attendance["idhorario"]);
        return new Asistencia($attendance["id"], $subject, $attendance["numalumnos"], $attendance["asiste"], $schedule);
    }

    function edit($attendance) {
        $this->defaultDAO->edit($attendance, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("asistencia");
    }

    function showAllPaged($currentPage, $itemsPerPage, $subjectId, $scheduleId) {
        $attendance_db = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Asistencia());
        $att = array();
        foreach($attendance_db as $attendance) {
            if (($attendance["idhorario"] == $scheduleId)) {
                array_push($att, $attendance);
            }
        }

        return $this->getAttendanceFromDB($att);
    }

    function countTotalAttendance() {
        return $this->defaultDAO->countTotalEntries(new Asistencia());
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("asistencia", $value);
    }

    private function getAttendanceFromDB($attendance_db) {
        $attendances = array();
        foreach($attendance_db as $attendance) {
            $subject = $this->groupDAO->show("id", $attendance["idmateria"]);
            $schedule = $this->scheduleDAO->show("id", $attendance["idhorario"]);
            array_push($attendances, new Asistencia($attendance["id"], $subject, $attendance["numalumnos"], $attendance["asiste"], $schedule));
        }

        return $attendances;
    }
}
?>