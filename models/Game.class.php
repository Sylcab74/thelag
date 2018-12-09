<?php

class Game extends Table
{
    protected $table_name = 'games';
    protected $fields_list = ['name', 'type'];

    public $id;
    public $name;
    public $type;
}