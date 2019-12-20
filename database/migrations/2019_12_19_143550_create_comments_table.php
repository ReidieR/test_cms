<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('final_comments', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->string('comments')->notNull()->default('')->comment('评论内容');
            $table->integer('article_id')->notNull()->unsigned()->deafult(1)->comment('评论文章ID');
            $table->integer('user_id')->notNull()->unsigned()->deafult(1)->comment('评论人ID');
            $table->integer('created_at')->notNull()->unsigned()->deafult(1)->comment('创建时间');
            $table->integer('updated_at')->notNull()->unsigned()->deafult(1)->comment('更新时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('final_comments');
    }
}
