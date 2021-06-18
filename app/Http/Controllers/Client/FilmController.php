<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\Film\FilmRepositoryInterface;
use Illuminate\Support\Collection;
use App\Repositories\Admin\Video\VideoRepositoryInterface;
use App\Repositories\Admin\Artist\ArtistRepositoryInterface;
use App\Repositories\Admin\SavedVideo\SavedVideoRepositoryInterface;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Admin\CategoryFilm\CategoryFilmRepositoryInterface;
use App\Repositories\Admin\ArtistFilm\ArtistFilmRepositoryInterface;
use App\Repositories\Admin\InfoVideo\InfoVideoRepositoryInterface;
use App\Http\Requests\FilmRequest;
use App\Http\Requests\UpdateFilmRequest;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class FilmController extends Controller
{
    public $paginate = 12;

    public function __construct(
        FilmRepositoryInterface $filmRepoInter,
        VideoRepositoryInterface $videoRepoInter,
        ArtistRepositoryInterface $artistRepoInter,
        SavedVideoRepositoryInterface $savedVideoRepoInter,
        CategoryFilmRepositoryInterface $cateFilmRepoInter,
        ArtistFilmRepositoryInterface $artistFilmRepoInter,
        InfoVideoRepositoryInterface $infoVideoRepoInter
    )
    {
        $this->filmRepoInter = $filmRepoInter;
        $this->videoRepoInter = $videoRepoInter;
        $this->artistRepoInter = $artistRepoInter;
        $this->savedVideoRepoInter = $savedVideoRepoInter;
        $this->cateFilmRepoInter = $cateFilmRepoInter;
        $this->artistFilmRepoInter = $artistFilmRepoInter;
        $this->infoVideoRepoInter = $infoVideoRepoInter;
        $this->path_video = config('admin.default_folder_video');
        $this->path_image = config('admin.default_folder_image');
    }

    public function detail($id)
    {
    	$film = $this->filmRepoInter->with('director')->with('categories')->with('actors')->with('country')->with('comments')->find($id);
        if ($film['image'] == null) {
            $film['image'] = asset('') . config('admin.no-image');
        } else {
            $film['image'] = asset('') . $this->path_image . $film['image'];
        }
        $film['release_date'] ? $film['release_date'] = date("d/m/Y", strtotime($film['release_date'])) : null;
        $sugestion_films = $this->getSuggestionFilm($film);
        $videos = $this->videoRepoInter->where('film_id', $id);
        foreach ($videos as $key => $value) {
            $videos[$key]['link'] = asset('') . $this->path_video . $value['link'];
            if ($value['image'] == null) {
                $videos[$key]['image'] = asset('') . config('admin.no-image');
            } else {
                $videos[$key]['image'] = asset('') . $this->path_image . $value['image'];
            }
        }

        return view('client.film', ['film' => $film, 'sugestion_films' => $sugestion_films, 'videos' => $videos]);
    }

    public function getSuggestionFilm($film)
    {
        $collection = new Collection();
        $films = $this->filmRepoInter->takeTenFilm($film);
        $collection = $collection->merge($films);
        $collection =  collect($collection)->unique();
        foreach ($collection as $key => $film) {
            if ($film['image'] == null) {
                $collection[$key]['image'] = asset('') . config('admin.no-image');
            } else {
                $collection[$key]['image'] = asset('') . $this->path_image . $film['image'];
            }
        }

        return $collection;
    }

    public function manageVideo($id)
    {
        $videos = $this->videoRepoInter->wherePaginate('film_id', $id, $this->paginate);
        $complete = true;
        foreach ($videos as $key => $value) {
            if ($value['image'] == null) {
                $complete = false;
                $videos[$key]['image'] = asset('') . config('admin.no-image');
            } else {
                $videos[$key]['image'] = asset('') . $this->path_image . $value['image'];
            }
            if ($value['link'] == null) {
                $complete = false;
            } else {
                $videos[$key]['link'] = asset('') . $this->path_video . $value['link'];
            }
            $videos[$key]['complete'] = $complete;
        }
        $film = $this->filmRepoInter->find($id);
        $film->type = $this->filmRepoInter::LIST_TYPE[$film->type];

        return view('client.manage-video', ['film_id' => $id, 'videos' => $videos, 'film' => $film]);
    }

    public function createVideo($id)
    {
        $data = $this->videoRepoInter->wherePaginate('film_id', $id, config('admin.default-page'));
        $filters = $this->filmRepoInter::LIST_FILTER_AI;
        $film = $this->filmRepoInter->find($id);
        $film->isSeries = $film->type==$this->filmRepoInter::series_movie_type;
        $film->type = $this->filmRepoInter::LIST_TYPE[$film->type];
        foreach($data as $key => $value) {
            $data[$key]['link'] = asset('') . $this->path_video . $value['link'];
            $data[$key]['image'] = asset('') . $this->path_image . $value['image'];
        }
        $speeds = [
            'min' => 0.25,
            'max' => 2.0,
            'default' => 1.0,
            'step' => 0.05
        ];
        $isUpdated = 0;

        return view('client.create-video', ['data' => $data, 'film_id' => $id, 'filters' => $filters, 'speeds' => $speeds, 'film' => $film, 'isUpdated' => $isUpdated]);
    }

    public function combineVideo(Request $request)
    {
        $data = $request->all();
        $data['isUpdated'] = (int) $data['isUpdated'];
        if (!$data['isUpdated']) {
            $rules = [
                'episode' => 'required',
                'film_id' => 'required',
                'file' => 'required',
            ];
            $messages = [
                'episode.required' => 'Mời nhập số tập phim',
                'film_id.required' => 'Id phim không được để trống',
                'file.required' => 'Mời bạn chọn file',
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422); 
            }
            $video = $this->videoRepoInter->wherewhere('episode', $data['episode'], 'film_id', $data['film_id']);
            if (count($video) == 0) {
                // create video
                $this->videoRepoInter->create($data);
            }

            // check if enter pass episode
            $this->checkEpisode($data['film_id'], $data['episode']);
            $infoSmallVideos = $this->infoVideoRepoInter->wherewhereSmallVideo('episode', $data['episode'], 'film_id', $data['film_id']);
            if (count($infoSmallVideos->get()) > 0) {
                foreach ($infoSmallVideos->get() as $key => $value) {
                    if(Storage::disk('videos')->exists($value->column_value)) {
                        unlink($this->path_video . $value->column_value);
                    }
                }
                $infoSmallVideos->delete();
            }
            $infoCombineVideos = $this->infoVideoRepoInter->wherewhereCombineVideo('episode', $data['episode'], 'film_id', $data['film_id']);
            if (count($infoCombineVideos->get()) > 0) {
                foreach ($infoCombineVideos->get() as $key => $value) {
                    if(Storage::disk('videos')->exists($value->column_value)) {
                        unlink($this->path_video . $value->column_value);
                    }
                }
                $infoCombineVideos->delete();
            }
        } else {
            $rules = [
                'episode' => 'required',
                'film_id' => 'required'
            ];
            $messages = [
                'episode.required' => 'Mời nhập số tập phim',
                'film_id.required' => 'Id phim không được để trống',
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422); 
            }
            $deletedInfoVideos = $this->infoVideoRepoInter->whereNotIn('episode', $data['episode'], 'film_id', $data['film_id'], $data['list_id']);
            foreach ($deletedInfoVideos->get() as $key => $value) {
                if (Storage::disk('videos')->exists($value->column_value)) {
                    unlink($this->path_video . $value->column_value);
                }
            }
            $deletedInfoVideos->delete();
            $this->infoVideoRepoInter->wherewhereCombineVideo('episode', $data['episode'], 'film_id', $data['film_id'])->delete();
        }
        if (!isset($data['index']) || empty($data['index'])) {
            return response()->json(['error' => true, 'message' => 'Mời bạn chọn file']);
        }
        $arrVideo = [];
        $arrIndex = explode(',', $data['index']);
        foreach ($arrIndex as $key => $value) {
            $arr = explode('-', $value);
            $child_arr = explode('_', $arr[0]);
            if (count($child_arr) > 0 && isset($child_arr[1]) && $child_arr[1] == 'smallVideo.mp4') {
                array_push($arrVideo, ['fileName' => $arr[0], 'index' => $arr[1], 'size' => $arr[2], 'update' => true]);
                unset($arrIndex[$key]);
            }
        }
        if (isset($data['file'])) {
            foreach($data['file'] as $value) {
                $video = uploadFileIndex($this->path_video, $value, $arrIndex);
                if ($video) {
                    array_push($arrVideo, $video);
                }
            }
        }

        usort($arrVideo, function($a, $b) {
            return $a['index'] <=> $b['index'];
        });
        $combineVideo = uniqid() . '_' . 'combineVideo.mp4';
        $result = combineVideo($arrVideo, $this->path_video, $combineVideo);
        if($result == true) {
            foreach ($arrVideo as $key => $value) {
                if ($value['update']) {
                    $small_video = $this->infoVideoRepoInter->whereFirst('column_value', $value['fileName']);
                    $this->infoVideoRepoInter->update($small_video->id, ['position' => $value['index']]);
                } else {
                    $video = \Owenoj\LaravelGetId3\GetId3::fromDiskAndPath('videos', $value['fileName']);
                    $duration = $video->getPlaytimeSeconds();
                    $infoVideo['duration'] = formatTime($duration);
                    $infoVideo['column_name'] = 'link_small_combine_video';
                    $infoVideo['column_value'] = $value['fileName'];
                    $infoVideo['position'] = $value['index'];
                    $infoVideo['capacity'] = $value['size'];
                    $infoVideo['episode'] = $data['episode'];
                    $infoVideo['film_id'] = $data['film_id'];
                    $result = $this->infoVideoRepoInter->create($infoVideo);
                }
            }
            $video = \Owenoj\LaravelGetId3\GetId3::fromDiskAndPath('videos', $combineVideo);
            $duration = $video->getPlaytimeSeconds();
            $infoVideo2['duration'] = formatTime($duration);
            $size = filesize($this->path_video . $combineVideo);
            $infoVideo2['capacity'] = number_format($size / 1048576, 2);
            $infoVideo2['column_name'] = 'link_combine_video';
            $infoVideo2['column_value'] = $combineVideo;
            $infoVideo2['position'] = 0;
            $infoVideo2['episode'] = $data['episode'];
            $infoVideo2['film_id'] = $data['film_id'];
            $this->infoVideoRepoInter->create($infoVideo2);

            return response()->json(['success' => 'Gộp video thành công', 'asset' => asset('') . $this->path_video, 'fileName' => $combineVideo, 'size' => $infoVideo2['capacity'], 'episode' => $data['episode']]);
        }
        return response()->json(['error' => true, 'message' => $result]);
    }

    public function getFilterAi(Request $request)
    {
        if ($request['type'] == $this->filmRepoInter::LIST_FILTER_AI[$this->filmRepoInter::fpt]) {
            $speeches = [
                'leminh' => 'Lê Minh (Nam Miền Bắc)',
                'banmai' => 'Ban Mai (Nữ Miền Bắc)',
                'thuminh' => 'Thu Minh (Nữ Miền Bắc)',
                'giahuy' => 'Gia Huy (Nam Miền Trung)',
                'ngoclam' => 'Ngọc Lam (Nữ Miền Trung)',
                'myan' => 'Mỹ An (Nữ Miền Trung)',
                'lannhi' => 'Lan Nhi (Nữ Miền Nam)',
                'linhsan' => 'Linh San (Nữ Miền Nam)',
                'minhquang' => 'Minh Quang (Nam Miền Nam)'
            ];
            $speeds = [
                'min' => -3,
                'max' => 3,
                'default' => 0,
                'step' => 0.5,
            ];
        } elseif ($request['type'] == $this->filmRepoInter::LIST_FILTER_AI[$this->filmRepoInter::zalo]) {
            $speeches = [
                1 => 'Nữ Miền Nam',
                2 => 'Nữ Miền Bắc',
                3 => 'Nam Miền Nam',
                4 => 'Nam Miền Bắc'
            ];
            $speeds = [
                'min' => 0.8,
                'max' => 1.2,
                'default' => 1.0,
                'step' => 0.1,
            ];
        } else {
            $speeches = [];
            $speeds = [
                'min' => 0.25,
                'max' => 2.0,
                'default' => 1.0,
                'step' => 0.05
            ];
        }

        return response()->json(['error' => false, 'speeches' => $speeches, 'speeds' => $speeds]);
    }

    public function makeAudio(Request $request)
    {
        $data = $request->all();
        $rules = [
            'episode' => 'required',
            'audio' => 'required',
            'type' => 'required',
            'film_id' => 'required'
        ];
        $messages = [
            'episode.required' => 'Mời bạn nhập số tập phim',
            'audio.required' => 'Mòi nhập nội dung phim',
            'type.required' => 'Mời bạn chọn loại ai',
            'film_id.required' => 'Id phim không được để trống'
        ];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422); 
        }
        if (!$data['isUpdated']) {
            $video = $this->videoRepoInter->wherewhere('episode', $data['episode'], 'film_id', $data['film_id']);
            if (count($video) == 0) {
                // create video
                $this->videoRepoInter->create($data);
            }
        }

        // check if enter pass episode
        $this->checkEpisode($data['film_id'], $data['episode']);

        $ttsAudio = uniqid() . '_' . 'makeAudio.mp3';
        switch($data['type']) {
            case $this->filmRepoInter::LIST_FILTER_AI[$this->filmRepoInter::zalo]:
            $result1 = json_decode(makeAudioZalo($data));
            if ($result1->error_code != 0) {
                return response()->json(['error' => true, 'message' => $result1->error_message])
                ;
            }
            $c_error = 0;
            while($c_error < 6) {
                if (!isset($result1->data)) {
                    return response()->json(['error' => true, 'message' => 'Không kết nối được ZaloAi.Vui lòng nhấn tạo lại.'])
                    ;
                }
                $result2 = download($this->path_video, $ttsAudio, $result1->data->url);
                if (isset($result2['error']) && $result2['error']) {
                    $c_error ++;
                } else {
                    break;
                }
            }
            if ($c_error == 5) {
                return response()->json(['error' => true, 'message' => 'Not found file response zalo ai']);
            }
            break;
            case $this->filmRepoInter::LIST_FILTER_AI[$this->filmRepoInter::fpt]:
            $result1 = json_decode(makeAudioFPT($data));
            if ($result1->error != 0) {
                return response()->json(['error' => true, 'message' => $result1->message]); 
            }
            $c_error = 0;
            while($c_error < 6) {
                if (!isset($result1->async)) {
                    return response()->json(['error' => true, 'message' => 'Không kết nối được FptAi.Vui lòng nhấn tạo lại.'])
                    ;
                }
                $result2 = download($this->path_video, $ttsAudio, $result1->async);
                if (isset($result2['error']) && $result2['error']) {
                    $c_error ++;
                } else {
                    break;
                }
            }
            if ($c_error == 5) {
                return response()->json(['error' => true, 'message' => 'Not found file response zalo ai']);
            }
            break;
            case $this->filmRepoInter::LIST_FILTER_AI[$this->filmRepoInter::google]:
            $result = makeAudioGG($data, $this->path_video, $ttsAudio);
            if (!$result) {
                return response()->json(['error' => true, 'message' => $result]);
            }
        }
        // ttsAudio
        if (Storage::disk('videos')->exists($ttsAudio)) {
            $mp3 = \Owenoj\LaravelGetId3\GetId3::fromDiskAndPath('videos', $ttsAudio);
            $duration = $mp3->getPlaytimeSeconds();
            $infoVideo['duration'] = formatTime($duration);
            $size = filesize($this->path_video . $ttsAudio);
            $infoVideo['capacity'] = number_format($size / 1048576, 2);
            $infoVideo['column_value'] = $ttsAudio;

            // delete old DB
            $combineAudio = $this->infoVideoRepoInter->wherewhereCombineAudio('episode', $data['episode'], 'film_id', $data['film_id']);
            if (count($combineAudio->get()) > 0) {
                if(Storage::disk('videos')->exists($combineAudio->first()->column_value)) {
                    unlink($this->path_video . $combineAudio->first()->column_value);
                }
                $this->infoVideoRepoInter->update($combineAudio->first()->id, $infoVideo);
            } else {
                $infoVideo['column_name'] = 'link_combine_audio';
                $infoVideo['position'] = 0;
                $infoVideo['episode'] = $data['episode'];
                $infoVideo['film_id'] = $data['film_id'];
                $this->infoVideoRepoInter->create($infoVideo);
            }
            // audio
            $audioTxt = uniqid() . '_' .'audioTxt.txt';
            File::put($this->path_video . $audioTxt, $data['audio']);
            $infoVideo2['column_value'] = $audioTxt;
            $audio = $this->infoVideoRepoInter->wherewhereAudio('episode', $data['episode'], 'film_id', $data['film_id']);
            if (count($audio->get()) > 0) {
                if(Storage::disk('videos')->exists($audio->first()->column_value)) {
                    unlink($this->path_video . $audio->first()->column_value);
                }
                $infoVideo2 = $this->infoVideoRepoInter->update($audio->first()->id, $infoVideo2);
            } else {
                $infoVideo2['column_name'] = 'link_audio';
                $infoVideo2['position'] = 0;
                $infoVideo2['episode'] = $data['episode'];
                $infoVideo2['film_id'] = $data['film_id'];
                $this->infoVideoRepoInter->create($infoVideo2);
            }
            return response()->json(['success' => 'Tạo file audio thành công', 'asset' => asset('') . $this->path_video , 'fileName' => $ttsAudio, 'size' => $infoVideo['capacity'], 'duration' => $infoVideo['duration'], 'episode' => $data['episode']]);
        } else {
            return response()->json(['error' => true, 'message' => 'Không kết nối được FptAi.Vui lòng nhấn tạo lại.']);
        }
        
    }

    public function addSoundBG(Request $request)
    {
        $data = $request->all();
        $rules = [
            'sound_bg' => 'required',
            'episode' => 'required',
            'film_id' => 'required'
        ];
        $messages = [
            'sound_bg.required' => 'Mòi chọn nhạc nền',
            'film_id.required' => 'Id phim không được để trống',
            'episode.required' => 'Mời nhập số tập phim'
        ];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422); 
        }

        if (!$data['isUpdated']) {
            $video = $this->videoRepoInter->wherewhere('episode', $data['episode'], 'film_id', $data['film_id']);
            if (count($video) == 0) {
                // create video
                $this->videoRepoInter->create($data);
            }
        }

        // check if enter pass episode
        $this->checkEpisode($data['film_id'], $data['episode']);

        $bgAudio = uniqid() . '_' . 'bgAudio.mp3';
        $audio = uploadFile($this->path_video, $data['sound_bg']);
        $result = ajustVolume($this->path_video, $audio, $bgAudio, $data['volume']);
            //bgAudio
        $mp3 = \Owenoj\LaravelGetId3\GetId3::fromDiskAndPath('videos', $bgAudio);
        $duration = $mp3->getPlaytimeSeconds();
        $infoVideo['duration'] = formatTime($duration);
        $size = filesize($this->path_video . $bgAudio);
        $infoVideo['capacity'] = number_format($size / 1048576, 2);
        $infoVideo['column_value'] = $bgAudio;
        $bgSounds = $this->infoVideoRepoInter->wherewhereBGSound('film_id', $data['film_id'], 'episode', $data['episode']);
        if (count($bgSounds->get()) > 0) {
            if(Storage::disk('videos')->exists($bgSounds->first()->column_value)) {
                unlink($this->path_video . $bgSounds->first()->column_value);
            }
            $this->infoVideoRepoInter->update($bgSounds->first()->id, $infoVideo);
        } else {
            $infoVideo['column_name'] = 'link_bg_audio';
            $infoVideo['position'] = 0;
            $infoVideo['episode'] = $data['episode'];
            $infoVideo['film_id'] = $data['film_id'];
            $this->infoVideoRepoInter->create($infoVideo);
        }
        if ($result == true) {
            return response()->json(['success' => 'Thêm âm thanh nền thành công', 'asset' => asset('') . $this->path_video , 'fileName' => $bgAudio, 'size' => $infoVideo['capacity'], 'duration' => $infoVideo['duration'], 'episode' => $data['episode']]);
        } else {
            return response()->json(['error' => true, 'message' => $result]);
        }
    }

    public function checkEpisode($film_id, $episode)
    {
        $film = $this->filmRepoInter->find($film_id);
        if ($episode > $film->total_episodes) {
            return response()->json(['error' => true, 'message' => 'Quá số tập phim', 'exceed' => true]);
        } elseif ($episode < 0) {
            return response()->json(['error' => true, 'message' => 'Số tập phim phải lớn hơn 0', 'exceed' => true]);
        } 
    }

    public function storeVideo($film_id, Request $request)
    {
        $data =  $request->all();
        $data['isUpdated'] = (int) $data['isUpdated'];
        if (!$data['isUpdated']) {
            $rules = [
                'image_video' => 'required',
                'episode' => 'required',
                'film_id' => 'required'
            ];
            $messages = [
                'image_video.required' => 'Mời bạn chọn ảnh',
                'episode.required' => 'Mời nhập số tập phim',
                'film_id.required' => 'Id phim không được để trống'
            ];
        } else {
            $rules = [
                'episode' => 'required',
                'film_id' => 'required'
            ];
            $messages = [
                'episode.required' => 'Mời nhập số tập phim',
                'film_id.required' => 'Id phim không được để trống'
            ];
        }
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422); 
        }

        // check if enter pass episode
        $this->checkEpisode($film_id, $data['episode']);

        if (isset($data['image_video'])) {
            $data['image'] = uploadFile($this->path_image, $data['image_video']);
        }

        // check exist video, audio, bg-audio
        $infoVideo = $this->infoVideoRepoInter->wherewhere('film_id', $data['film_id'], 'episode', $data['episode']);
        $flagVideo = false;
        $flagAudio = false;
        $flagBgAudio = false;
        foreach ($infoVideo as $key => $value) {
            if ($value['column_name'] == 'link_combine_video') {
                $combineVideo = $value['column_value'];
                $flagVideo = true;
            }
            if ($value['column_name'] == 'link_combine_audio') {
                $combineAudio = $value['column_value'];
                $flagAudio = true;
            }
            if ($value['column_name'] == 'link_bg_audio') {
                $bgAudio = $value['column_value'];
                $flagBgAudio = true;
            }
        }
        if ($flagVideo == false) {
            return response()->json(['error' => true, 'message' => 'Bạn chưa có video tổng hợp', 'miss' => true]);
        }
        if ($flagAudio == false) {
            return response()->json(['error' => true, 'message' => 'Bạn chưa có file đọc', 'miss' => true]);
        }
        if ($flagBgAudio == false) {
            return response()->json(['error' => true, 'message' => 'Bạn chưa có nhạc nền', 'miss' => true]);
        }

        // check exist video
        $video = $this->videoRepoInter->wherewhere('film_id', $film_id, 'episode', $data['episode']);
        $file = makeVideo($combineVideo, $combineAudio, $bgAudio, $this->path_video);
        if (!$file['error']) {
            $final_video = \Owenoj\LaravelGetId3\GetId3::fromDiskAndPath('videos', $file['async']);
            $duration = formatTime($final_video->getPlaytimeSeconds());
            $size = number_format(filesize($this->path_video . $file['async'])/ 1048576, 2);
            $data['link'] = $file['async'];
            if (Storage::disk('videos')->exists($video->first()->link)) {
                unlink($this->path_video . $video->first()->link);
            }
            $this->videoRepoInter->update($video->first()->id, $data);
            $count = $this->videoRepoInter->where('film_id', $film_id)->count();
            $total_episodes = $this->filmRepoInter->find($film_id)->total_episodes;
            if ($count == $total_episodes) {
                $this->filmRepoInter->update($film_id, ['complete' => 1]);
            }

            return response()->json(['success' => 'Tạo video thành công', 'asset' => asset('') . $this->path_video, 'fileName' => $file['async'], 'duration' => $duration, 'size' => $size]);
        } else {
            return response()->json(['error' => true, 'message' => $file['message']]);
        }
    }

    public function detailVideo2(Request $request)
    {
        $video = $this->videoRepoInter->find($request->id);
        $getid3_video = \Owenoj\LaravelGetId3\GetId3::fromDiskAndPath('videos', $video->link);
        $video['duration'] = formatTime($getid3_video->getPlaytimeSeconds());
        $video['size'] = number_format(filesize($this->path_video . $video->link)/ 1048576, 2);
        $video['asset'] = asset('') . $this->path_video;

        return $video;
    }

    public function deleteVideo(Request $request, $film_id)
    {
        DB::beginTransaction();
        try {
            $video = $this->videoRepoInter->find($request->id);
            if (Storage::disk('images')->exists($video->image)) {
                unlink($this->path_image . $video->image);
            }
            if (Storage::disk('videos')->exists($video->link)) {
                unlink($this->path_video . $video->link);
            }
            $listInfos = $this->infoVideoRepoInter->whereWhereInfo('film_id', $film_id, 'episode', $video->episode);
            foreach ($listInfos->get() as $key => $value) {
                if (Storage::disk('videos')->exists($value->column_value)) {
                    unlink($this->path_video . $value->column_value);
                }
            }
            $listInfos->delete();
            $this->videoRepoInter->delete($request->id);
            DB::commit();

            return response()->json(['success' => 'Xóa Thành Công']);
        } catch (Exception $e) {
            DB::rollBack();
            
            throw new Exception($e->getMessage());
        }

    }

    public function editVideo($film_id, $id)
    {
        $isUpdated = true;
        $video = $this->videoRepoInter->find($id);
        $size = filesize($this->path_video . $video->link);
        $video['capacity'] = number_format($size / 1048576, 2);
        $smallVideos = $this->infoVideoRepoInter->wherewhereSmallVideo('film_id', $film_id, 'episode', $video->episode)->get();
        $combineVideo = $this->infoVideoRepoInter->wherewhereCombineVideo('film_id', $film_id, 'episode', $video->episode)->first();
        $ttsAudio = $this->infoVideoRepoInter->wherewhereCombineAudio('film_id', $film_id, 'episode', $video->episode)->first();
        $audioTxt = $this->infoVideoRepoInter->wherewhereAudio('film_id', $film_id, 'episode', $video->episode)->first();
        if (isset($audioTxt->column_value)) {
            $audioTxt = File::get($this->path_video . $audioTxt->column_value);
        }
        $bgAudio = $this->infoVideoRepoInter->wherewhereBGSound('film_id', $film_id, 'episode', $video->episode)->first();
        $filters = $this->filmRepoInter::LIST_FILTER_AI;
        $film = $this->filmRepoInter->find($film_id);
        $film->isSeries = ($film->type == $this->filmRepoInter::series_movie_type);
        $film->type = $this->filmRepoInter::LIST_TYPE[$film->type];
        $speeds = [
            'min' => 0.25,
            'max' => 2.0,
            'default' => 1.0,
            'step' => 0.05
        ];

        return view('client.edit-video', ['video' => $video, 'combineVideo' => $combineVideo, 'ttsAudio' => $ttsAudio, 'audioTxt' => $audioTxt, 'bgAudio' => $bgAudio, 'film' => $film, 'assetVideo' => asset('') . $this->path_video, 'assetImage' => asset('') . $this->path_image, 'isUpdated' => $isUpdated, 'speeds' => $speeds, 'filters' => $filters, 'smallVideos' => $smallVideos]);
    }

    public function detailVideo($id)
    {
        if (request()->has('r')) {

        } else {
            
        }
        $video = $this->videoRepoInter->with(['film' => function ($q) {
            $q->with('user');
        }])->find($id);
        $video['views'] = $video['views'] + 1;
        $this->videoRepoInter->update($id, ['views' => $video['views']]);
        $video->film->views = $video->film->views + 1;
        $this->filmRepoInter->update($video->film_id, ['views' => $video->film->views]);
        $listNameCateSV = $this->savedVideoRepoInter->getListNameCateSV($id);
        $video['link'] = asset('') . $this->path_video . $video['link'];
        if ($video['image'] == null) {
            $video['image'] = asset('') . config('admin.no-image');
        } else {
            $video['image'] = asset('') . $this->path_image . $video['image'];
        }
        if ($video->film->type == $this->filmRepoInter::odd_film_type) {
            $video['is_odd'] = true;
            $listVideo = [$video];
        } else {
            $listVideo = $this->videoRepoInter->where('film_id', $video->film_id)->load('film');
            foreach ($listVideo as $key => $value) {
                $listVideo[$key]['link'] = asset('') . $this->path_video . $value['link'];
                if ($value['image'] == null) {
                    $listVideo[$key]['image'] = asset('') . config('admin.no-image');
                } else {
                    $listVideo[$key]['image'] = asset('') . $this->path_image . $value['image'];
                }
            }
        }

        return view('client.list-video', ['video' => $video, 'listVideo' => $listVideo, 'listNameCateSV' => $listNameCateSV]);
    }

    public function infoArtist($id)
    {
        $artist = $this->artistRepoInter->find($id);
        if ($artist['occupation'] == $this->artistRepoInter::actor) {
            $artist = $artist->load('country')->load('films');
        } else {
            $films = $this->filmRepoInter->where('director_id', $id);
            $artist->films = $films;
        }
        $artist['occupation'] = $this->artistRepoInter::LIST_OP[$artist->occupation];
        if ($artist['image'] == null) {
            $artist['image'] = asset('') . config('admin.no-image');
        } else {
            $artist['image'] = asset('') . $this->path_image . $artist['image'];
        }
        foreach ($artist['films'] as $key => $value) {
            if ($value['image'] == null) {
                $artist['films'][$key]['image'] = asset('') . config('admin.no-image');
            } else {
                $artist['films'][$key]['image'] = asset('') . $this->path_image . $value['image'];
            }
        }

        return view('client.detail-artist', ['artist' => $artist]);
    }

    public function savedVideo(Request $request)
    {
        $data = $request->all();
        $rules = [
            'name_cate' => 'required',
        ];
        $messages = [
            'name_cate.required' => 'Mời bạn nhập tên',
        ];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return back()->withError($validator->errors())->withInput();
        }
        $user = Auth::user();
        $csavedVideo = $this->savedVideoRepoInter->isExistAndDelete('video_id', $data['video_id'], 'user_id', $user->id, 'name_cate', $data['name_cate']);
        if ($csavedVideo) {
            return response()->json(['error' => false, 'message' => 'Bỏ lưu video thành công']);
        }
        $data['user_id'] = $user->id;
        $savedVideo = $this->savedVideoRepoInter->save($data);

        return response()->json(['error' => false, 'message' => 'Lưu video thành công', 'data' => $savedVideo]);
    }

    public function listSavedVideo($name_cate, $index)
    {
        $listSavedVideo = $this->savedVideoRepoInter->getListSVFCate($name_cate);
        $listNameCateSV = $this->savedVideoRepoInter->getListNameCateSV($listSavedVideo[$index-1]->video_id);

        return view('client.list-saved-video', ['listSavedVideo' => $listSavedVideo, 'index' => $index, 'listNameCateSV' => $listNameCateSV]);
    }

    public function viewListSavedVideo($name_cate)
    {
        $listSavedVideo = $this->savedVideoRepoInter->getListSVFCate($name_cate);

        return view('client.view-list-saved-video', ['listSavedVideo' => $listSavedVideo]);
    }

    public function create()
    {
        $directors = $this->artistRepoInter->where('occupation', $this->artistRepoInter::director);
        $actors = $this->artistRepoInter->where('occupation', $this->artistRepoInter::actor);
        $odd_film_type = $this->filmRepoInter::odd_film_type;

        return view('client.create-film', ['directors' => $directors, 'actors' => $actors, 'odd_film_type' => $odd_film_type]);
    }

    public function store(FilmRequest $request)
    {
        $data = $request->all();
        if (isset($data['image']) && !is_null($data['image'])) {
            $data['image'] = uploadFile($this->path_image, $data['image']);
        }
        $user = Auth::user();
        if($user['role'] == 'admin') {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }
        $data['user_id'] = $user['id'];
        $data['complete'] = 0;
        if(isset($data['release_date']) && !is_null($data['release_date'])) {
            $data['release_date'] = Carbon::createFromFormat('d/m/Y', $data['release_date'])->format('Y-m-d');
        }
        $data['total_episodes'] = isset($data['total_episodes']) ? $data['total_episodes'] : 1;
        if(!isset($data['director_id']) || $data['director_id'] == 'unknown') {
            unset($data['director_id']);
        }
        DB::beginTransaction();
        try {
            $film = $this->filmRepoInter->create($data);
            if(isset($data['actors']) && !empty($data['actors'])) {
                foreach($data['actors'] as $value) {
                    $artist_film = $this->artistFilmRepoInter->create(['artist_id' => $value, 'film_id' => $film['id']]);
                }
            }
            if(isset($data['categories']) && !empty($data['categories'])) {
                foreach($data['categories'] as $value) {
                    $category_film = $this->cateFilmRepoInter->create(['category_id' => $value, 'film_id' => $film['id']]);
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }

        return redirect()->route('client.account.index')->with('success', 'Tạo phim thành công');
    }

public function edit($id)
{
    $data = $this->filmRepoInter
    ->find($id)
    ->load('categories')
    ->load('director')
    ->load('country')
    ->load('actors');
    if ($data['image'] == null) {
        $data['image'] = asset('') . config('admin.no-image');
    } else {
        $data['image'] = asset('') . config('admin.default_folder_image') . $data['image'];
    }
    $data['release_date'] = date("d/m/Y", strtotime($data['release_date']));
    $directors = $this->artistRepoInter->where('occupation', $this->artistRepoInter::director);
    $actors = $this->artistRepoInter->where('occupation', $this->artistRepoInter::actor);
    $odd_film_type = $this->filmRepoInter::odd_film_type;
    $data->categories = $data->categories->pluck('id')->toArray();
    $data->actors = $data->actors->pluck('id')->toArray();

    return view('client.edit-film', ['film' => $data, 'directors' => $directors, 'actors' => $actors, 'odd_film_type' => $odd_film_type]);
}

    public function update($id, UpdateFilmRequest $request)
    {
        $data = $request->all();
        if (isset($data['image']) && !is_null($data['image'])) {
            $data['image'] = uploadFile($this->path_image, $data['image']);
        }
        if(isset($data['release_date']) && !is_null($data['release_date'])) {
            $data['release_date'] = Carbon::createFromFormat('d/m/Y', $data['release_date'])->format('Y-m-d');
        }
        if(!isset($data['director_id']) || $data['director_id'] == 'unknown') {
            unset($data['director_id']);
        }
        DB::beginTransaction();
        try {
            $this->filmRepoInter->update($id, $data);
            $film = $this->filmRepoInter->with('user')->find($id);
            if(isset($data['categories'])) {
                $list_category_film_id = $this->cateFilmRepoInter->wherePluck('film_id', $id, 'category_id');
                if (!empty($list_category_film_id)) {
                    $list_category_film_id_delete = array_diff($list_category_film_id, $data['categories']);
                    $this->cateFilmRepoInter->multiDelete('category_id', $list_category_film_id_delete);
                }
                foreach($data['categories'] as $value) {
                    $category_film = $this->cateFilmRepoInter->wherewhere('category_id', $value, 'film_id', $film['id']);
                    if(count($category_film) == 0) {
                        $this->cateFilmRepoInter->create(['category_id' => $value, 'film_id' => $film['id']]);
                    }
                }
            }
            if(isset($data['actors'])) {
                $list_artist_film_id = $this->artistFilmRepoInter->wherePluck('film_id', $id, 'artist_id');
                if (!empty($list_artist_film_id)) {
                    $list_artist_film_id_delete = array_diff($list_artist_film_id, $data['actors']);
                    $this->artistFilmRepoInter->multiDelete('artist_id', $list_artist_film_id_delete);
                }
                foreach($data['actors'] as $value) {
                    $artist_film = $this->artistFilmRepoInter->wherewhere('artist_id', $value, 'film_id', $film['id']);
                    if(count($artist_film) == 0) {
                        $this->artistFilmRepoInter->create(['artist_id' => $value, 'film_id' => $film['id']]);
                    }
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }

        return redirect()->route('client.account.index');
    }

    public function search(Request $request)
    {
        $listFilm = $this->filmRepoInter->search($request->search);
        $path_image = asset('') . $this->path_image;

        return view('client.search', ['listFilm' => $listFilm, 'path_image' => $path_image]);
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $this->filmRepoInter->delete($id);
            $this->artistFilmRepoInter->whereDelete('film_id', $id);
            $this->cateFilmRepoInter->whereDelete('film_id', $id);
            $this->videoRepoInter->whereDelete('film_id', $id);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            
            throw new Exception($e->getMessage());
        }

        return response()->json(['success' => 'Xóa thành công']);
    }
}