<?php
namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\Admin\ManageSlider\ManageSliderRepositoryInterface;

 class HomeClientComposer
 {
    public function __construct(
        ManageSliderRepositoryInterface $mnSliderRepoInter)
    {

        $this->mnSliderRepoInter = $mnSliderRepoInter;
    }

    /**
    * Bind data to the view.
    *
    * @param  View  $view
    * @return void
    */
    public function compose(View $view)
    {
        $firstSliders = $this->mnSliderRepoInter->where('tag', $this->mnSliderRepoInter::slider_1);
        foreach ($firstSliders as $key => $value) {
            $firstSliders[$key]->image = asset('') . config('admin.default_folder_image') . $value->image;
        }

        $secondSliders = $this->mnSliderRepoInter->with('film')->where('tag', $this->mnSliderRepoInter::slider_2)->get();
        foreach ($secondSliders as $key => $value) {
            if ($value->film->image == null) {
                $secondSliders[$key]->film->image = asset('') . config('admin.no-image');
            } else {
                $secondSliders[$key]->film->image = asset('') . config('admin.default_folder_image') . $value->film->image;
            }
        }

        $view->with('firstSliders', $firstSliders);
        $view->with('secondSliders', $secondSliders);
    }
 }