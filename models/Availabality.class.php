<?php

class Availability extends Table
{
    protected $table_name = 'availability';
    protected $fields_list = ['start','end','users_id'];

    public $id;
    public $start;
    public $end;
    public $users_id;
}