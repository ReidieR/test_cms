<?php

use Illuminate\Database\Seeder;

class Final_usersTableSeeder extends Seeder
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
        for ($i=0;$i<100;$i++) {
            $data[] = [
                'username' => $faker -> userName,
                'password' => bcrypt('123456'),
                'email' => $faker -> email,
                'mobile' => $faker -> phoneNumber,
                'status' => rand(1, 2),
                'gender' => rand(1, 3),
                'created_at' => time(),
            ];
        }
        // 写入数据
        DB::table('final_users')->insert($data);
    }
}
