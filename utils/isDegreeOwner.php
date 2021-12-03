<?php
include_once  "../models/degree/grado.php";
include_once 'userInSession.php';

function IsDegreeOwner() {

    $degreeDAO = new DegreeDAO();

    try{

        $degrees = $degreeDAO->showAll();

        foreach ($degrees as $degree){
            if($degree->getUsuario()->getId() == getUserInSession()){
                return $degree;
            }
        }
        return false;
    }
    catch (DAOException $e){
        return false;
    }
}

?>