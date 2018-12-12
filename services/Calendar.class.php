<?php

namespace Lag\Service;

class Calendar
{
    public function getWeekStart()
    {
        $day = date('w');
        return date('d', strtotime('-'.($day - 1).' days'));
    }
    
    public function changeWeek()
    {
        //
    }
}
