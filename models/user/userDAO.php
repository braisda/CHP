<?php
include_once '../models/common/defaultDAO.php';
include_once 'user.php';

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
        $this->defaultDAO->delete("user", $key, $value);
    }

    function show($key, $value) {
        $user_db = $this->defaultDAO->show("usuario", $key, $value);
        return new user($user_db["login"], $user_db["password"], $user_db["dni"], $user_db["nombre"],
            $user_db["apellido"], $user_db["email"], $user_db["direccion"], $user_db["telefono"]);
    }

    function edit($user) {
        $this->defaultDAO->edit($user, "login");
    }

    function truncateTable() {
        $this->defaultDAO->truncateTable("user");
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

    function showAllPaged($currentPage, $itemsPerPage, $stringToSearch) {
        $usersDB = $this->defaultDAO->showAllPaged($currentPage, $itemsPerPage, new user(), $stringToSearch);
        return $this->getUsersFromDB($usersDB);
    }

    function countTotalUsers($stringToSearch) {
        return $this->defaultDAO->countTotalEntries(new user(), $stringToSearch);
    }

    function checkDependencies($value) {
        $this->defaultDAO->checkDependencies("user", $value);
    }

    private function getUsersFromDB($usersDB) {
        $users = array();
        foreach ($usersDB as $user) {
            array_push($users, new user($user["login"], $user["password"], $user["dni"], $user["nombre"],
                $user["apellido"], $user["email"], $user["direccion"], $user["telefono"]));
        }
        return $users;
    }

}
