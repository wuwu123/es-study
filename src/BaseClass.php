<?php
/**
 * Created by PhpStorm.
 * User: wujie
 * Date: 2019-03-21
 * Time: 10:55
 */

namespace Study;


class BaseClass
{
    protected $index = "wujie";

    protected $type = "wujie";

    protected $id = "id";

    public static function make()
    {
        return new static();
    }

}