<?php

use Illuminate\Database\Seeder;
use App\Models\Users;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $u = new Users();
        $u->nama = 'samin';
        $u->email = 'samin@gmail.com';
        $u->username = 'samin';
        $u->password = bcrypt('123456');
        $u->status = 'direktur';
        $u->save();
    }
}
