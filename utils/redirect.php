<?php
include_once '../models/common/messageType.php';

function redirect($url)
{
    $string = '<script type="text/javascript">';
    $string .= 'window.location = "' . $url . '"';
    $string .= '</script>';
    echo $string;
}

function accessDenied()
{
    redirect("../controllers/defaultController.php?accessDenied=true");
}

if (isset($_REQUEST["accessDenied"])) {
    $message = MessageType::ERROR;
    showToast($message, "No cuenta con permisos de acceso.");
}