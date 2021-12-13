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
include_once '../models/department/departmentDAO.php';
include_once '../models/degree/degreeDAO.php';
include_once '../models/common/DAOException.php';
include_once '../views/pda/pdaShowAllView.php';
include_once '../models/subject/materia.php';
include_once '../models/subject/subjectDAO.php';

$subjectPK = "id";
$value = $_REQUEST[$subjectPK];
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
switch ($action) {
case "add":
        if (checkPermission("pda", "ADD")) {
            if (!isset($_POST["submit"])) {
                new PdaShowAllView();
            } else {
                try {

                    $saveDir = '/var/www/html/temp/';

                    if (!file_exists($saveDir)) {
                        mkdir($saveDir, 0777, true);
                    }

                    $uploadFile = $saveDir . basename($_FILES['file']['name']);
                    move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile);
                    loadPDA($saveDir);
                    rrmdir($saveDir);

                    goToShowAllAndShowSuccess("PDA añadido correctamente.");
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
    if (checkPermission("pda", "SHOWALL")) {
        new PdaShowAllView();

    } else {
        accessDenied();
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

function loadPDA($dir) {

    $objects = scandir($dir);
    $sourcePdf = $dir;

    foreach ($objects as $object) {
        if ($object != "." && $object != "..") {
            $sourcePdf = $dir . $object;
        }
    }
    $sourcePdf = preg_replace('/\s/', '\ ', $sourcePdf);

    $cmd = "pdftohtml -enc UTF-8 $sourcePdf $dir" . "pda-output";
    exec($cmd);

    $htmlContent = file_get_contents($dir . "pda-outputs.html");
    $DOM = new DOMDocument('1.0', 'UTF-8');
    $DOM->loadHTML(mb_convert_encoding($htmlContent, 'HTML-ENTITIES', 'UTF-8'));

    $Bold = $DOM->getElementsByTagName('b');
    $Body = $DOM->getElementsByTagName('body');

    $degree = trim(preg_replace('/\(.+\)/', '', $Bold[0]->textContent));

    $pda_data = preg_split('/Presen./', $Body[0]->textContent)[1];

    $courses = preg_split('/[0-9].+Curso/', $pda_data);

    $subjects_1y = preg_split('/(?=G[0-9]{6})/', $courses[1]);
    unset($subjects_1y[0]);
    $subjects_2y = preg_split('/(?=G[0-9]{6})/', $courses[2]);
    unset($subjects_2y[0]);
    $subjects_3y = preg_split('/(?=G[0-9]{6})/', $courses[3]);
    unset($subjects_3y[0]);
    $subjects_4y = preg_split('/(?=G[0-9]{6})/', $courses[4]);
    unset($subjects_4y[0]);

    $tfg = utf8_decode(preg_split('/(Â \n){3,}/', utf8_encode(array_pop($subjects_4y)))[0]);

    loadCourse($subjects_1y, 1, $degree);
    loadCourse($subjects_2y, 2, $degree);
    loadCourse($subjects_3y, 3, $degree);
    loadCourse($subjects_4y, 4, $degree);
}

function loadCourse($subjects, $course, $degree) {

    $degreeDAO = new DegreeDAO();
    $departmentDAO = new DepartmentDAO();
    $subjectDAO = new SubjectDAO();

    foreach ($subjects as $subject_data) {
        $subject_data = preg_split('/\n/', trim($subject_data));
        $code = substr($subject_data[0], 0, 7);
        $content = substr($subject_data[1], 90);
        unset($subject_data[0]);
        unset($subject_data[1]);

        $subject_data = join(" ", $subject_data);
        $subject_data = utf8_decode(preg_replace('/Â /', ' ', utf8_encode(trim($subject_data))));
        $subject_data = preg_split('/\s/', utf8_encode(trim($subject_data)));

        if (!is_numeric($subject_data[sizeof($subject_data) - 1])) {
            $content = $content . ' ' . $subject_data[sizeof($subject_data) - 1];
        }

        $reindex = 0;
        $department = NULL;

        if ($subject_data[1][0] != 'D') {
            $reindex = 1;
            foreach ($subject_data as $datum) {
                if ($datum[0] == 'D') {
                    $department = $datum;
                }
            }
        } else {
            $department = $subject_data[1];
        }

        $type = $subject_data[0];
        $area = $subject_data[2 - $reindex];
        $quarter = $subject_data[3 - $reindex][0];
        $credits = intval($subject_data[4 - $reindex]);
        $newRegistration = intval($subject_data[5 - $reindex]);
        $repeaters = intval($subject_data[6 - $reindex]);
        $effectiveStudents = intval($subject_data[7 - $reindex]);
        $enrolledHours = $subject_data[15 - $reindex];
        $taughtHours = $subject_data[16 - $reindex];
        $hours = (string)$credits * 25;
        $students = $newRegistration + $repeaters;

        try {
            $subject = new Materia();
            $department = $departmentDAO->show("codigo", $department);
            $degree_obj = $degreeDAO->show("nombre", $degree);

            $subject->setCodigo($code);
            $subject->setContenido($content);
            $subject->setTipo($type);
            $subject->setDepartamento($department);
            $subject->setArea($area);
            $subject->setCurso($course);
            $subject->setCuatrimestre($quarter);
            $subject->setCreditos($credits);
            $subject->setNuevoRegistro($newRegistration);
            $subject->setRepeticiones($repeaters);
            $subject->setEstudiantesEfectivos($effectiveStudents);
            $subject->setHorasInscritas($enrolledHours);
            $subject->setHorasEnseño($taughtHours);
            $subject->setHoras($hours);
            $subject->setAlumnos($students);
            $subject->setGrado($degree_obj);
            $subject->setProfesor(NULL);

            $subjectDAO->add($subject);
        } catch (Exception $e) {
        }
    }
}
