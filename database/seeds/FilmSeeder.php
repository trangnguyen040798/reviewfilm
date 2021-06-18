<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
        	"Người hùng",
        	'Người tình ánh trăng',
        	'Cuộc chiến thượng lưu',
        	'Tuổi trẻ của chúng ta',
        	'Kẻ giết người',
        	'Tìm lại chính mình',
        	'Hồ ly',
        	'Bố Già',
        	'Về nhà đi con',
        	'Bộ bộ kinh tâm'
        ];
        $othernames = [
        	"X-Men",
        	'Người tình ánh trăng',
        	'PentHouse',
        	'Tuổi trẻ của chúng ta',
        	'Mouse',
        	'Kill me hill me',
        	'Hồ ly',
        	'The God Father',
        	'Về nhà đi con',
        	'Bộ bộ kinh tâm'
        ];
    	for ($i = 0; $i < 10; $i++) {
	        DB::table('films')->insert([
	            'name' => $names[$i],
	            'othername' => $othernames[$i],
	            'image' => 'none',
	            'year' => 2020,
	            'type' => rand(1, 2),
	            'country_id' => rand(1, 8),
	            'complete' => 0,
	            'user_id' => rand(1, 5),
	            'status' => 1,
	            'total_episodes' => rand(1, 16),
	            'description' => 'Tarzan, having acclimated to life in London, is called back to his former home in the jungle to investigate the activities at a mining encampment'
	        ]);
	    }
        DB::table('category_films')->insert([
            'category_id' => rand(1, 14),
            'film_id' => 1
        ]);
        DB::table('category_films')->insert([
            'category_id' => rand(1, 14),
            'film_id' => 2
        ]);
        DB::table('category_films')->insert([
            'category_id' => rand(1, 14),
            'film_id' => 3
        ]);
        DB::table('category_films')->insert([
            'category_id' => rand(1, 14),
            'film_id' => 4
        ]);
        DB::table('category_films')->insert([
            'category_id' => rand(1, 14),
            'film_id' => 5
        ]);
        DB::table('category_films')->insert([
            'category_id' => rand(1, 14),
            'film_id' => 6
        ]);
        DB::table('category_films')->insert([
            'category_id' => rand(1, 14),
            'film_id' => 7
        ]);
        DB::table('category_films')->insert([
            'category_id' => rand(1, 14),
            'film_id' => 8
        ]);
        DB::table('category_films')->insert([
            'category_id' => rand(1, 14),
            'film_id' => 9
        ]);
        DB::table('category_films')->insert([
            'category_id' => rand(1, 14),
            'film_id' => 10
        ]);
	    for ($i = 0; $i < 10; $i++) {
	        DB::table('artist_films')->insert([
	            'artist_id' => rand(1, 4),
	            'film_id' => $i
	        ]);
	    }
    }
}
