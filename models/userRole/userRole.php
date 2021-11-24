<?php
class UserRole
{
    private $id;
    private $role;
    private $user;

    public function __construct($id=NULL, $role=NULL, $user=NULL) {
        $this->id = $id;
        $this->role = $role;
        $this->user = $user;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        if (empty($id) || strlen($id)>8) {
            throw new ValidationException('Error de validación. Id incorrecto.');
        } else {
            $this->id = $id;
        }
    }

    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        if (empty($role) || strlen($role)>8) {
            throw new ValidationException('Error de validación. Id role incorrecto.');
        } else {
            $this->role = $role;
        }
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        if (empty($user) || strlen($user)>9) {
            throw new ValidationException('Error de validación. Id usuario incorrecto.');
        } else {
            $this->user = $user;
        }
    }

    public static function expose() {
        return get_class_vars(__CLASS__);
    }
}
?>