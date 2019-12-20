<?php

namespace cms\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Query\Builder as QueryBuilder;

class DbServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // 扩展分页方法
        QueryBuilder::macro('page', function ($index, $appends=[]) {
            $pageObj = $this->paginate($index);
            $results = [];
            $article = $pageObj->items();
            foreach ($article as $page) {
                $results[] = (array)$page;
            }
            $data['result'] = $results;
            $data['total'] = $pageObj->total();
            if ($appends) {
                $data['links'] = $pageObj->appends($appends)->links();
            }
            $data['links'] = $pageObj->links();
            // echo '<pre>';
            // print_r($data);
            // exit;
            return $data;
        });

        // 扩展单个查询结果
        QueryBuilder::macro('item', function () {
            $res = $this->first();
            return $res ? (array)$res : false;
        });

        //扩展数组方法
        QueryBuilder::macro('lists', function () {
            $res = $this->get()->toArray();
            foreach ($res as $key => $val) {
                $res[$key] = (array)$val;
            }
            return $res;
        });

        // 扩展列表方法
        QueryBuilder::macro('cates', function ($index) {
            $res = $this->lists();
            $group=[];
            foreach ($res as $value) {
                $group[$value[$index]] = (array)$value;
            }
            return $group;
        });
    }
}
