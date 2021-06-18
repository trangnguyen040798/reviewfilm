<?php

use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['Việt Nam', 'Thái Lan', 'Hàn Quốc', 'Ấn Độ', 'Trung Quốc', 'Nhật Bản', 'Mỹ', 'Hồng Kông', 'Đài Loan'];
        for ($i = 0; $i < count($names); $i++) {
            DB::table('countries')->insert([
                'title' => $names[$i],
                'slug' => Str::slug($names[$i], '-'),
            ]);
        }
    }
}
