<?php
class CursoAcademico
{
    private $id;
    private $nombre;
    private $anoinicio;
    private $anofin;

    public function __construct($id=NULL,$nombre=NULL, $anoinicio=NULL, $anofin=NULL)
    {
        if (!empty($anoinicio) && !empty($anofin)) {
            $this->constructEntity($id ,$nombre, $anoinicio, $anofin);
        }
    }
    
    private function constructEntity($id=NULL,$nombre=NULL , $anoinicio=NULL, $anofin=NULL) {
        if ($this->isCorrectAcademicCourse($anoinicio, $anofin)) {
            if($nombre === NULL) {
                $nombre = $this->formatAbbr($anoinicio, $anofin);
            }
            $this->setId($id);
            $this->setNombre($nombre);
            $this->setAnoinicio($anoinicio);
            $this->setAnofin($anofin);
        }
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        if (strlen($id)>8) {
            throw new Exception('Error de validación. Id incorrecto.');
        } else {
            $this->id = $id;
        }
    }

    public function getAnoinicio()
    {
        return $this->anoinicio;
    }

    public function setAnoinicio($anoinicio)
    {
        if($anoinicio<2000 || $anoinicio>9999 || !is_numeric($anoinicio)){
            throw new ValidationException('Año fuera de rango.');
        } else {
            $this->anoinicio = intval($anoinicio);
        }
    }

    public function getAnofin()
    {
        return $this->anofin;
    }

    public function setAnofin($anofin)
    {
        if($anofin<2000 || $anofin>9999 || !is_numeric($anofin)){
            throw new ValidationException('Año fuera de rango.');
        } else {
            $this->anofin = intval($anofin);
        }

    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    function isCorrectAcademicCourse($startYear, $endYear){
        if ($startYear >= $endYear) {
            throw new ValidationException('Año de inicio mayor o igual que año fin.');
        } elseif ($startYear != ($endYear - 1)) {
            throw new ValidationException('No puede existir una diferencia de más de 1 año entre cursos.');
        } else {
            return true;
        }
    }

    function formatAbbr($anoinicio, $anofin){
        return substr($anoinicio,-2) . "/" . substr($anofin,-2);
    }

    public static function expose()
    {
        return get_class_vars(__CLASS__);
    }

}
