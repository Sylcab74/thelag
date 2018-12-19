<?php

namespace Lag\Model;

use \Lag\Core\Table;

class Session extends Table
{
    protected static $table_name = 'sessions';
    protected $fields_list = ['start', 'end', 'participant_id', 'coach_id', 'games_id', 'availabilities_id', 'comments'];

    public $id;
    public $start;
    public $end;
    public $participant_id;
    public $coach_id;
    public $games_id;
    public $comments;
    public $availabilities_id;
}
