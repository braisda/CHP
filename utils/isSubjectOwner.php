<?php
include_once "../models/subject/subjectDAO.php";
include_once "../models/subject/subject.php";
include_once 'userInSession.php';

function IsSubjectOwner() {
    $return = array();
    $subjectDAO = new SubjectDAO();

    try {

        $subjects = $subjectDAO->showAll();
        foreach ($subjects as $subject) {

            if (!empty($subject->getTeacher()->getUser()) && $subject->getTeacher()->getUser()->getId() == getUserInSession()) {
                array_push($return, $subject);
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