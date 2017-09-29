<?php
/**
 * Copyright (C) $user$, Inc - All Rights Reserved
 *
 *  <other text>
 * @file        CustomDateTest.php
 * @author      ignatenkovnikita
 * @date        $date$
 */

use ignatenkovnikita\helpers\CustomDate;

/**
 * Created by PhpStorm.
 * User: ignatenkovnikita
 * Web Site: http://IgnatenkovNikita.ru
 */
class CustomDateTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider createProvider
     */
    public function testCreate($string)
    {
        $customDate = new CustomDate($string);
        $this->assertEquals($string, $customDate->getFormatted());
    }


    public function createProvider()
    {
        return [
            ['01:00:05 21.07.2017' => '01:00:05 21.07.2017'],
            ['01:05 21.07.2017' => '01:05:00 21.07.2017'],
            ['01: 21.07.2017' => '01:00:00 21.07.2017'],
            ['21.07.2017' => '00:00:00 21.07.2017'],
//            ['07.2017' => '00:00:00 00.07.2017'],
//            ['2017' => '00:00:00 00.00.2017'],
            ['01:' => '01:00:00 30.11.0000'],
            ['01:05' => '01:05:00 30.11.0000'],
            ['01:05:17' => '01:05:17 30.11.0000']
        ];
    }


    public function testCompare()
    {
        $array = [
            ['id' => 4, 'string' => '21.07.2017'],
            ['id' => 2, 'string' => '01:05 21.07.2017'],
            ['id' => 3, 'string' => '01 21.07.2017'],
            ['id' => 1, 'string' => '01:05:17'],
        ];
        $allowArray = [1, 4, 3, 2];


        $sortArray = CustomDate::sortDate($array);

        foreach ($sortArray as $index => $item) {
            $this->assertEquals($item['id'], $allowArray[$index]);
        }
    }

}