<?php
session_start();
include_once '../utils/auth.php';
include_once '../utils/CheckPermission.php';

if (!IsAuthenticated()){
    header('Location:../index.php');
}

include_once '../utils/pagination.php';
include_once '../models/common/DAOException.php';
include_once '../views/common/head.php';
include_once '../views/common/headerMenu.php';
include_once '../views/common/paginationView.php';
include_once '../utils/confirmDelete.php';
include_once '../utils/openDeletionModal.php';
include_once '../models/subject/subjectDAO.php';
include_once '../models/subjectTeacher/subjectTeacherDAO.php';
include_once '../models/subjectTeacher/materia_profesor.php';
include_once '../models/teacher/TeacherDAO.php';
include_once '../models/user/usuario.php';
include_once '../models/user/userDAO.php';
include_once '../views/pod/podShowAllView.php';

$subjectPrimaryKey = "id";
$value = $_REQUEST[$subjectPK];
$error = 0;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
    case "add":
        if (checkPermission("pod", "ADD")) {
            if (!isset($_POST["submit"])) {
                new PodShowAllView();
            } else {
                try {

                    $saveDir = '/var/www/html/temp/';

                    if (!file_exists($saveDir)) {
                        mkdir($saveDir, 0777, true);
                    }

                    $uploadFile = $saveDir . basename($_FILES['file']['name']);

                    move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile);

                    $cmd = "pdftohtml -enc UTF-8 $uploadFile $saveDir" . "pod-out";
                    exec($cmd);

                    $htmlContent = file_get_contents($saveDir . "pod-outs.html");
                    $DOM = new DOMDocument('1.0', 'UTF-8');
                    $DOM->loadHTML(mb_convert_encoding($htmlContent, 'HTML-ENTITIES', 'UTF-8'));

                    $Body = $DOM->getElementsByTagName('body');

                    $departments = preg_split('/(?=(\(D[0-9a-z]+\)))/', $Body[0]->textContent);
                    foreach ($departments as $dept) {
                        processDepartment($dept);
                    }

                    rrmdir($saveDir);


                    goToShowAllAndShowSuccess("POD añadido correctamente. Se han producido ".$error." errores");
                } catch (DAOException $e) {
                    goToShowAllAndShowError($e->getMessage());
                } catch (ValidationException $ve) {
                    goToShowAllAndShowError($ve->getMessage());
                }
            }
        } else {
            goToShowAllAndShowError("No tienes permiso para añadir.");
        }
        break;
    default:
        showAll();
        break;
}

function showAll() {
    showAllSearch(NULL);
}

function showAllSearch($search) {
    if (checkPermission("pod", "SHOWALL")) {
        new PodShowAllView();
    } else {
        accessDenied();
    }
}

function processDepartment($department) {
    $area = preg_split('/(?=(\(A[0-9]+\)))/', $department);
    foreach ($area as $ar) {
        if ($ar != $area[0]) {
            processArea($ar);
        }

    }
}

function processArea($area) {
    $teacher = preg_split('/(?=(([0-9]{8}[A-Z])|(2019_20.+)|(([YX])[0-9]{7}[A-Z])|(A[0-9]{4}-A.+)))/', $area);
    foreach ($teacher as $teach) {
        if ($teach != $teacher[0]) {
            processTeacher($teach);
        }

    }
}

function processTeacher($teacher) {
    try{
        $teacher_data = preg_split('/[\r\n]/', $teacher);

        if (substr($teacher_data[0],0,8) != "2019_20_" && strlen($teacher_data[1])>2) {

            $userDAO = new UserDAO();
            $user = $userDAO->show("dni", $teacher_data[0]);

            $teacherDAO = new TeacherDAO();
            $tea = $teacherDAO->show("idusuario", $user->getLogin());

            $subjectDAO = new SubjectDAO();

            $subjectTeacherDAO = new SubjectTeacherDAO();

            for ($i = 3; $i<count($teacher_data)-1;$i++){
                $sub = new Materia_profesor();
                $sub->setProfesor($tea);
                $i++;
                if (preg_match('/G[0-9]{6}/',$teacher_data[$i])){
                    $sub->setMateria($subjectDAO->show("codigo", substr($teacher_data[$i], 0, 7)));
                }else{break;}
                $i+=2;
                if (preg_match('/[0-9]{1,3}\.[0-9]{2}/',$teacher_data[$i])){
                    $sub->setHoras(intval($teacher_data[$i]));
                }else{break;}
                $i++;
                $subjectTeacherDAO->add($sub);
            }


        }

    } catch (DAOException $e){
        global $error;
        $error+=1;
    }

}

function goToShowAllAndShowError($message) {
    showAll();
    include '../models/common/messageType.php';
    include '../utils/ShowToast.php';
    $messageType = MessageType::ERROR;
    showToast($messageType, $message);
}

function goToShowAllAndShowSuccess($message) {
    showAll();
    include '../models/common/messageType.php';
    include '../utils/ShowToast.php';
    $messageType = MessageType::SUCCESS;
    showToast($messageType, $message);
}

function rrmdir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir . "/" . $object) && !is_link($dir . "/" . $object))
                    rrmdir($dir . "/" . $object);
                else
                    unlink($dir . "/" . $object);
            }
        }
        rmdir($dir);
    }
}

?>