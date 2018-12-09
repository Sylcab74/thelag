<?php

class Session extends Table
{
    protected $table_name = 'sessions';
    protected $fields_list = ['id', 'start', 'end', 'participant_id', 'coach_id', 'games_id', 'availabalities_id'];

    public $id;
    public $start;
    public $end;
    public $participant_id;
    public $coach_id;
    public $games_id;
    public $availabalities_id;
}