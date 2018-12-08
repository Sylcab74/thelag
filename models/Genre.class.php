<?php

class Genre extends Table
{
    protected $pk_field_name = 'id_genre';
    protected $table_name = 'genres';
    protected $fields_list = ['nom'];

    public $id_genre;
    public $nom;
}