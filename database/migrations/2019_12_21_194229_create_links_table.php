<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('final_links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->notNull()->default('')->comment('链接名称');
            $table->string('url')->notNull()->default('')->comment('链接地址');
            $table->tinyInteger('status')->notNull()->default(1)->comment('链接状态');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('final_links');
    }
}
