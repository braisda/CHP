<?php
include_once '../models/common/messageType.php';
include_once '../utils/ShowToast.php';

function errorMessage($message) {
    $messageType = MessageType::ERROR;
    showToast($messageType, $message);
}

function successMessage($message) {
    $messageType = MessageType::SUCCESS;
    showToast($messageType, $message);
}