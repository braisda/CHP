<?php
include_once  "../models/university/universityDAO.php";
include_once "../models/university/universidad.php";
include_once 'userInSession.php';

function IsUniversityOwner()
{
    $return = array();
    $universityDAO = new UniversityDAO();

    try{
        $universities = $universityDAO->showAll();
        foreach ($universities as $university){
            if($university->getIdUsuario()->getId() == getUserInSession()){
                array_push($return, $university);
            }
        }
        if (empty($return)) {
            return false;
        } else {
            return $return;
        }
    } catch (DAOException $e){
        return false;
    }
}