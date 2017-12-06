<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Proyek::class, 5)->create();
        $this->call(UserSeeder::class);
        $this->call(PeoyekJalan::class);
    }
}
