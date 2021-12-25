<?php
include_once '../models/common/defaultDAO.php';
include_once '../models/space/spaceDAO.php';
include_once '../models/teacher/teacherDAO.php';
include_once '../models/group/groupDAO.php';
include_once '../models/attendance/asistencia.php';
include_once 'horario.php';

class ScheduleDAO {

    private $defaultDAO;
    private $spaceDAO;
    private $teacherDAO;
    private $subjectGroupDAO;

    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
        $this->spaceDAO = new SpaceDAO();
        $this->teacherDAO = new TeacherDAO();
        $this->subjectGroupDAO = new GroupDAO();
    }

    function showAll() {
        $schedule_db = $this->defaultDAO->showAll("horario");
        return $this->getScheduleFromDB($schedule_db);
    }

    function add($schedule) {
        $this->defaultDAO->insert($schedule, "id");
        $sche = $this->defaultDAO->mysqli->query("SELECT * FROM horario WHERE id = (SELECT max(id) FROM horario)");
        $row = $sche->fetch_array(MYSQLI_ASSOC);
        $schedule->setId($row["id"]);
        $attendance = new Asistencia();
        $attendance->setHorario($schedule);
        $attendance->setMateria($schedule->getGrupoMateria());
        $attendance->setNumAlumnos('<numalumnos>');
        $attendance->setAsiste('<asiste>');
        $this->defaultDAO->insert($attendance, "id");
    }

    function delete($key, $value) {
        try {
            $this->defaultDAO->delete("asistencia", "idhorario", $value);
        } catch(DAOException $e) {
            // Do nothing
        }
        $this->defaultDAO->delete("horario", $key, $value);
    }

    function show($key, $value) {
        $schedule = $this->defaultDAO->show("horario", $key, $value);
        $space = $this->spaceDAO->show("id", $schedule["idespacio"]);
        $teacher = $this->teacherDAO->show("id", $schedule["idprofesor"]);
        $subjectGroup = $this->subjectGroupDAO->show("id", $schedule["idgrupomateria"]);
        return new Horario($schedule["id"], $space, $teacher, $subjectGroup, $schedule["horainicio"],
            $schedule["horafin"], $schedule["dia"]);
    }

    function edit($schedule) {
        $this->defaultDAO->edit($schedule, "id");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("horario");
    }

    function showAllPaged($currentPage, $itemsPerPage) {
        $schedule_db = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Horario());
        return $this->getScheduleFromDB($schedule_db);
    }

    function countTotalSchedules() {
        return $this->defaultDAO->countTotalEntries(new Horario());
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("horario", $value);
    }

    function checkIfTeacherIsUsed($teacherId, $day, $startHour, $endHour) {
        $sql = "SELECT * FROM horario WHERE idprofesor = " . $teacherId . " AND dia = '" . $day . "' AND (('" . $startHour . "'> TIME_FORMAT(horainicio, '%H:%i') AND '".
            $startHour . "' < TIME_FORMAT(horafin, '%H:%i') ) OR ('" . $endHour . "' > TIME_FORMAT(horainicio, '%H:%i') AND '". $endHour . "' < TIME_FORMAT(horafin, '%H:%i') ))";

        return !empty($this->defaultDAO->getArrayFromSqlQuery($sql));
    }
    function checkIfTeacherIsUsedLessId($teacherId, $day, $startHour, $endHour, $id) {
        $sql = "SELECT * FROM horario WHERE idprofesor = " . $teacherId . " AND dia = '" . $day . "' AND id <>". $id ." AND (('" . $startHour . "'> TIME_FORMAT(horainicio, '%H:%i') AND '".
            $startHour . "' < TIME_FORMAT(horafin, '%H:%i') ) OR ('" . $endHour . "' > TIME_FORMAT(horainicio, '%H:%i') AND '". $endHour . "' < TIME_FORMAT(horafin, '%H:%i') ))";

        return !empty($this->defaultDAO->getArrayFromSqlQuery($sql));
    }

    function checkIfSpaceIsUsed($spaceId, $day, $startHour, $endHour) {
        $sql = "SELECT * FROM horario WHERE idespacio = " . $spaceId . " AND dia = '" . $day . "' AND (('" . $startHour . "'> TIME_FORMAT(horainicio, '%H:%i') AND '".
            $startHour . "' < TIME_FORMAT(horafin, '%H:%i') ) OR ('" . $endHour . "' > TIME_FORMAT(horainicio, '%H:%i') AND '". $endHour . "' < TIME_FORMAT(horafin, '%H:%i') ))";

        return !empty($this->defaultDAO->getArrayFromSqlQuery($sql));
    }

    function checkIfSpaceIsUsedLessId($spaceId, $day, $startHour, $endHour, $id) {
        $sql = "SELECT * FROM horario WHERE idespacio = " . $spaceId . " AND dia = '" . $day . "' AND id <>". $id ." AND (('" . $startHour . "'> TIME_FORMAT(horainicio, '%H:%i') AND '".
            $startHour . "' < TIME_FORMAT(horafin, '%H:%i') ) OR ('" . $endHour . "' > TIME_FORMAT(horainicio, '%H:%i') AND '". $endHour . "' < TIME_FORMAT(horafin, '%H:%i') ))";

        return !empty($this->defaultDAO->getArrayFromSqlQuery($sql));
    }

    function getAllSchedulesByRange($startDay, $endDay, $groupId) {
        $sql = "SELECT * FROM horario WHERE idgrupomateria = " . $groupId . " AND dia between '" . $startDay . "' AND '" . $endDay . "'";
        $data = $this->defaultDAO->getArrayFromSqlQuery($sql);
        return $this->getScheduleFromDB($data);
    }

    function search($group, $class, $teacher, $day, $startHour, $endHour) {
            $sql = "SELECT DISTINCT * FROM horario WHERE ";
            $count = 0;
            if (!empty($group)) {
                $sql .= "idgrupomateria = '" . $group . "'";
                $count += 1;
            }
            if (!empty($class)) {
                if ($count != 0) {
                    $sql .= " AND idespacio = '" . $class . "'";
                } else {
                    $sql .= "idespacio = '" . $class . "'";
                }
                $count += 1;
            }
            if (!empty($teacher)) {
                if ($count != 0) {
                    $sql .= " AND idprofesor = '" . $teacher . "'";
                } else {
                    $sql .= "idprofesor = '" . $teacher . "'";
                }
                $count += 1;
            }
            if (!empty($day)) {
                if ($count != 0) {
                    $sql .= " AND dia = '" . $day . "'";
                } else {
                    $sql .= "dia = '" . $day . "'";
                }
                $count += 1;
            }
            if (!empty($startHour)) {
                if ($count != 0) {
                    $sql .= " AND horainicio = '" . $startHour . "'";
                } else {
                    $sql .= "horainicio = '" . $startHour . "'";
                }
                $count += 1;
            }
            if (!empty($endHour)) {
                if ($count != 0) {
                    $sql .= " AND horafin = '" . $endHour . "'";
                } else {
                    $sql .= "horafin = '" . $endHour . "'";
                }
                $count += 1;
            }
            if ($count != 0) {
                return $this->defaultDAO->getArrayFromSqlQuery($sql);
            }
            return $this->showAll();
        }

    private function getScheduleFromDB($schedule_db)
    {
        $schedules = array();
        foreach ($schedule_db as $schedule) {
            $space = $this->spaceDAO->show("id", $schedule["idespacio"]);
            $teacher = $this->teacherDAO->show("id", $schedule["idprofesor"]);
            $subjectGroup = $this->subjectGroupDAO->show("id", $schedule["idgrupomateria"]);
            array_push($schedules, new Horario($schedule["id"], $space, $teacher, $subjectGroup, $schedule["horainicio"],
                $schedule["horafin"], $schedule["dia"]));
        }
        return $schedules;
    }
}