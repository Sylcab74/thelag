<?php

class User extends Table
{
    protected $table_name = 'users';
    protected $fields_list = ['login', 'password', 'email', 'firstname', 'lastname', 'picture'];

    public $id;
    public $login;
    public $password;
    public $email;
    public $firstname;
    public $lastname;
    public $picture;
}