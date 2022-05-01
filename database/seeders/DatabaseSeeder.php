<?php

namespace Database\Seeders;

use App\Models\collecteur;
use App\Models\contribuable;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        contribuable::factory(100)->create();
        // $this->call(UserTableSeeder::class);

        // collecteur::factory(10)->create();

    }
}
