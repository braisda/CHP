<?php
include_once  "../models/center/centerDAO.php";
include_once 'userInSession.php';

function IsCenterOwner()
{
    $centerDAO = new CenterDAO();

    try{

        $centers = $centerDAO->showAll();

        foreach ($centers as $center){
            if($center->getUsuario()->getId() == getUserInSession()){
                return $center;
            }
        }
        return false;
    }
    catch (DAOException $e){
        return false;
    }
}

?>