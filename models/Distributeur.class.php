<?php

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