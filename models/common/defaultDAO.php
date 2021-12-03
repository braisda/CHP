<?php

class defaultDAO
{
    var $mysqli;

    function __construct()
    {
        error_reporting(0);
        if (isset($_SESSION['env']) && $_SESSION['env'] == 'test') {
            $this->mysqli = new mysqli("127.0.0.1", "adminCHP", "passCHP", "testCHP");
        } else {
            $this->mysqli = new mysqli("127.0.0.1", "root", "", "chp");
        }

        if ($this->mysqli->connect_errno) {
            throw new DAOException("Error de conexión con MySQL: (ERROR " . $this->mysqli->connect_errno . ")");
        }
    }

    function showAll($className)
    {
        $sql = "SELECT * FROM " . strtoupper($className);
        return $this->getArrayFromSqlQuery($sql);
    }

    function insert($entity, $primary_key)
    {
        $attributes = array_keys($entity->expose());
        $sql_keys = "";
        $sql_values = "";
        foreach ($attributes as $attribute) {
            $function_name = $this->changeFunctionName($attribute);
            $value = $entity->$function_name();
            
            if(is_object($value)) {
                $attribute = "id" . $attribute;
                $value = $value->getId();
            }
            
            if ($sql_keys == "") {
                $sql_keys = "(" . $attribute;
            } else {
                $sql_keys = $sql_keys . "," . $attribute;
            }
            
            $value = $this->checkValueType($value);
            
            if ($sql_values == "") {
                $sql_values = "(" . $value;
            } else {
                $sql_values = $sql_values . ", " . $value;
            }
        }
        
        $primary_key_function = $this->changeFunctionName($primary_key);
        $sql = "SELECT * FROM " . $this->getTableName($entity) . " WHERE " . $primary_key . "='".
        $entity->$primary_key_function() . "'";
        if (!$result = $this->mysqli->query($sql)){
            throw new DAOException('Error de conexión con la base de datos.');
        }
        else {
            if ($result->num_rows == 0){
                $sql = "INSERT INTO " . $this->getTableName($entity) . $sql_keys . ") VALUES " . $sql_values . ")";
                if(!$resultInsertion = $this->mysqli->query($sql)) {
                    throw new DAOException('Error de la base de datos: %' .
                    str_replace("\'", "", addslashes($this->mysqli->error)) . '%');
                }
            } else {
                throw new DAOException('Entidad duplicada. Ya existe en la base de datos.');
            }
        }
    }

    function delete($entityName, $key, $value)
    {
        $sql = "SELECT * FROM " . strtoupper($entityName) . " WHERE " . $key . "='". $value . "'";
        if (!$result = $this->mysqli->query($sql)) {
            throw new DAOException('Error de conexión con la base de datos.');
        } else {
            if ($result->num_rows != 0) {
                $sql = "DELETE FROM " . strtoupper($entityName) . " WHERE " . $key . "= '" . $value . "'";
                $this->mysqli->query($sql);
            } else {
                throw new DAOException('La entidad que se intenta eliminar no existe.');
            }
        }
    }

    function show($entityName, $key, $value)
    {
        $sql = "SELECT * FROM " . strtoupper($entityName) . " WHERE " . $key . " ='" . $value . "'";
        if (!$result = $this->mysqli->query($sql)) {
            throw new DAOException('Error de conexión con la base de datos.');
        } else {
            if($result->num_rows > 0) {
                return $result->fetch_array();
            } else {
                throw new DAOException('La entidad consultada no existe.');
            }
        }
    }

