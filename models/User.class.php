<?php

namespace Lag\Model;

use \Lag\Core\Table;

class User extends Table
{
    protected $table_name = 'users';
    protected $fields_list = ['id','login', 'password', 'email', 'firstname', 'lastname', 'picture', 'availability'];

    public $id;
    public $login;
    public $password;
    public $email;
    public $firstname;
    public $lastname;
    public $picture;
    public $availability = [];
}