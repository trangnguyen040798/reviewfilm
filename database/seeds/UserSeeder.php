<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'linhXuka',
            'hoaNtt',
            'Quynhkk',
            'minhnguyen'
        ];
        $artists = [
            'Joo Dong Min',
            'Lee Ji Ah',
            'Eugene',
            'Trấn Thành'
        ];
    	DB::table('users')->insert([
            'name' => 'Trang Nguyen',
            'email' => 'trangntt040798@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);
    	for ($i = 0; $i < 4; $i++) {
    		DB::table('users')->insert([
	            'name' => $names[$i],
	            'email' => $names[$i] . '@gmail.com',
	            'password' => Hash::make('password'),
	            'role' => 'customer'
	        ]);
    	}
    	for ($i = 0; $i < 4; $i++) {
    		DB::table('artists')->insert([
	            'name' => $artists[$i],
	            'occupation' => 1,
	            'country_id' => rand(1, 8),
	        ]);
    	}
        for ($i = 0; $i < 4; $i++) {
            DB::table('artists')->insert([
                'name' => $artists[$i],
                'occupation' => 2,
                'country_id' => rand(1, 8),
            ]);
        }
    }
}
