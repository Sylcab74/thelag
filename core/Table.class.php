<?php

abstract class Table
{
    public function dump()
    {
        echo "<pre>";
        var_dump($this);
        echo "</pre>";
    }

    public function hydrate()
    {
        if (empty($this->{$this->pk_field_name}))
            die('try to hydrate without PK');

        // recuperer les donnees en BDD
        $query = "SELECT * FROM ".$this->table_name." WHERE ".$this->pk_field_name." = ".$this->{$this->pk_field_name};

        $result = $this->myFetchAssoc($query);

        foreach ($this->fields_list as $field_name)
            $this->{$field_name} = $result[$field_name];
    }

    public function save()
    {
        global $link;

        if( !empty($this->{$this->pk_field_name}) )
        {
            echo "<h1>update</h1>";

            $query = "UPDATE ".$this->table_name." SET ";

            foreach ($this->fields_list as $field_name)
            {
                if(!empty($this->{$field_name}))
                    $query .= " ".$field_name ." = '". $this->{$field_name}."' , ";
            }
            $query = rtrim($query, ', ');

            $query .= " WHERE '".$this->pk_field_name."' = '".$this->{$this->pk_field_name}."'";

            $this->myQuery($query);

        }else
        {
            $query = "INSERT INTO ".$this->table_name." (".implode(", ", $this->fields_list).") VALUES (";
            foreach ($this->fields_list as $column)
            {
                $query .= "'".$this->{$column}."' ,";
            }
            $query = rtrim($query, ',');
            $query .= ")";

            $this->myQuery($query);
            $this->{$this->pk_field_name} = mysqli_insert_id(getLink());

        }
    }

    function myQuery($query)
    {
        global $link;

        if (empty($link))
            $link = mysqli_connect('db', 'root', 'root', 'lag') or die (mysqli_connect_error());
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

        $result = $this->myQuery($query) or die (mysqli_error($link));
        if (!$result)
            return false;

        $tab_res = [];

        while ($array = mysqli_fetch_assoc($result))
            $tab_res[] = $array;
        return $tab_res;
    }
}