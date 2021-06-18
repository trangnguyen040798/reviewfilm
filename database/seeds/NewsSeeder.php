<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i = 1; $i <= 4; $i++) {
        	$title = 'This provides a great advantage over traditional static methods';
            DB::table('news')->insert([
                "title" => $title,
                "slug" => Str::slug($title, '-'),
                "image" => "ahuhu",
                "category_id" => 16,
                "content" => $faker->paragraph
            ]);
        }
    }
}
