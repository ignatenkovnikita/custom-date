<?php

namespace ignatenkovnikita\helpers;
/**
 * Class CustomDate
 * @package ignatenkovnikita\helpers
 */
/**
 * Class CustomDate
 * @package ignatenkovnikita\helpers
 */
use ignatenkovnikita\helpers\format\BaseFormat;
use ReflectionClass;

/**
 * Class CustomDate
 * @package ignatenkovnikita\helpers
 */
class CustomDate
{
    /**
     * Supported string type
     * This format H:i:s d.m.Y
     */
    const FORMAT_BASE = BaseFormat::class;
    /**
     * Type Sort ASC
     */
    const SORT_ASC = 'asc';
    /**
     * Type Sort DESC
     */
    const SORT_DESC = 'desc';

    /**
     * @var BaseFormat
     */
    private $_formatter;

    /**
     * CustomDate constructor.
     * @param $string
     * @param string $formatter
     * @internal param int|string $format
     */
    public function __construct($string, $formatter = self::FORMAT_BASE)
    {
        /** @var BaseFormat $formater */
        $this->_formatter = (new ReflectionClass($formatter))->newInstance();
        $this->_formatter->raw = $string;
        $this->_formatter->fill();

    }


    /**
     * @param bool|string $format
     * @return string
     */
    public function getFormatted()
    {
        return $this->_formatter->formatted();
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        $seconds = 0;

        $seconds += $this->_formatter->second;
        $seconds += $this->_formatter->minute * 60;
        $seconds += $this->_formatter->hour * 60 * 60;
        $seconds += $this->_formatter->day * 60 * 60 * 24;
        $seconds += $this->_formatter->month * 60 * 60 * 24 * 31;
        $seconds += $this->_formatter->year * 60 * 60 * 24 * 31 * 365;
        return $seconds;

    }


    /**
     * @param $array
     * @param string $order_by
     * @param string $formatter
     * @return mixed
     */
    public static function sortDate($array, $order_by = self::SORT_ASC, $formatter = self::FORMAT_BASE)
    {
        foreach ($array as &$item) {
            $customDate = new CustomDate($item['string'], $formatter);

            $item['formatted'] = $customDate->getFormatted();
            $item['unixtime'] = $customDate->getTimestamp();
        }


        if ($order_by == self::SORT_ASC) {
            usort($array, function ($a, $b) {
                return $a['unixtime'] - $b['unixtime'];
            });
        }
        if ($order_by == self::SORT_DESC) {
            usort($array, function ($a, $b) {
                return $b['unixtime'] - $a['unixtime'];
            });
        }

        return $array;

    }


}