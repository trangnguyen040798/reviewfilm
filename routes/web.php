<?php

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
Route::get('/', 'Client\HomeController@index')->name('index');
Route::get('/about-us', 'Client\HomeController@aboutUs')->name('about-us');
Route::prefix('film/')->name('film.')->group(function() {
	$filmController = 'Client\FilmController@';
	//middleware
	Route::get('/create', $filmController . 'create')->name('create')->middleware(['auth']);
	Route::post('/store', $filmController . 'store')->name('store')->middleware(['auth']);
	Route::get('/edit/{id}', $filmController . 'edit')->name('edit')->middleware(['auth']);
	Route::post('/update/{id}', $filmController . 'update')->name('update')->middleware(['auth']);
	Route::post('/delete/{id}', $filmController . 'delete')->name('delete')->middleware(['auth']);
	Route::post('saved-video', $filmController . 'savedVideo')->name('saved-video')->middleware(['auth']);
	Route::get('list-saved-video/{name_cate}/{index}', $filmController . 'listSavedVideo')->name('list-saved-video')->middleware(['auth']);
	Route::get('view-list-saved-video/{name_cate}', $filmController . 'viewListSavedVideo')->name('view-list-saved-video')->middleware(['auth']);
	
	Route::post('/search', $filmController . 'search')->name('search');
	Route::get('{id}', $filmController . 'detail')->name('detail');
	Route::get('/detail-video/{id}', $filmController . 'detailVideo')->name('detail-video');
	Route::get('info-artist/{id}', $filmController . 'infoArtist')->name('info-artist');
	
	Route::prefix('/manage-video/{film_id}')->middleware(['auth'])->name('manage-video.')->group(function() {
		$filmController = 'Client\FilmController@';
		
		Route::get('/', $filmController. 'manageVideo')->name('index');
		Route::get('/create-video', $filmController. 'createVideo')->name('create');
		Route::get('/edit-video/{id}', $filmController. 'editVideo')->name('edit-video');
		Route::post('/getFilterAi', $filmController. 'getFilterAi')->name('filter-ai');
		Route::post('/combineVideo', $filmController . 'combineVideo')->name('combine-video');
		Route::post('/', $filmController . 'storeVideo')->name('store-video');
		Route::post('/createAudio', $filmController . 'makeAudio')->name('create-audio');
		Route::post('/addSoundBG', $filmController . 'addSoundBG')->name('add-soundbg');
		Route::post('/detail-video', $filmController . 'detailVideo2')->name('detail-video');
		Route::post('/delete-video', $filmController . 'deleteVideo')->name('delete-video');
	});
});
Route::prefix('/cate')->name('category.')->group(function() {
	Route::get('/{type}/{slug}', 'Client\CategoryController@category')->name('cate');
	Route::post('/', 'Client\CategoryController@filter')->name('filter');
});
Route::prefix('/news')->name('news.')->group(function() {
	Route::get('/cate', 'Client\NewsController@index')->name('cate');
	Route::get('/{slug}', 'Client\NewsController@detail')->name('detail');
});
Route::prefix('/account')->middleware(['auth'])->name('account.')->group(function() {
	Route::get('/', 'Client\UserController@index')->name('index');
	Route::post('/uploadImage', 'Client\UserController@uploadImage')->name('upload-image');
	Route::post('/uploadThumbnail', 'Client\UserController@uploadThumbnail')->name('upload-thumbnail');
	Route::get('/edit', 'Client\UserController@edit')->name('edit');
	Route::post('/update', 'Client\UserController@update')->name('update');
});
// Login
Route::post('/register', 'LoginController@register')->name('register');
Route::post('/login', 'LoginController@authenticate')->name('login');
Route::post('/logout', 'LoginController@logout')->name('logout');
Route::get('/redirect/{provider}', 'LoginController@redirect')->name('socialRedirect')->where('driver', implode('|', config('auth.socialite.drivers')));;
Route::get('/callback/{provider}', 'LoginController@callback')->name('socialCallback');
Route::get('/mail-form', 'LoginController@mailForm')->name('mail-form');
Route::post('/sendMail', 'LoginController@sendMail')->name('sendMail');
Route::post('/reset-password/{token}', 'LoginController@reset')->name('reset');
Route::get('/reset-password/{token}', 'LoginController@resetForm')->name('reset-form');
