<?php
class Usuario
{
    private $login;
    private $password;
    private $dni;
    private $nombre;
    private $apellido;
    private $email;
    private $direccion;
    private $telefono;

    public function __construct($login=NULL, $password=NULL, $dni=NULL, $nombre=NULL, $apellido=NULL, $email=NULL,
                                $direccion=NULL, $telefono=NULL){
        if(!empty($login) && !empty($login)){
            $this->constructEntity($login,$password,$dni,$nombre,$apellido,$email,$direccion,$telefono);
        }
    }

    private function constructEntity($login=NULL, $password=NULL, $dni=NULL, $nombre=NULL, $apellido=NULL, $email=NULL,
                                     $direccion=NULL, $telefono=NULL){
            $this->setLogin($login);
            $this->setPassword($password);
            $this->setDni($dni);
            $this->setNombre($nombre);
            $this->setApellido($apellido);
            $this->setEmail($email);
            $this->setDireccion($direccion);
            $this->setTelefono($telefono);
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

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        if (empty($nombre) || strlen($nombre)>30) {
            throw new ValidationException('Error de validación. Nombre incorrecto.');
        } else {
            $this->nombre = $nombre;
        }
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function setApellido($apellido)
    {
        if (empty($apellido) || strlen($apellido)>50) {
            throw new ValidationException('Error de validación. Apellido incorrecto.');
        } else {
            $this->apellido = $apellido;
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

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function setDireccion($direccion)
    {
        if (empty($direccion) || strlen($direccion)>60) {
            throw new ValidationException('Error de validación. Dirección incorrecta.');
        } else {
            $this->direccion = $direccion;
        }
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono($telefono)
    {
        if (empty($telefono) || strlen($telefono)>11) {
            throw new ValidationException('Error de validación. Teléfono incorrecto.');
        } else {
            $this->telefono = $telefono;
        }
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
