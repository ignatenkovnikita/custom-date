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
class CustomDate
{
    /**
     * @var integer
     */
    public $year;
    /**
     * @var integer
     */
    public $month;
    /**
     * @var integer
     */
    public $day;

    /**
     * @var integer
     */
    public $hour;
    /**
     * @var integer
     */
    public $minute;
    /**
     * @var integer
     */
    public $second;


    /**
     * Type Sort ASC
     */
    const SORT_ASC = 'asc';
    /**
     * Type Sort DESC
     */
    const SORT_DESC = 'desc';


    /**
     * Input string in construct
     * @var string
     */
    private $_raw;

    /**
     * DateTime object
     * @var \DateTime
     */

    private $_dateTime;
    /**
     * Input Format
     * @var string
     */
    private $_format;

    /**
     * CustomDate constructor.
     * @param $string
     * @param string $format
     */
    public function __construct($string, $format = 'H:i:s d.m.Y')
    {
        $this->_raw = $string;
        $this->_dateTime = new \DateTime();
        $this->_format = $format;
        $this->fill();

    }


    /**
     * @return string
     */
    public function getFormatted($format = false)
    {
        if ($format) {
            return $this->_dateTime->format($format);
        }
        return $this->_dateTime->format($this->_format);
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
     * @return mixed
     */
    public static function sortDate($array, $order_by = self::SORT_ASC)
    {
        foreach ($array as &$item) {
            $customDate = new CustomDate($item['string']);

            $item['unixtime'] = $customDate->getTimestamp();
        }


        usort($array, function ($a, $b) {
            return $a['unixtime'] - $b['unixtime'];
        });

        return $array;

    }

    /**
     * Fill attributes and object DateTime
     */
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