<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConllectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('final_conllections', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->string('conllect_article')->notNUll()->default('')->comment('收藏的文章id集合');
            $table->integer('user_id')->notNull()->unsigned()->unique()->deafult(1)->comment('用户id');
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
        Schema::dropIfExists('final_conllections');
    }
}
