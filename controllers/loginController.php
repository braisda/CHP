<?php
include '../views/common/head.php';
include '../views/login.php';
include '../utils/loginUtils.php';

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'login-user') {
    $login = $_REQUEST['login'];
    $password = $_REQUEST['password'];
    loginUser($login, $password);
}