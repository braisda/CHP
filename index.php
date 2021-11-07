<?php
session_start();

include './utils/auth.php';

if (!IsAuthenticated()) {
    header('Location:./controllers/loginController.php');
} else {
    header('Location:./controllers/defaultController.php');
}
