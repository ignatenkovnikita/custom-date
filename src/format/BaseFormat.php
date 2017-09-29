<?php

namespace ignatenkovnikita\helpers\format;

use ignatenkovnikita\helpers\AbstractFormat;
use ignatenkovnikita\helpers\InerfaceFormat;

class BaseFormat extends AbstractFormat implements InerfaceFormat
{
    protected $_format = 'H:i:s d.m.Y';

    /**
     * Fill attributes and object DateTime
     */
    public function fill()
    {
//        $pattern = '/(\d{2}:|)(\d{2}:|)(\d{2}|)( |)(\d{2}\.|)(\d{2}\.|)(\d{4})/';
        $pattern = '/(((\d{2,2})?:?(\d{2,2})?:?(\d{2,2})?)?\s?((\d{2,2})?\.?(\d{2,2})?\.?(\d{2,4})?)?)/';
        $found = preg_match($pattern, $this->raw, $matches);
        if (empty($found)) {
            throw  new \Exception('Not parse string');
        }


        $hour = $this->fillDetail($matches, 3);
        $minute = $this->fillDetail($matches, 4);
        $second = $this->fillDetail($matches, 5);
        $day = $this->fillDetail($matches, 7);
        $month = $this->fillDetail($matches, 8);
        $year = $this->fillDetail($matches, 9);


        $this->_dateTime->setDate($year, $month, $day);
        $this->_dateTime->setTime($hour, $minute, $second);
        return $this->_dateTime;
    }

    /**
     * @param $data
     * @param $index
     * @return int
     */
    protected function fillDetail($data, $index)
    {
        if (isset($data[$index])) {
            return (int)preg_replace('/\D/', '', $data[$index]);
        }
        return 0;
    }
}