    function edit($entity, $primary_key)
    {
        $attributes = array_keys($entity->expose());
        $sql = "";

        foreach ($attributes as $attribute) {
            $function_name = $this->changeFunctionName($attribute);
            $value = $entity->$function_name();

            if(is_object($value)) {
                $attribute = "id" . $attribute;
                $value = $value->getId();
            }

            $value = $this->checkValueType($value);

            if ($attribute != $primary_key) {
                if ($sql == "") {
                    $sql = $attribute . " = " . $value;
                } else {
                    $sql = $sql . ", " . $attribute . " = " . $value;
                }
            }
        }

        $primary_key_function = $this->changeFunctionName($primary_key);
        $sql_query = "SELECT * FROM " . $this->getTableName($entity) . " WHERE " . $primary_key . "= '" .
            $entity->$primary_key_function() . "'";

        if (!$result = $this->mysqli->query($sql_query)) {
            throw new DAOException('Error de conexión con la base de datos.');
        } else {
            if ($result->num_rows != 0) {
                $sql_edit = "UPDATE " . $this->getTableName($entity) . " SET " . $sql . " WHERE " .
                    $primary_key . "= '" . $entity->$primary_key_function() . "'";
                if(!$resultEdit = $this->mysqli->query($sql_edit)) {
                    throw new DAOException('Error de la base de datos: %' .
                        str_replace("\'", "", addslashes($this->mysqli->error)) . '%');
                }
            } else {
                throw new DAOException('La entidad a editar no existe en la base de datos.');
            }
        }
    }

    public function truncateTable($entityName)
    {
        $sql = "DELETE FROM " . strtoupper($entityName);
        if (!$result = $this->mysqli->query($sql)) {
            throw new DAOException('Error en la consulta sobre la base de datos');
        }
    }

    function countTotalEntries($entity) {
        $sql = "SELECT COUNT(*) FROM " . $this->getTableName($entity);
        if (!($result = $this->mysqli->query($sql))) {
            throw new DAOException('Error de conexión con la base de datos.');
        } else {
            return $result->fetch_row()[0];
        }
    }

    function checkDependencies($tableName, $value) {
        $sql = "SELECT TABLE_NAME, COLUMN_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                WHERE REFERENCED_TABLE_NAME = '" . strtoupper($tableName) . "'";
        $dependencies = $this->getArrayFromSqlQuery($sql);
        $stringToShow = "";

        foreach ($dependencies as $dependency) {
            $tableDependency = $dependency["TABLE_NAME"];
            $columnDependency = $dependency["COLUMN_NAME"];
            $sql_dependencies = "SELECT * FROM " . $tableDependency . " WHERE " . $columnDependency . " = '" . $value . "'";
            $dependency_array = $this->getArrayFromSqlQuery($sql_dependencies);
            if(!empty($dependency_array)) {
                if($stringToShow == "") {
                    $stringToShow .= "No se puede borrar por que hay %" . count($dependency_array) . "% elementos en %" . $tableDependency .
                        "%";
                } else {
                    $stringToShow .= " y %" . count($dependency_array) . "% elementos en %" . $tableDependency .
                        "%";
                }

                $stringToShow .= " que dependen de esta entidad.";

                throw new DAOException($stringToShow);
            }
        }
    }

    function showAllPaged($currentPage, $itemsPerPage, $entity) {
        $startBlock = ($currentPage - 1) * $itemsPerPage;
        $sql = "SELECT * FROM " . $this->getTableName($entity);
        $sql .= " LIMIT " . $startBlock . "," . $itemsPerPage;
        return $this->getArrayFromSqlQuery($sql);
    }

    private function changeFunctionName($attribute)
    {
        if(strpos($attribute, "_") !== FALSE) {
            $splitted = explode("_", $attribute);
            $function_name = "get";
            foreach ($splitted as $split) {
                $function_name .= ucfirst($split);
            }
        } else {
            $function_name = "get" . ucfirst($attribute);
        }
        return $function_name;
    }

    private function checkValueType($value)
    {
        $valueToReturn = $value;
        if (empty($value)) {
            $valueToReturn = "NULL";
        } elseif (!is_int($value)) {
            $valueToReturn = "'" . $value . "'";
        }
        return $valueToReturn;
    }

    function getArrayFromSqlQuery($sql) {
        if (!($result = $this->mysqli->query($sql))) {
            throw new DAOException('Error de conexión con la base de datos.');
        } else {
            $arrayData = array();
            $i = 0;
            while ($data = $result->fetch_array()) {
                $arrayData[$i] = $data;
                $i++;
            }
            return $arrayData;
        }
    }

    private function getTableName($entity) {
        return strtoupper(preg_replace('/\B([A-Z])/', '_$1', get_class($entity)));
    }

}
