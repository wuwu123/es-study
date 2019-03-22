<?php
/**
 * Created by PhpStorm.
 * User: wujie
 * Date: 2019-03-21
 * Time: 10:46
 */

namespace Study\connect;


use Elasticsearch\ClientBuilder;

class Client
{
    private static $client;

    private function __construct()
    {
    }

    public static function make()
    {
        if (!self::$client) {
            self::$client = ClientBuilder::create()->setHosts(['http://127.0.0.1:9200'])->build();
        }
        return self::$client;
    }

}