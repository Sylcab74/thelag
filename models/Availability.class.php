<?php

namespace Lag\Model;

use \Lag\Core\Table;

class Availability extends Table
{
    protected $table_name = 'availabilities';
    protected $fields_list = ['start','end','users_id'];

    public $id;
    public $start;
    public $end;
    public $users_id;
}