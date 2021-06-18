<?php
namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\Admin\Category\CategoryRepositoryInterface;
use App\Repositories\Admin\Country\CountryRepositoryInterface;
use App\Repositories\Admin\Film\FilmRepositoryInterface;

 class MasterClientComposer
 {
    public function __construct(CategoryRepositoryInterface $cateRepoInter, CountryRepositoryInterface $countryRepoInter,
        FilmRepositoryInterface $filmRepoInter
    )
    {
        $this->cateRepoInter = $cateRepoInter;
        $this->countryRepoInter = $countryRepoInter;
        $this->filmRepoInter = $filmRepoInter;
    }

    /**
    * Bind data to the view.
    *
    * @param  View  $view
    * @return void
    */
    public function compose(View $view)
    {
        $cateFilms = $this->cateRepoInter->where('type', 'film');
        $countries = $this->countryRepoInter->all();
        $typeFilms = $this->filmRepoInter::LIST_TYPE;

        $view->with('cateFilms', $cateFilms);
        $view->with('countries', $countries);
        $view->with('typeFilms', $typeFilms);
    }
 }