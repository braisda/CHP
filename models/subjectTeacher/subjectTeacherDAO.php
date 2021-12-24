<?php
include_once '../models/common/defaultDAO.php';
include_once '../models/subject/subjectDAO.php';
include_once '../models/teacher/teacherDAO.php';
include_once 'materia_profesor.php';

class SubjectTeacherDAO {

    private $defaultDAO;
    private $subjectDAO;
    private $teacherDAO;

    public function __construct() {
        $this->defaultDAO = new DefaultDAO();
        $this->subjectDAO = new SubjectDAO();
        $this->teacherDAO = new TeacherDAO();
    }

    function showAll() {
        $subjectTeachers_db = $this->defaultDAO->showAll("materia_profesor");
        return $this->getSubjectTeachersFromDB($subjectTeachers_db);
    }

    function add($subjectTeacher) {
        $st = NULL;
        try {
            $st = $this->show("idmateria", $subjectTeacher->getMateria()->getId());
        } catch (DAOException $e) {
            // Do nothing
        }
        if ($st == NULL) {
            $this->defaultDAO->insert($subjectTeacher, "id");
            $subject = $this->subjectDAO->show("id", $subjectTeacher->getMateria()->getId());
            $subject->setProfesor($subjectTeacher->getProfesor());
            $this->subjectDAO->edit($subject);
        } else {
            throw new DAOException('No se pueden asignar dos profesores a la misma materia.');
        }
    }

    function delete($key, $value, $subjectId) {
        $this->defaultDAO->delete("materia_profesor", $key, $value);
        $subject = $this->subjectDAO->show("id", $subjectId);
        $subject->setProfesor(NULL);
        $this->subjectDAO->edit($subject);
    }

    function show($key, $value) {
        $subjectTeacher = $this->defaultDAO->show("materia_profesor", $key, $value);
        $subject = $this->subjectDAO->show("id", $subjectTeacher["idmateria"]);
        $teacher = $this->teacherDAO->show("id", $subjectTeacher["idprofesor"]);
        return new Materia_profesor($subjectTeacher["id"], $teacher, $subject, $subjectTeacher["horas"]);
    }

    function edit($subjectTeacher) {
        $this->defaultDAO->edit($subjectTeacher, "id");
        $subject = $this->subjectDAO->show("id", $subjectTeacher->getMateria()->getId());
        $subject->setProfesor($subjectTeacher->getProfesor());
        $this->subjectDAO->edit($subject);
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("materia_profesor");
    }

    function showAllPaged($currentPage, $itemsPerPage) {
        $subjectTeacher_db = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Materia_profesor());
        return $this->getSubjectTeachersFromDB($subjectTeacher_db);
    }

    function countTotalSubjectTeachers() {
        return $this->defaultDAO->countTotalEntries(new Materia_profesor());
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("materia_profesor", $value);
    }

    private function getSubjectTeachersFromDB($subjectTeacher_db) {
        $subjectTeachers = array();
        foreach ($subjectTeacher_db as $subjectTeacher) {
            $subject = $this->subjectDAO->show("id", $subjectTeacher["idmateria"]);
            $teacher = $this->teacherDAO->show("id", $subjectTeacher["idprofesor"]);
            array_push($subjectTeachers, new Materia_profesor($subjectTeacher["id"], $teacher, $subject, $subjectTeacher["horas"]));
        }
        return $subjectTeachers;
    }
}