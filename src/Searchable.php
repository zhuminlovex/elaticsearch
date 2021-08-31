<?php

namespace Haode\Elaticsearch;


trait Searchable
{
    private $elatic;

    public static function bootSearchable()
    {
        static::observe(new ModelObserver);
    }

    /**
     * 查询结果
     * @param $array
     * @return Search
     */
    public static function search($array)
    {
        $class = self::class;
        $model = new $class();

        $data = [];

        foreach ($array as $key => $value) {
            $data[] = ['match' => [$key => $value]];
        }

        $params = [
            'index' => $model->searchableIndex(),
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => $data,
                        'should' =>[]
                    ]
                ]
            ]
        ];

        $model->elatic = $params;

        return $model;
    }

    /**
     * 或查询
     * @param $array
     */
    public function orSearch($array)
    {
        foreach ($array as $key => $value) {
            $this->elatic['body']['query']['bool']['should'][] = ['match' => [$key => $value]];
        }

        return $this;
    }

    /**
     * 排序
     * @param $sort
     * @param $order
     */
    public function order($sort, $order)
    {

        $this->elatic['body']['sort'][] = [
            $sort => [
                'order' => $order,
            ]
        ];
        return $this;
    }

    /**
     * 查询条数
     * @param $size
     */
    public function size($size)
    {
        $this->elatic['body']['size'] = $size;
        return $this;
    }

    /**
     * 页码
     * @param $from
     */
    public function page($from)
    {
        $from = $from - 1;
        $this->elatic['body']['from'] = $from;
        return $this;
    }

    /**
     * 查询结果
     * @return \Illuminate\Support\Collection
     */
    public function inquire()
    {
        $elaticsearch = new Elaticsearch();
        $results = $elaticsearch->search($this->elatic);
        $data = [];

        foreach ($results['hits']['hits'] as $result) {
            $object = (object)[];
            foreach ($result['_source'] as $key => $source) {
                $object->$key = $source;
            }
            $object->id = $result['_id'];
            $data[] = $object;
        }
        return collect($data);
    }

    public function elaticDelete()
    {
        $elatic = new Elaticsearch();

        return $elatic->delete($this);
    }

    public function upserts()
    {
        $elatic = new Elaticsearch();

        return $elatic->upserts($this);
    }
}
