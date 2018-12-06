<?php

require_once ('dbtools.php');

abstract class Table
{
    public function dump()
    {
        //var_dump($this);
        $classVars = get_class_vars(get_called_class());
        var_dump($classVars);
    }

    public function hydrate()
    {
        if (empty($this->{$this->pk_field_name}))
            die ('try to hydrate without PK');

        $query = 'SELECT * FROM'. $this->table_name .' WHERE '. $this .' = '.$this->id_genre;

        $classVars = get_class_vars(get_called_class());


        $result = myFetchAssoc($query);

        $this->nom = $result['nom'];
    }
}

class Genre extends Table
{
    public $pk_field_name = 'id_genre';
    public $table_name = 'genres';

    public $id_genre;
    public $nom;
}

class Distributeur extends Table
{
    public $id_distributeur;
    public $nom;
    public $telephone;
    public $adresse;
    public $cpostal;
    public $ville;
    public $pays;

    public function dump()
    {
        var_dump($this);
    }

    public function hydrate()
    {
        if (empty($this->id_distributeur))
            die ('try to hydrate without PK');

        $query = 'SELECT nom FROM genres WHERE id_genre = '.$this->id_distributeur;

        $result = myFetchAssoc($query);

        $this->nom = $result['nom'];
        $this->telephone = $result['telephone'];
        $this->adresse = $result['adresse'];
        $this->cpostal = $result['cpostal'];
        $this->ville = $result['ville'];
        $this->pays = $result['pays'];
    }
}

$anime = new Genre();
$anime->id_genre = 25;

$distrib = new Distributeur();
$distrib->id_distributeur = 12;

echo '<pre>';
//$anime->hydrate();
$anime->dump();
echo '<pre>';