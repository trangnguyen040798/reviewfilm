<?php

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
        $this->call(UserSeeder::class);
        $this->call(FilmSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(NewsSeeder::class);
    }
}
