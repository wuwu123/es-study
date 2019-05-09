<?php
/**
 * Created by PhpStorm.
 * User: wujie
 * Date: 2019-03-21
 * Time: 10:53
 */

namespace Study;

use Study\connect\Client;

class Map extends BaseClass
{
    public function createIndex()
    {
        $params = [
            'index' => $this->index
        ];
        $returnBool = Client::make()->indices()->exists($params);
        if ($returnBool) {
            echo "index已存在" . PHP_EOL;
            return;
        }
        $return = Client::make()->indices()->create($params);
        print_r($return);
    }

    public function getIndex()
    {
        $params = [
            'index' => $this->index
        ];
        $returnBool = Client::make()->indices()->exists($params);
        if (!$returnBool) {
            echo "index不存在" . PHP_EOL;
            return;
        }
        $return = Client::make()->indices()->get($params);
        print_r($return);
    }

    public function delIndex()
    {
        $params = [
            'index' => $this->index
        ];
        $return = Client::make()->indices()->delete($params);
        print_r($return);
    }

    public function putMap()
    {
        $this->createIndex();
        $params = [
            'index' => $this->index,
            'type' => $this->type,
            'body' => [
                'properties' => [
                    'id' => [
                        'type' => 'integer'
                    ],
                    'title' => [
                        'type' => 'text' //被分析器分成一个一个词项
                    ],
                    'tip' => [
                        'type' => 'keyword'//不会被分词 排序、聚合
                    ]
                ]
            ]
        ];
        $return = Client::make()->indices()->putMapping($params);
        var_dump($return);
    }


    public function getMap()
    {
        $params = [
            'index' => $this->index,
            'type' => $this->type
        ];
        $return = Client::make()->indices()->getMapping($params);
        var_dump($return);
    }


    /**
     * 已存在的字段修改类型需要重新创建索引，不好修改
     */
    public function updateMap()
    {
        $params = [
            'index' => $this->index,
            'type' => $this->type,
            'body' => [
                'properties' => [
                    'id' => [
                        'type' => 'integer'
                    ],
                    'title' => [
                        'type' => 'text' //被分析器分成一个一个词项
                    ],
                    'tip' => [
                        'type' => 'keyword'//不会被分词 排序、聚合
                    ],
                    'other' => [
                        'type' => 'text',
                        // 'analyzer' => 'ik_max_word',
                        // 'search_analyzer' => 'ik_max_word'
                    ]
                ]
            ]
        ];
        $return = Client::make()->indices()->putMapping($params);
        var_dump($return);
    }
}
