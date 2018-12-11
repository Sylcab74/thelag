<?php

namespace Service;

class Calendar
{
    public function generateCalendar()
    {
        $day = date('w');
        $weekStart = date('m-d-Y', strtotime('-'.($day - 1).' days'));
        $weekEnd = date('m-d-Y', strtotime('+'.(8-$day).' days'));
    }
    
    public function changeWeek()
    {
        //
    }
}
