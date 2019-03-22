<?php
/**
 * Created by PhpStorm.
 * User: wujie
 * Date: 2019-03-21
 * Time: 17:24
 */

namespace Study;


use Study\connect\Client;

class Select extends BaseClass
{

    public function query()
    {
        $params = [
            'index' => $this->index,
            "type" => $this->type,
            'body' => [

            ]
        ];
        $return = Client::make()->search($params);
        print_r($return);
    }

}