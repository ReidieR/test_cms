<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatedFinalAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //创建表
        Schema::create('final_admins', function (Blueprint $table) {
            // 设计字段
            $table->increments('id');       // 主键
            $table->string('username', 20)->notNull()->comment('用户名');     // 用户名
            $table->string('password')->notNull()->comment('密码');      // 密码
            $table->tinyInteger('group_id')->notNull()->comment('角色分组id');      // 角色分组
            $table->string('email', 50)->notNull()->comment('邮箱');      // 邮箱
            $table->string('mobile', 11)->notNull()->comment('电话');     // 电话
            $table->enum('status', [1,2])->notNull()->default(1)->comment('用户状态 1表示正常,2表示禁用');    // 用户状态 1表示正常,2表示禁用
            $table->string('login_lastip')->notNull()->comment('最后登录ip');   // 最后登录ip
            $table->string('login_lasttime')->notNull()->default(0)->comment('最后登录时间');    // 最后登录时间
            $table->rememberToken();
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
        //删除表
        Schema::dropIfExists('final_admins');
    }
}
