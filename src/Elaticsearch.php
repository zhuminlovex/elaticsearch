<?php

namespace Haode\Elaticsearch;

use Elasticsearch\ClientBuilder;

class Elaticsearch
{
    // Build wonderful things
    private $client;

    public function __construct()
    {
        $params = array(
            config('elaticsearch.host').':'.config('elaticsearch.port')
        );
        $this->client = ClientBuilder::create()->setHosts($params)->build();
    }

    /**
     * 创建索引
     * @param $model
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createIndex($model)
    {
        $params = [
            'index' => $model->searchableIndex(),
            'body' => [
                'settings' => [
                    'number_of_shards' => 1,
                    'number_of_replicas' => 0,
                    'analysis' => [
                        'filter' => [
                            'word_sync' => [
                                'type' => 'synonym',
                                'synonyms_path' => 'analysis/synonym.txt'
                            ]
                        ],
                        'analyzer' => [
                            'ik_sync_smart' => [
                                'filter' => [
                                    'word_sync'
                                ],
                                'type' => 'custom',
                                "tokenizer" => "ik_smart"
                            ]
                        ]
                    ]
                ],

                'mappings' => [
                    '_source' => [
                        'enabled' => true
                    ],
                    'properties' => $model->toSearchableArray()
                ]
            ]
        ];
        $this->client->indices()->create($params);

    }

    /**
     * 判断索引是否存在
     * @param $model
     * @return bool
     */
    public function exists($model)
    {
        $params = ['index' => $model->searchableIndex()];

        $response = $this->client->indices()->exists($params);

        return $response;
    }

    public function upserts($model)
    {
        $data = [];
        $str = '';
        foreach ($model->toSearchableArray() as $key => $value){
            $data[$key] =  $model->$key ?? '';
            $str .= 'ctx._source.' .$key .'+=' .'params.'.$key .';';
        }

        $params = [
            'index' => $model->searchableIndex(),
            'type' => $model->searchableType(),
            'id' => $model->id,
            'body'  => [
                'script' => [
                    'source' => $str,
                    'params' => $data,
                ],
                'upsert' => $data,
            ]
        ];
        $response = $this->client->update($params);
        return $response;
    }

    public function get($model, $array, $should, $options = [])
    {
        if (!is_object($model) && class_exists($model))
        {
            $model = new $model();
        }else{
            return false;
        }
        $data = $or = [];

        foreach ($array as $key => $value){
            $data[] =  [ 'match_phrase' => [ $key =>$value ] ];
        }

        foreach ($should as $key => $value){
            $or[] =  [ 'match_phrase' => [ $key =>$value ] ];
        }


        $params = [
            'index' => $model->searchableIndex(),
            'body'  => [
                'query' => [
                    'bool' => [
                        'must' => $data,
                        'should' => $or
                    ]
                ]
            ]
        ];

        if (isset($options['sort'])) {
            $params['body']['sort'] = $options['sort'];
        }

        if (isset($options['from'])) {
            $params['body']['from'] = $options['from'];
        }

        if (isset($options['size'])) {
            $params['body']['size'] = $options['size'];
        }

        $results = $this->search($params);

        return $results;
    }


    public function search($params)
    {
        $results = $this->client->search($params);

        return $results;
    }

    public function delete($model)
    {
        $params = [
            'index' => $model->searchableIndex(),
            'id'    => $model->id
        ];

        return $this->client->delete($params);
    }
}
