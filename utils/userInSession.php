<?php
include_once 'jwt.php';

function getUserInSession() {

    $serverKey = '5f2b5cdbe5194f10b3241568fe4e2b24';
    $elem = JWT::decode($_SESSION['token'], $serverKey, array('HS256'));

    return $elem->login;
}

?>