<?php
/**
 * Copyright (C) $user$, Inc - All Rights Reserved
 *
 *  <other text>
 * @file        AbstractFormat.php
 * @author      ignatenkovnikita
 * @date        $date$
 */

/**
 * Created by PhpStorm.
 * User: ignatenkovnikita
 * Web Site: http://IgnatenkovNikita.ru
 */

namespace ignatenkovnikita\helpers;


/**
 * Class AbstractFormat
 * @package ignatenkovnikita\helpers
 */
class AbstractFormat
{

    /**
     * @var string
     */
    public $raw;

    /**
     * @var \DateTime
     */
    protected $_dateTime;

    /**
     * AbstractFormat constructor.
     */
    public function __construct()
    {
        $this->_dateTime = new \DateTime();
    }


}