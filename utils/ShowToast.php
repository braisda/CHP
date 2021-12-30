<?php
function showToast($messageType, $message) {
    include_once '../views/common/MessageToast.php';
    if(isset($messageType) && isset($message)) {
        echo '<script src="../js/ToastTrigger.js"></script>';
        echo '<script>';
        echo 'showToast("' . $messageType[0] . '", "' . $messageType[1] . '", "' . $message . '");';
        echo '</script>';
    }
}

function showTestToast($messageType, $message) {
    include_once '../views/common/MessageToast.php';
    if(isset($messageType) && isset($message)) {
        echo '<script src="../js/ToastTrigger.js"></script>';
        echo '<script>';
        echo 'showTestToast("' . $messageType[0] . '", "' . $messageType[1] . '", "' . $message . '");';
        echo '</script>';
    }
}