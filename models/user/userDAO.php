<?php
include_once '../models/common/defaultDAO.php';
include_once 'usuario.php';

class userDAO
{
    private $defaultDAO;
    public function __construct() {
        $this->defaultDAO = new defaultDAO();
    }

    function showAll() {
        $usersDB = $this->defaultDAO->showAll("usuario");
        return $this->getUsersFromDB($usersDB);
    }

    function add($user) {
        $this->defaultDAO->insert($user, "login");
    }

    function delete($key, $value) {
        $this->defaultDAO->delete("usuario", $key, $value);
    }

    function show($key, $value) {
        $user_db = $this->defaultDAO->show("usuario", $key, $value);
        return new Usuario($user_db["login"], $user_db["password"], $user_db["dni"], $user_db["nombre"],
            $user_db["apellido"], $user_db["email"], $user_db["direccion"], $user_db["telefono"]);
    }

    function edit($user) {
        $this->defaultDAO->edit($user, "login");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("usuario");
    }

    function canBeLogged($login, $password) {
        $result = $this->show("login", $login);
        if (!is_null($result)){
            if ($result->getPassword() != md5($password)){
                throw new DAOException('Contraseña incorrecta.');
            }
        } else {
            throw new DAOException("El usuario no existe.");
        }
    }

    function showAllPaged($currentPage, $itemsPerPage) {
        $usersDB = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new Usuario());
        return $this->getUsersFromDB($usersDB);
    }

    function countTotalUsers() {
        return $this->defaultDAO->countTotalEntries(new Usuario());
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("user", $value);
    }

    function search($login, $name, $surname, $email) {
        $sql = "SELECT DISTINCT * FROM usuario WHERE login LIKE '%".
            $login . "%' AND nombre LIKE '%" .
            $name . "%' AND apellido LIKE '%".
            $surname . "%'";
        if (!empty($email)) {
            $sql .=  "AND email = '" . $email . "'";
        }

        return $this->defaultDAO->getArrayFromSqlQuery($sql);
    }

    private function getUsersFromDB($usersDB) {
        $users = array();
        foreach ($usersDB as $user) {
            array_push($users, new Usuario($user["login"], $user["password"], $user["dni"], $user["nombre"],
                $user["apellido"], $user["email"], $user["direccion"], $user["telefono"]));
        }
        return $users;
    }

}
