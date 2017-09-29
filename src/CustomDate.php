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
     * @var \DateTime
     */
    private $_dateTime;

    /**
     * CustomDate constructor.
     * @param $string
     * @param string $formatter
     * @internal param int|string $format
     */
    public function __construct($string, $formatter = self::FORMAT_BASE)
    {
        /** @var BaseFormat $formater */
        $format = (new ReflectionClass($formatter))->newInstance();
        $format->raw = $string;

        $this->_dateTime = $format->fill();

    }


    /**
     * @param bool|string $format
     * @return string
     */
    public function getFormatted($format = 'H:i:s d.m.Y')
    {
        return $this->_dateTime->format($format);
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->_dateTime->getTimestamp();
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