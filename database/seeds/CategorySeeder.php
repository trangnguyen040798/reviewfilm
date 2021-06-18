<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$films = ['Tội Phạm', 'Lịch Sử', 'Chiến Tranh', 'Khoa Học Viễn Tưởng', 'Hành Động', 'Phiêu Lưu', 'Hài', 'Kinh Dị', 'Kiếm Hiệp', 'Cổ Trang', 'Chính Kịch', 'Lãng Mạn', 'Hoạt Hình', 'Gia Đình', 'Ca Nhạc'];
    	$news = ['Diễn Viên'];
    	for ($i = 0; $i < count($films); $i++) {
	        DB::table('categories')->insert([
	            'title' => $films[$i],
	            'slug' => Str::slug($films[$i], '-'),
	            'type' => 'film'
	        ]);
	    }
    	for ($i = 0; $i < count($news); $i++) {
    		DB::table('categories')->insert([
	            'title' => $news[$i],
	            'slug' => Str::slug($news[$i], '-'),
	            'type' => 'news'
	        ]);
    	}
    }
}
