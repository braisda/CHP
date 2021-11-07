<?php

session_start();
include_once '../utils/auth.php';
include_once '../utils/ShowToast.php';
if (!IsAuthenticated()){
 	header('Location:../index.php');
} else {
	include '../views/common/head.php';
	include '../views/common/default.php';
	include '../utils/redirect.php';
}