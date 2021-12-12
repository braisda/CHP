<?php
include_once "../models/subjectTeacher/subjectTeacherDAO.php";
include_once "../models/subjectTeacher/materia_profesor.php";
include_once 'userInSession.php';

function IsSubjectTeacher() {
    $return = array();
    $subjectDAO = new SubjectTeacherDAO();

    try {

        $subjects = $subjectDAO->showAll();
        foreach ($subjects as $subject) {
            if ($subject->getTeacher()->getUser()->getId() == getUserInSession()) {
                array_push($return, $subject->getSubject());
            }
        }
        if (empty($return)) {
            return false;
        } else {
            return $return;
        }
    } catch (DAOException $e) {
        return false;
    }
}