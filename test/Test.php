<?php
/**
 * Created by PhpStorm.
 * User: wujie
 * Date: 2019-03-21
 * Time: 11:19
 */

class Test
{
    public function __construct()
    {
        require_once __DIR__ . '/../vendor/autoload.php';
    }

    public function createIndex()
    {
        \Study\Map::make()->createIndex();
    }

    public function getIndex()
    {
        \Study\Map::make()->getIndex();
    }

    public function delIndex()
    {
        \Study\Map::make()->delIndex();
    }


    public function putMap()
    {
        \Study\Map::make()->putMap();
    }

    public function updateMap()
    {
        \Study\Map::make()->updateMap();
    }

    public function getMap()
    {
        \Study\Map::make()->getMap();
    }

}

$testModel = new Test();
// $testModel->getMap();
// $testModel->getMap();

class AddTest
{
    public function __construct()
    {
        require_once __DIR__ . '/../vendor/autoload.php';
    }

    public function add()
    {
        \Study\Add::make()->addContent();
    }

    public function get()
    {
        \Study\Add::make()->getContent();
    }

    public function del()
    {
        \Study\Add::make()->delContent();
    }

    public function update()
    {
        \Study\Add::make()->update();
    }
}

$assModel = new AddTest();
// $assModel->update();
// $assModel->del();
$assModel->get();