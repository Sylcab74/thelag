<?php

require_once('dbtools.php');

echo "<pre>";
var_dump($_SERVER);
echo "</pre>";




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

        $result = myFetchAssoc($query);

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

            myQuery($query);

        }else
        {
            $query = "INSERT INTO ".$this->table_name." (".implode(", ", $this->fields_list).") VALUES (";
            foreach ($this->fields_list as $column)
            {
                $query .= "'".$this->{$column}."' ,";
            }
            $query = rtrim($query, ',');
            $query .= ")";

            myQuery($query);
            $this->{$this->pk_field_name} = mysqli_insert_id(getLink());

        }
    }
}

class Genre extends Table
{
    protected $pk_field_name = 'id_genre';
    protected $table_name = 'genres';
    protected $fields_list = ['nom'];

    public $id_genre;
    public $nom;
}

class Distributeur extends Table
{
    protected $pk_field_name = 'id_distributeur';
    protected $table_name = 'distributeurs';
    protected $fields_list = ['telephone','nom','adresse','cpostal','ville','pays'];

    public $id_distributeur;
    public $nom;
    public $telephone;
    public $adresse;
    public $cpostal;
    public $ville;
    public $pays;
}

$distrib = new Distributeur;
$distrib->id_distributeur = 55;
$distrib->hydrate();
$distrib->telephone = "un tel";
$distrib->save();

$test = new Distributeur;
$test->telephone = "cest le telephone rose";
$test->adresse = "chez moi";
$test->save();
