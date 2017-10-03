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
        $pattern = '/^(((\d{2}?:)?(\d{2}?:)?(\d{2,2})?)?\s?((\d{2}?\.)?(\d{2,2}?\.)?(\d{4})?)?)$/m';
        $found = preg_match($pattern, $this->raw, $matches, PREG_OFFSET_CAPTURE, 0);
        if (empty($found)) {
            throw  new \Exception('Not parse string');
        }


        $this->hour = $this->fillDetail($matches, 3);
        $this->minute = $this->fillDetail($matches, 4);
        $this->second = $this->fillDetail($matches, 5);
        $this->day = $this->fillDetail($matches, 7);
        $this->month = $this->fillDetail($matches, 8);
        $this->year = $this->fillDetail($matches, 9);
    }

    /**
     * @param $data
     * @param $index
     * @return int
     */
    protected function fillDetail($data, $index)
    {
        if (isset($data[$index][0])) {
            return preg_replace('/\D/', '', $data[$index][0]);
        }
    }

    public function formatted()
    {
        $time = '';
        $date = '';

        if ($this->hour) {
            $time .= str_pad($this->hour, 2, '0', STR_PAD_LEFT) . ':';
        }
        if ($this->minute) {
            $time .= str_pad($this->minute, 2, '0', STR_PAD_LEFT) . ':';
        }
        if ($this->second) {
            $time .= str_pad($this->second, 2, '0', STR_PAD_LEFT);
        }
        if ($this->day) {
            $date .= str_pad($this->day, 2, '0', STR_PAD_LEFT) . '.';
        }
        if ($this->month) {
            $date .= str_pad($this->month, 2, '0', STR_PAD_LEFT) . '.';
        }
        if ($this->year) {
            $date .= $this->year;
        }

        return trim(implode(' ', [$time, $date]));
    }


}