<?php
include_once '../models/user/userDAO.php';
include_once '../models/common/DAOException.php';
include_once 'jwt.php';

function loginUser($login, $password) {

    $userDAO = new userDAO();
    try {
        $userDAO->canBeLogged($login, $password);

        // Crear token jwt y meterlo en la variable de sesión
        createTokenJWT($login);

        header('Location:../index.php');
    } catch (DAOException $e) {
        include '../models/common/messageType.php';
        include '../utils/ShowToast.php';
        $message = MessageType::ERROR;
        showToast($message, $e->getMessage());
    }
}

function createTokenJWT($login) {

    session_start();

    // Clave secreta del lado del servidor
    $serverKey = '5f2b5cdbe5194f10b3241568fe4e2b24';

    $payloadArray = array();
    $payloadArray['login'] = $login;
    if (isset($nbf)) {$payloadArray['nbf'] = $nbf;}
    if (isset($exp)) {$payloadArray['exp'] = $exp;}
    $_SESSION['token'] = JWT::encode($payloadArray, $serverKey);
}
