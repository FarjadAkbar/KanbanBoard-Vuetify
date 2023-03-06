<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;
use App\Models\User;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::insert(
            ['name'=>'Admin','email'=>'admin@gmail.com', 'password' => bcrypt('12345678')],
        );

        Status::insert([[
            'title' => 'Todo',
            'slug' => 'todo',
            'order' => '1',
            'user_id' => '1',
        ], [
            'title' => 'InProgress',
            'slug' => 'inprogress',
            'order' => '2',
            'user_id' => '1',
        ], [
            'title' => 'Complete',
            'slug' => 'complete',
            'order' => '3',
            'user_id' => '1',
        ]]);
    }
}
