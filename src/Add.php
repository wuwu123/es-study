<?php
/**
 * Created by PhpStorm.
 * User: wujie
 * Date: 2019-03-21
 * Time: 16:18
 */

namespace Study;


use Study\connect\Client;

class Add extends BaseClass
{

    public function addContent()
    {
        $id = 2;
        $params = [
            'id' => $id,
            'type' => $this->type,
            'index' => $this->index,
            'body' => [
                'id' => $id,
                "title" => "我是武杰",
                "tip" => "哈哈哈武杰",
                "other" => "jsjsjjs哈哈哈定时说说就开始就睡觉武神杰"
            ]
        ];
        $return = Client::make()->create($params);
        print_r($return);
    }

    public function getContent()
    {
        $params = [
            'id' => 2,
            'type' => $this->type,
            'index' => $this->index,
        ];
        $return = Client::make()->get($params);
        print_r($return);
    }

    public function delContent()
    {
        $params = [
            'id' => 1,
            'type' => $this->type,
            'index' => $this->index,
        ];
        $return = Client::make()->delete($params);
        print_r($return);
    }


    public function update()
    {
        $id = 3;
        $params = [
            'id' => $id,
            'type' => $this->type,
            'index' => $this->index,
            'body' => [
                'doc' => [
                    'id' => $id,
                    "title" => "我是武杰11",
                    "tip" => "哈哈哈武杰111",
                    "other" => "jsjsjjs哈哈哈定时说1111说就开始就睡觉武神杰"
                ],
                'doc_as_upsert' => true,//当文件不存在的时候直接创建
            ],
            'refresh'=>true,//当执行操作自动刷新索引
            'retry_on_conflict'=>3//当发生文件冲突的时候重试次数
        ];
        $return = Client::make()->update($params);
        print_r($return);
    }

}