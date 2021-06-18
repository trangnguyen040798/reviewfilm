<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\Film\FilmRepositoryInterface;

class HomeController extends Controller
{
    public function __construct(FilmRepositoryInterface $filmRepoInter)
    {
        $this->filmRepoInter = $filmRepoInter;
    }

    public function index()
    {
        $topVieweds = $this->filmRepoInter->getTopview();
        $topRatings = $this->filmRepoInter->getTopRating();
        $topLatests = $this->filmRepoInter->getTopLatest();
        $pathImage = asset('') . config('admin.default_folder_image');

        return view('client.home', ['topVieweds' => $topVieweds, 'topRatings' => $topRatings, 'pathImage' => $pathImage, 'topLatests' => $topLatests]);
    }

    public function aboutUs()
    { 
        return view('client.about-us');
    }
}