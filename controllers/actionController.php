<?php

include_once '../models/action/actionDAO.php';
include_once '../views/Common/head.php';
include_once '../views/Common/headerMenu.php';
include_once '../views/action/actionShowAllView.php';

//DAO
$actionDAO = new ActionDAO();

switch ($action) {
    case "add":
        
    case "delete":
        
        break;
    case "show":
        break;
    case "edit":
        
        break;
    case "search":
         
        break;
    default:
        showAll();
        break;
}

function showAll() {
    showAllSearch(NULL);
}

function showAllSearch($search) {
        try {
            $currentPage = 1;//getCurrentPage();
            $itemsPerPage = 4;//getItemsPerPage();
            $toSearch = null;//getToSearch($search);
            $totalActions = $GLOBALS["actionDAO"]->countTotalActions($toSearch);
            $actionData = $GLOBALS["actionDAO"]->showAllPaged($currentPage, $itemsPerPage, $toSearch);
            printf($actionData);
            new ActionShowAllView($actionData, $itemsPerPage, $currentPage, $totalActions, $toSearch);
        } catch (DAOException $e) {
            new ActionShowAllView(array());
            //errorMessage($e->getMessage());
        }
}

function goToShowAllAndShowError($message) {
    showAll();
    //errorMessage($message);
}

function goToShowAllAndShowSuccess($message) {
    showAll();
    //successMessage($message);
}


?>