<?php
class user
{
    private $login;
    private $password;
    private $dni;
    private $name;
    private $surname;
    private $email;
    private $address;
    private $telephone;

    public function __construct($login=NULL, $password=NULL, $dni=NULL, $name=NULL, $surname=NULL, $email=NULL,
                                $address=NULL, $telephone=NULL){
        if(!empty($login) && !empty($login)){
            $this->constructEntity($login,$password,$dni,$name,$surname,$email,$address,$telephone);
        }
    }

    private function constructEntity($login=NULL, $password=NULL, $dni=NULL, $name=NULL, $surname=NULL, $email=NULL,
                                     $address=NULL, $telephone=NULL){
            $this->setLogin($login);
            $this->setPassword($password);
            $this->setDni($dni);
            $this->setName($name);
            $this->setSurname($surname);
            $this->setEmail($email);
            $this->setAddress($address);
            $this->setTelephone($telephone);
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getId()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        if (empty($login) || strlen($login)>9) {
            throw new ValidationException('Error de validación. Login incorrecto.');

        } else {
            $this->login = $login;
        }
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        if (empty($password) || strlen($password)>128) {
            throw new ValidationException('Error de validación. Contraseña incorrecta.');
        } else {
            $this->password = $password;
        }
    }

    public function encryptPassword($password)
    {
        return md5($password);
    }

    public function getDni()
    {
        return $this->dni;
    }

    public function setDni($dni)
    {
        if (empty($dni) || strlen($dni)>9) {
            throw new ValidationException('Error de validación. DNI incorrecto.');
        } else {
            $this->dni = $dni;
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if (empty($name) || strlen($name)>30) {
            throw new ValidationException('Error de validación. Nombre incorrecto.');
        } else {
            $this->name = $name;
        }
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname)
    {
        if (empty($surname) || strlen($surname)>50) {
            throw new ValidationException('Error de validación. Apellido incorrecto.');
        } else {
            $this->surname = $surname;
        }
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        if (empty($email) || strlen($email)>40) {
            throw new ValidationException('Error de validación. Email incorrecto.');
        } else {
            $this->email = $email;
        }
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        if (empty($address) || strlen($address)>60) {
            throw new ValidationException('Error de validación. Dirección incorrecta.');
        } else {
            $this->address = $address;
        }
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function setTelephone($telephone)
    {
        if (empty($telephone) || strlen($telephone)>11) {
            throw new ValidationException('Error de validación. Teléfono incorrecto.');
        } else {
            $this->telephone = $telephone;
        }
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
