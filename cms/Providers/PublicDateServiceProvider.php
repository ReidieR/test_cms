<?php

namespace cms\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use DB;
use Auth;

class PublicDateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // 导航栏数据共享
        $data = $this->getTreeNav();
        view()->share('nav', $data);
        // 热门文章数据共享
        $article = $this->hotArticle();
        view()->share('hotArticle', $article);
        // 友情链接共享
        $links = $this->link();
        view()->share('link', $links);
    }
    // 导航栏数据获取
    public function getTreeNav()
    {
        $items = DB::table('final_article_category')->cates('art_cate_id');
        $res = [];
        foreach ($items as $val) {
            if ($val['art_cate_pid']) {
                $items[$val['art_cate_pid']]['children'][] = &$items[$val['art_cate_id']];
            } else {
                $res[] = &$items[$val['art_cate_id']];
            }
        }
        
        return $res;
    }

    // 热门文章数据获取
    public function hotArticle()
    {
        $time = time()-30*24*60*60;
        $article = DB::table('final_article')->where('created_at', '>', $time)->orderBy('read_num', 'desc')->limit(10)->lists();
        return $article;
    }

    // 友情链接
    public function link()
    {
        return DB::table('final_links')->limit(7)->lists();
    }
}
