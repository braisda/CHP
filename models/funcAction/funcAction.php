<?php
class FuncAction
{
    private $id;
    private $action;
    private $functionality;

    public function __construct($id=NULL, $action=NULL, $functionality=NULL){
        $this->id = $id;
        $this->action = $action;
        $this->functionality = $functionality;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if (empty($id) || strlen($id)>8) {
            throw new ValidationException('Error de validación. Id incorrecto.');
        } else {
            $this->id = $id;
        }
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setAction($action)
    {
        if (empty($action) || strlen($action)>8) {
            throw new ValidationException('Error de validación. Acción incorrecta.');
        } else {
            $this->action = $action;
        }
    }

    public function getFunctionality()
    {
        return $this->functionality;
    }

    public function setFunctionality($functionality)
    {
        if (empty($functionality) || strlen($functionality)>8) {
            throw new ValidationException('Error de validación. Funcionalidad incorrecta.');
        } else {
            $this->functionality = $functionality;
        }
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }
}
