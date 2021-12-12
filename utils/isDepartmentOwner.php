<?php
include_once "../models/department/departmentDAO.php";
include_once "../models/department/departamento.php";
include_once 'userInSession.php';

function IsDepartmentOwner() {

    $return = array();
    $departmentDAO = new DepartmentDAO();

    try {

        $departments = $departmentDAO->showAll();
        foreach ($departments as $department) {

            if ($department->getIdprofesor()->getUsuario()->getId() == getUserInSession()) {
                array_push($return, $department);
            }
        }
        if (empty($return)) {
            return false;
        } else {
            return $return;
        }
    } catch (DAOException $e) {
        return false;
    }
}