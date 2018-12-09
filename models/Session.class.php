<?php

class Session extends Table
{
    protected $table_name = 'sessions';
    protected $fields_list = ['id', 'start', 'end', 'participant_id', 'coach_id', 'games_id', 'availabilities_id'];

    public $id;
    public $start;
    public $end;
    public $participant_id;
    public $coach_id;
    public $games_id;
    public $availabilities_id;
}