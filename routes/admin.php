<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/dashboard', function() {
	return view('admin.dashboard');
})->name('dashboard');
Route::prefix('/user')->name('user.')->group(function() {
	$userController = 'Admin\UserController@';

	Route::get('/', $userController . 'index')->name('index');
	Route::post('/', $userController . 'create')->name('create');
	Route::post('/delete/{id}', $userController . 'delete')->name('delete');
	Route::get('/detail/{id}', $userController . 'detail')->name('detail');
	Route::post('/update', $userController . 'update')->name('update');
	Route::post('/multi-delete', $userController . 'multiDelete')->name('multi-delete');
});

Route::prefix('/artist')->name('artist.')->group(function() {
	$artistController = 'Admin\ArtistController@';

	Route::get('/', $artistController . 'index')->name('index');
	Route::post('/', $artistController . 'create')->name('create');
	Route::post('/delete/{id}', $artistController . 'delete')->name('delete');
	Route::get('/detail/{id}', $artistController . 'detail')->name('detail');
	Route::post('/update', $artistController . 'update')->name('update');
	Route::post('/multi-delete', $artistController . 'multiDelete')->name('multi-delete');
});

Route::prefix('/country')->name('country.')->group(function() {
	$countryController = 'Admin\CountryController@';

	Route::get('/', $countryController . 'index')->name('index');
	Route::post('/', $countryController . 'create')->name('create');
	Route::post('/delete/{id}', $countryController . 'delete')->name('delete');
	Route::get('/detail/{id}', $countryController . 'detail')->name('detail');
	Route::post('/update', $countryController . 'update')->name('update');
	Route::post('/multi-delete', $countryController . 'multiDelete')->name('multi-delete');
});

Route::prefix('/category')->name('category.')->group(function() {
	$categoryController = 'Admin\CategoryController@';

	Route::get('/', $categoryController . 'index')->name('index');
	Route::post('/', $categoryController . 'create')->name('create');
	Route::post('/delete/{id}', $categoryController . 'delete')->name('delete');
	Route::get('/detail/{id}', $categoryController . 'detail')->name('detail');
	Route::post('/update', $categoryController . 'update')->name('update');
	Route::post('/multi-delete', $categoryController . 'multiDelete')->name('multi-delete');
});

Route::prefix('/film')->name('film.')->group(function() {
	$filmController = 'Admin\FilmController@';

	Route::get('/', $filmController . 'index')->name('index');
	Route::post('/', $filmController . 'create')->name('create');
	Route::post('/delete/{id}', $filmController . 'delete')->name('delete');
	Route::get('/detail/{id}', $filmController . 'detail')->name('detail');
	Route::post('/update', $filmController . 'update')->name('update');
	Route::post('/status', $filmController . 'status')->name('status');
	Route::post('/multi-delete', $filmController . 'multiDelete')->name('multi-delete');
	Route::prefix('/manage-video/{film_id}')->name('manage-video.')->group(function() {
		$filmController = 'Admin\FilmController@';
		
		Route::get('/', $filmController. 'manageVideo')->name('index');
		Route::get('/create-video', $filmController. 'createVideo')->name('create');
		Route::get('/edit-video/{id}', $filmController. 'editVideo')->name('edit-video');
		Route::post('/getFilterAi', $filmController. 'getFilterAi')->name('filter-ai');
		Route::post('/combineVideo', $filmController . 'combineVideo')->name('combine-video');
		Route::post('/', $filmController . 'storeVideo')->name('store-video');
		Route::post('/createAudio', $filmController . 'makeAudio')->name('create-audio');
		Route::post('/addSoundBG', $filmController . 'addSoundBG')->name('add-soundbg');
		Route::post('/multi-delete', $filmController . 'multiDeleteVideo')->name('multi-delete');
		Route::post('/delete/{id}', $filmController . 'deleteVideo')->name('delete');
	});
});

Route::prefix('/news')->name('news.')->group(function() {
	$newsController = 'Admin\NewsController@';

	Route::get('/', $newsController . 'index')->name('index');
	Route::post('/', $newsController . 'create')->name('create');
	Route::post('/delete/{id}', $newsController . 'delete')->name('delete');
	Route::get('/detail/{id}', $newsController . 'detail')->name('detail');
	Route::post('/update', $newsController . 'update')->name('update');
	Route::post('/multi-delete', $newsController . 'multiDelete')->name('multi-delete');
});

Route::prefix('/manage-slider')->name('manage-slider.')->group(function() {
	$manageSliderController = 'Admin\ManageSliderController@';

	Route::get('/', $manageSliderController . 'index')->name('index');
	Route::post('/', $manageSliderController . 'create')->name('create');
	Route::post('/delete/{id}', $manageSliderController . 'delete')->name('delete');
	Route::get('/detail/{id}', $manageSliderController . 'detail')->name('detail');
	Route::post('/update', $manageSliderController . 'update')->name('update');
	Route::post('/multi-delete', $manageSliderController . 'multiDelete')->name('multi-delete');
	Route::get('/search', $manageSliderController . 'search')->name('search');
	Route::get('/detailFilm/{film_id}', $manageSliderController . 'detailFilm')->name('detailFilm');
});