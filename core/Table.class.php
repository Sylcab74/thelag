<?php

namespace Lag\Core;

abstract class Table
{

    public function dump()
    {
        echo "<pre>";
        var_dump($this);
        echo "</pre>";
    }

    public static function findBy($column, $value)
    {
        $response = [];

        $query = "SELECT * FROM ".static::$table_name." WHERE " . $column . " = '".$value . "'";
        $results = self::myFetchAllAssoc($query);

        $class = get_called_class();

        foreach ($results as $result) {
            $obj = new $class;
            $obj->id = $result['id'];
            foreach ($obj->fields_list as $field_name){
                $obj->{$field_name} = $result[$field_name];
            }
            $response[] = $obj;
        }

        return $response;
    }

    public function hydrate()
    {
        if (empty($this->id))
            die('try to hydrate without PK');

        $query = "SELECT * FROM ".static::$table_name." WHERE id = ".$this->id;
        $result = $this->myFetchAssoc($query);

        foreach ($this->fields_list as $field_name){

            if (is_array($this->{$field_name})) {
                $objRelation = 'Lag\\Model\\'.ucfirst($field_name);
                $obj = new $objRelation;
                $column = strtolower(static::$table_name).'_id';
                $this->{$field_name} = $obj->findBy($column ,$this->id);

            } else {
                $this->{$field_name} = $result[$field_name];
            }
        }
    }

    public function save()
    {
        global $link;

        if ( !empty($this->id) ) {
            $query = "UPDATE ".static::$table_name." SET ";

            foreach ($this->fields_list as $field_name) {
                if(!empty($this->{$field_name}))
                    $query .= " ".$field_name ." = '". $this->{$field_name}."' , ";
            }

            $query = rtrim($query, ', ');
            $query .= " WHERE id = '".$this->id."'";


            $this->myQuery($query);

        } else {

            $query = "INSERT INTO " . static::$table_name . " (" . implode(", ", $this->fields_list) . ") VALUES (";

            foreach ($this->fields_list as $column){
                if (!is_array($this->{$column}) && $column !== "id") {
                    $query .= "'" . $this->{$column} . "' ,";
                }
            }

            $query = rtrim($query, ',');
            $query .= ")";

            $this->myQuery($query);
            $this->id = mysqli_insert_id($link);
        }
    }

    public function findAll()
    {
        $response = [];
        $query = "SELECT * FROM " . static::$table_name;
        $results = self::myFetchAllAssoc($query);
        $class =  get_called_class();

        foreach ($results as $result) {
            $obj = new $class();
            foreach ($obj->fields_list as $field_name)
                $obj->{$field_name} = $result[$field_name];

            $obj->id = $result['id'];
            $response[] = $obj;
        }

        return $response;
    }

    function myQuery($query)
    {
        global $link;

        if (empty($link))
            $link = mysqli_connect('db', 'root', 'root', 'lag') or die (mysqli_connect_error());
        mysqli_set_charset($link, "utf8"); // Set the charset in UTF8;
        $result = mysqli_query($link, $query) or die (mysqli_error($link));
        return $result;
    }

    function myFetchAssoc($query)
    {
        global $link;

        $result = $this->myQuery($query) or die (mysqli_error($link));
        if (!$result)
            return false;
        $tab_res = mysqli_fetch_assoc($result);
        return $tab_res;

    }

    function myFetchAllAssoc($query)
    {
        global $link;

        $result = self::myQuery($query) or die (mysqli_error($link));
        if (!$result)
            return false;

        $tab_res = [];

        while ($array = mysqli_fetch_assoc($result))
            $tab_res[] = $array;
        return $tab_res;
    }
}
