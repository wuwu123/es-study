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
    public function defaultParams()
    {
        return [
            'index' => $this->index,
            "type" => $this->type,
            '_source' => [//查询返回的字段
                "id"
            ],
            'from' => 0,
            'size' => 10,
        ];
    }

    /**
     * term 代表完全匹配，不进行分词器分析
     */
    public function term()
    {
        $params = [
            'index' => $this->index,
            "type" => $this->type,
            'body' => [
                'query' => [
                    'term' => ["title" => "武杰"]
                ]
            ]
        ];
        $return = Client::make()->search($params);
        print_r($return);
    }

    /**
     * match 会对查询的进行分词查询
     */
    public function match()
    {
        $params = [
            'index' => $this->index,
            "type" => $this->type,
            'from' => 1,
            'size' => 1,
            'body' => [
                'query' => [
                    'match' => ["title" => "武杰"],
                    'multi_match' => [//同事匹配多个字段
                        "query" => "guide",
                        "fields" => ["tip", "other", "_all"]
                    ]
                ]
            ]
        ];
        $return = Client::make()->search($params);
        print_r($return);
    }


    /**
     * 对查询的结果高亮匹配
     */
    public function highlight()
    {
        $params = array_merge($this->defaultParams(), [
            'body' => [
                'query' => [
                    'term' => ["tip" => "哈哈哈武杰"]
                ],
                'highlight' => [
                    "pre_tags" => ["<b>"],//设置分歌词标签
                    "post_tags" => ["</b>"],
                    'fields' => [
                        'tip' => (object)[],
                    ],
                ]
            ]
        ]);
        $return = Client::make()->search($params);
        print_r($return);
    }

    /**
     * 多匹配查询
     * tie_breaker
     *      取得最佳匹配查询子句的_score。
     *      将其它每个匹配的子句的分值乘以tie_breaker。
     *      将以上得到的分值进行累加并规范化。
     */
    public function matchs()
    {
        $params = array_merge($this->defaultParams(), [
            'body' => [
                'query' => [
                    'dis_max' => [
                        'tie_breaker' => 0.3,//
                        'queries' => [
                            [
                                'multi_match' => [
                                    'query' => "武杰",
                                    'type' => 'phrase',//是否字段查询
                                    'fields' => ['title', 'tip^0.01', 'other^0.0001'],
                                    'slop' => 0,//步长 相隔多少个单词查询
                                ]
                            ]
                        ],
                    ]
                ],
                'highlight' => [
                    "pre_tags" => ["<b>"],//设置分歌词标签
                    "post_tags" => ["</b>"],
                    'fields' => [
                        'tip' => (object)[],
                    ],
                ]
            ]
        ]);
        $return = Client::make()->search($params);
        print_r($return);
    }

    /**
     * 并联查询
     */
    public function bool()
    {
        $params = array_merge($this->defaultParams(), [
            'body' => [
                'query' => [
                    'bool' => [
                        "should" => [ // 等同于or
                            ["match" => ['title' => "4444"]],
                            ["match" => ['other' => "武杰"]]
                        ],
                        'must_not' => [// mot
                            'term' => ["id" => 2]
                        ],
                        "must" => [ // and
                            "range" => ["id" => ["gte" => 1]]// gte 大于等于查询  lte 小于等于
                        ]
                    ]
                ]
            ]
        ]);
        $return = Client::make()->search($params);
        print_r($return);
    }

    /**
     * 过滤查询  filtered 再5.0之后已经丢失
     * 过滤只在第一次运行，以减少所需的查询面积，并且，在第一次使用后过滤会被缓存，大大提高了性能
     */
    public function filter()
    {
        $params = array_merge($this->defaultParams(), [
            'body' => [
                'query' => [
                    'bool' => [
                        "should" => [ // 等同于or
                            ["match" => ['title' => "4444"]],
                            ["match" => ['other' => "武杰"]]
                        ],
                        "filter" => [
                            "range" => ["id" => ["gte" => 0]]// gte 大于等于查询  lte 小于等于
                        ]
                    ]
                ]
            ]
        ]);
        $return = Client::make()->search($params);
        print_r($return);
    }

    /**
     * 每个查询结果分值一样 , 字段匹配的结果都为1
     */
    public function scoreLine()
    {
        $params = array_merge($this->defaultParams(), [
            'body' => [
                'query' => [
                    'bool' => [
                        "should" => [ // 等同于or
                            [
                                'constant_score' => [
                                    'query' => ['match' => ['title' => "44444"]]
                                ]
                            ],
                            [
                                'constant_score' => [
                                    'query' => ['other' => ['title' => "44444"]]
                                ]
                            ]
                        ],
                        "filter" => [
                            "range" => ["id" => ["gte" => 0]]// gte 大于等于查询  lte 小于等于
                        ]
                    ]
                ]
            ]
        ]);
        $return = Client::make()->search($params);
        print_r($return);
    }

}