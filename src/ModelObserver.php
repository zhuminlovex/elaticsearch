<?php

namespace Haode\Elaticsearch;

class ModelObserver
{
    /**
     * 处理 「新建」事件
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created($model)
    {
       $model->upserts();
    }

    /**
     * 处理 「更新」事件
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated($model)
    {
        $model->upserts();
    }

    /**
     * 处理 「删除」事件
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted($model)
    {
        $model->upserts();
    }

}
