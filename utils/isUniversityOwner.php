<?php
include_once  "../models/university/universityDAO.php";
include_once "../models/university/universidad.php";

function IsUniversityOwner()
{
    $return = array();
    $universityDAO = new UniversityDAO();

    $serverKey = '5f2b5cdbe5194f10b3241568fe4e2b24';
    $elem = JWT::decode($_SESSION['token'], $serverKey, array('HS256'));

    try{
        $universities = $universityDAO->showAll();
        foreach ($universities as $university){
            if($university->getIdUsuario()->getId() == $elem->login){
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