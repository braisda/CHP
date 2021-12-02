<?php
include_once  "../Models/University/UniversityDAO.php";
include_once "../Models/University/University.php";
function IsUniversityOwner()
{
    $toret = array();
    $universityDAO = new UniversityDAO();

    $serverKey = '5f2b5cdbe5194f10b3241568fe4e2b24';
    $elem = JWT::decode($_SESSION['token'], $serverKey, array('HS256'));

    try{
        $universities = $universityDAO->showAll();
        foreach ($universities as $university){
            if($university->getidUsuario()->getId() == $elem->login){
                array_push($toret, $university);
            }
        }
        if (empty($toret)) {
            return false;
        } else {
            return $toret;
        }
    }
    catch (DAOException $e){
        return false;
    }
}