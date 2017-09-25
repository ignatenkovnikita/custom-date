<?php

namespace ignatenkovnikita\helpers;
/**
 * Copyright (C) $user$, Inc - All Rights Reserved
 *
 *  <other text>
 * @file        CustomDate.php
 * @author      ignatenkovnikita
 * @date        $date$
 */

/**
 * Created by PhpStorm.
 * User: ignatenkovnikita
 * Web Site: http://IgnatenkovNikita.ru
 */
class CustomDate
{
    public $year;
    public $month;
    public $day;

    public $hour;
    public $minute;
    public $second;


    const SORT_ASC = 'asc';
    const SORT_DESC = 'desc';


    private $_raw;

    private $_dateTime;

    public function __construct($string, $format = 'H:i:s d.m.Y')
    {
        $this->_raw = $string;
        $this->_dateTime = new \DateTime();
        $this->_format = $format;
        $this->fill();

    }


    public function getFormatted()
    {
        return $this->_dateTime->format($this->_format);
    }

    public function getTimestamp(){
        return $this->_dateTime->getTimestamp();
    }


    public static function sortDate($array, $order_by = self::SORT_ASC)
    {
        foreach ($array as &$item) {
            $customDate = new CustomDate($item['string']);

            $item['unixtime'] = $customDate->getTimestamp();
        }


        usort($array, function($a, $b) {
            return $a['unixtime'] - $b['unixtime'];
        });

        return $array;

    }

    protected function fill()
    {
        $pattern = '/(\d{2}:|)(\d{2}:|)(\d{2}|)( |)(\d{2}\.|)(\d{2}\.|)(\d{4})/';
        $found = preg_match($pattern, $this->_raw, $matches);


        $this->hour = $this->fillDetail($matches, 1);
        $this->minute = $this->fillDetail($matches, 2);
        $this->second = $this->fillDetail($matches, 3);
        $this->day = $this->fillDetail($matches, 5);
        $this->month = $this->fillDetail($matches, 6);
        $this->year = $this->fillDetail($matches, 7);


        $this->_dateTime->setDate($this->year, $this->month, $this->day);
        $this->_dateTime->setTime($this->hour, $this->minute, $this->second);
    }

    protected function fillDetail($data, $index)
    {
        if (isset($data[$index])) {
            return (int)preg_replace('/\D/', '', $data[$index]);
        }
        return 0;
    }


}