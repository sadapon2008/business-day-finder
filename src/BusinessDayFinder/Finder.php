<?php

namespace BusinessDayFinder;

class Finder
{
    private $holidays = array();
    private $dayOfWeekFlags = array(
        0 => false, // Sun
        1 => true, // Mon
        2 => true, // Tue
        3 => true, // Wed
        4 => true, // Tur
        5 => true, // Fri
        6 => false, // Sat
    );

    public function __construct()
    {
    }

    public function addHoliday(Holiday $holiday)
    {
        $key = (int)$holiday->date->format('Ymd');
        $this->holidays[$key] = $holiday;
        ksort($this->holidays);
    }

    public function addHolidayArray($holidays)
    {
        foreach ($holidays as $holiday) {
            $key = (int)$holiday->date->format('Ymd');
            $this->holidays[$key] = $holiday;
        }
        ksort($this->holidays);
    }

    public function getHolidayArray()
    {
        return array_values($this->holidays);
    }
    public function clearHoliday()
    {
        $this->holidays = array();
    }

    public function setSundayFlag($flag)
    {
        $this->dayOfWeekFlags[0] = $flag;
    }

    public function getSundayFlag()
    {
        return $this->dayOfWeekFlags[0];
    }

    public function setMondayFlag($flag)
    {
        $this->dayOfWeekFlags[1] = $flag;
    }

    public function getMondayFlag()
    {
        return $this->dayOfWeekFlags[1];
    }

    public function setTuesdayFlag($flag)
    {
        $this->dayOfWeekFlags[2] = $flag;
    }

    public function getTuesdayFlag()
    {
        return $this->dayOfWeekFlags[2];
    }

    public function setWednesdayFlag($flag)
    {
        $this->dayOfWeekFlags[3] = $flag;
    }

    public function getWednesdayFlag()
    {
        return $this->dayOfWeekFlags[3];
    }
    public function setThursdayFlag($flag)
    {
        $this->dayOfWeekFlags[4] = $flag;
    }

    public function getThursdayFlag()
    {
        return $this->dayOfWeekFlags[4];
    }

    public function setFridayFlag($flag)
    {
        $this->dayOfWeekFlags[5] = $flag;
    }

    public function getFridayFlag()
    {
        return $this->dayOfWeekFlags[5];
    }

    public function setSaturdayFlag($flag)
    {
        $this->dayOfWeekFlags[6] = $flag;
    }

    public function getSaturdayFlag()
    {
        return $this->dayOfWeekFlags[6];
    }

    public function isBusinessDay(\DateTime $date)
    {
        // 曜日チェック
        $w = (int)$date->format('w');
        if (empty($this->dayOfWeekFlags[$w])) {
            return false;
        }

        // 祝日チェック
        $key = (int)$date->format('Ymd');
        $holidays = array_values($this->holidays);
        $left = 0;
        $right = count($holidays)-1;
        $pos = null;
        while ($left <= $right) {
            $p = (int)(($left + $right)/2);
            $target = (int)$holidays[$p]->date->format('Ymd');
            if ($target === $key) {
                $pos = $p;
                break;
            } elseif ($target < $key) {
                $left = $p + 1;
            } else {
                $right = $p - 1;
            }
        }
        if ($pos !== null) {
            return false;
        }

        return true;
    }


    public function getBusinessDayForward(\DateTime $date)
    {
        $dt = clone $date;
        while (!$this->isBusinessDay($dt)) {
            $dt->add(\DateInterval::createFromDateString('+1 days'));
        }
        return $dt;
    }

    public function getBusinessDayBackward(\DateTime $date)
    {
        $dt = clone $date;
        while (!$this->isBusinessDay($dt)) {
            $dt->add(\DateInterval::createFromDateString('-1 days'));
        }
        return $dt;
    }
}
