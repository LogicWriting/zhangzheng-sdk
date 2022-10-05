<?php

use Elastic\Elasticsearch\ClientBuilder;

/**
 * 作者：本
 * 创建时间：2022/10/6 03:30
 * 格言：如果你是这个房间中最聪明的，那么你走错房间了
 */
class Es
{
    public function Essearch($indexName, $field = '', $queryVal = '')
    {
        $hosts = [
            '127.0.0.1:9200',
        ];
        $client = ClientBuilder::create()->setHosts($hosts)->build();
        $params = [
            'index' => $indexName,
            'type' => '_doc',
            'body' => [
                'query' => [
                    'match' => [
                        $field => [
                            'query' => $queryVal
                        ]
                    ]
                ], 'highlight' => [
                    'pre_tags' => [""],
                    'post_tags' => [''],
                    'fields' => [
                        'fang_name' => new \stdClass()
                    ]
                ]
            ]
        ];
        $results = $client->search($params);
        return $results;
    }

    public function Add()
    {
        $hosts = [
            '127.0.0.1:9200',
        ];
        $client = ClientBuilder::create()->setHosts($hosts)->build();
        // 写文档
        $params = [
            'index' => 'goods',
            'type' => '_doc',
            'id' => $result->id,
            'body' => [
                'title' => $result->title,
                'desn' => $model->desn,
            ],
        ];
        $response = $client->index($params);
    }

    public function init()
    {
//        创建索引
$hosts = [
    '127.0.0.1:9200'
];
$client = ClientBuilder::create()->setHosts($hosts)->build();

// 创建索引
$params = [
    'index' => 'goods',
    'body' => [
        'settings' => [
            'number_of_shards' => 5,
            'number_of_replicas' => 1
        ],
        'mappings' => [
            '_doc' => [
                '_source' => [
                    'enabled' => true
                ],
                'properties' => [
                    'title' => [
                        'type' => 'keyword'
                    ],
                    'desn' => [
                        'type' => 'text',
                        'analyzer' => 'ik_max_word',
                        'search_analyzer' => 'ik_max_word'
                    ]
                ]
            ]
        ]
    ]
];
$response = $client->indices()->create($params);
    }
}