<?php

namespace BusinessDayFinder;

class Holiday
{
    public $date;
    public $name;

    public function __construct(\DateTime $date, $name = '')
    {
        $this->date = $date;
        $this->name = $name;
    }
}
