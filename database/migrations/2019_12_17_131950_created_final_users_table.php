<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatedFinalUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 创建表
        Schema::create('final_users', function (Blueprint $table) {
            // 字段设置
            $table->increments('user_id');       // 主键
            $table->string('username', 20)->notNull()->default('')->comment('用户名');     // 用户名
            $table->string('password')->notNull()->default('')->comment('密码');      // 密码
            $table->string('email', 50)->notNull()->default('')->comment('邮箱');      // 邮箱
            $table->string('mobile', 11)->notNull()->default('')->comment('电话');     // 电话
            $table->tinyInteger('status')->notNull()->default(1)->comment('用户状态 1表示正常,2表示禁用');    // 用户状态 1表示正常,2表示禁用
            $table->tinyInteger('gender')->notNull()->default(1)->comment('用户性别 1表示男,2表示女,3表示隐藏');    // 用户状态 1表示正常,2表示禁用
            $table->string('login_lastip', 255)->notNull()->default('')->comment('最后登录ip');   // 最后登录ip
            $table->integer('login_lasttime')->unsigned()->notNull()->deafult(0)->comment('最后登录时间');    // 最后登录时间
            $table->rememberToken()->defalut('')->comment('是否记住登录状态');
            $table->integer('created_at')->notNull()->unsigned()->deafult(0)->comment('创建时间');
            $table->integer('updated_at')->notNull()->unsigned()->deafult(0)->comment('更新时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 删除表
        Schema::dropIfExists('final_users');
    }
}
