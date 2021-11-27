<?php
session_start();
include_once '../utils/auth.php';
include_once '../utils/CheckPermission.php';

if (!IsAuthenticated()){
    header('Location:../index.php');
}

include_once '../models/user/userDAO.php';
include_once '../utils/messages.php';
include_once '../utils/openDeletionModal.php';
include_once '../utils/pagination.php';
include_once '../utils/redirect.php';
include_once '../views/common/head.php';
include_once '../views/common/headerMenu.php';
include_once '../views/user/userShowAllView.php';

$userDAO = new UserDAO();

$userPK = "login";
$value = $_REQUEST[$userPK];

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {

    default:
        showAll();
        break;
}

function showAll() {
    showAllSearch(NULL);
}

function showAllSearch($search) {
    if (checkPermission("usuario", "SHOWALL")) {
        try {

            $page = getPage();
            $itemsInPage = getNumberItems();
            $toSearch = getToSearch($search);
            $totalPermissions = $GLOBALS["userDAO"]->countTotalUsers($toSearch);
            $data = $GLOBALS["userDAO"]->showAllPaged($page, $itemsInPage, $toSearch);
            new UserShowAllView($data, $itemsInPage, $page, $totalPermissions, $toSearch);
        } catch (DAOException $e) {
            new UserShowAllView(array());
            errorMessage($e->getMessage());
        }
    } else {
        accessDenied();
    }
}


function goToShowAllAndShowError($message) {
    showAll();
    errorMessage($message);
}

function goToShowAllAndShowSuccess($message) {
    showAll();
    successMessage($message);
}
?>