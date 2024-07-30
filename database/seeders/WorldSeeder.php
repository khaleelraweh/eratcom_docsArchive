<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use mysqli;

class WorldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // نحدد اسم الملف الذي نريد اخذ البيانات منه والموجود في المجلد بابلك 
        $sql_file = public_path('worlds.sql');




        // نحدد بيانات قاعدة البيانات تبعنا
        $db = [
            'host'  => '127.0.0.1',
            'database'  => 'adelProject',
            'username'  => 'root',
            'password'  => null,
        ];

        // Notes : database in bluehost will be like this 
        //             'database'  => '            'database'  => 'instatute',
        // نعطي له اوامر الشيل من اجل التنفيذ
        exec("mysql --user={$db['username']} --password={$db['password']} --host={$db['host']} --database={$db['database']} < $sql_file");
    }
}
