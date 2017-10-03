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
        $formated = $customDate->getFormatted();
        $this->assertEquals($string, $formated);
    }


    public function createProvider()
    {
        return [
            ['01:00:05 21.07.2017'],
            ['01:05 21.07.2017'],
            ['01: 21.07.2017'],
            ['21.07.2017'],
            ['07.2017'],
            ['2017'],
            ['01:'],
            ['01:05'],
            ['01:05:17']
        ];
    }


    public function testSortAsc()
    {
        $array = [
            ['id' => 4, 'string' => '01: 21.07.2017'],
            ['id' => 2, 'string' => '01:05 21.07.2017'],
            ['id' => 3, 'string' => '01 21.07.2017'],
            ['id' => 1, 'string' => '01:05:17'],
        ];
        $allowArray = [1, 3, 4, 2];

        $sortArray = CustomDate::sortDate($array);

        foreach ($sortArray as $index => $item) {
            $this->assertEquals($item['id'], $allowArray[$index]);
        }
    }

    public function testSortDesc()
    {
        $array = [
            ['id' => 4, 'string' => '01: 21.07.2017'],
            ['id' => 2, 'string' => '01:05 21.07.2017'],
            ['id' => 3, 'string' => '01 21.07.2017'],
            ['id' => 1, 'string' => '01:05:17'],
        ];
        $allowArray = [2, 4, 3, 1];

        $sortArray = CustomDate::sortDate($array, CustomDate::SORT_DESC);

        foreach ($sortArray as $index => $item) {
            $this->assertEquals($item['id'], $allowArray[$index]);
        }
    }

}