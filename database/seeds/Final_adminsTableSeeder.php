<?php

use Illuminate\Database\Seeder;

class Final_adminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 生成种子文件
        $faker = \Faker\Factory::create('zh_CN');
        $data = [];
        for ($i=0;$i<50;$i++) {
            $data[]=[
                'username' => $faker -> userName,
                'password' => bcrypt('123456'),
                'group_id' => rand(1, 10),
                'email' => $faker -> email,
                'mobile' => $faker -> phoneNumber,
                'status' => rand(1, 2),
                'created_at' => time(),
                ];
        }
        // 写入数据表中
        DB::table('final_admins')->insert($data);
    }
}
