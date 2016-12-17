<?php

namespace LegionLab\Rest\Persistence;

/**
 * Created by PhpStorm.
 * User: leonardo
 * Date: 06/08/16
 * Time: 14:50
 */
class DefaultModel extends Object
{
    public function __construct($table = null, $pk = null)
    {
        parent::__construct($table, $pk);
    }

}
