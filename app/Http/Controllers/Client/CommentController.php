<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\Comment\CommentRepositoryInterface;
use App\Events\NewComment;
use App\Repositories\Admin\Video\VideoRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Admin\Film\FilmRepositoryInterface;

class CommentController extends Controller
{
    public function __construct(
        CommentRepositoryInterface $commentRepoInter, 
        VideoRepositoryInterface $videoRepoInter,
        FilmRepositoryInterface $filmRepoInter
    )
    {
        $this->commentRepoInter = $commentRepoInter;
        $this->videoRepoInter = $videoRepoInter;
        $this->filmRepoInter = $filmRepoInter;
    }

    public function index($type, $id)
    {
        if ($type == 'news') {
            $listComments = $this->commentRepoInter->with('user')->where('news_id', $id)->latest()->get();
        } elseif ($type == 'videos') {
            $listComments = $this->commentRepoInter->with('user')->where('video_id', $id)->latest()->get();
        } elseif ($type == 'film') {
            $listComments = $this->commentRepoInter->with('user')->where('film_id', $id)->whereNotNull('rating')->latest()->get();
        }
        foreach ($listComments as $key => $value) {
            if ($value->created_at != $value->updated_at) {
                $diff = formatTimeDate($value->updated_at);
                $updated = true;
            } else {
                $diff = formatTimeDate($value->created_at);
                $updated = false;
            }
            $listComments[$key]['diff'] = $diff;
            $listComments[$key]['updated'] = $updated;
            $listComments[$key]['path_image'] = asset('') . config('admin.default_folder_image');
        }
        return response()->json(
          $listComments
      );
    }

    public function store($type, $id, Request $request)
    {
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        if ($type == 'news') {
            $rules = [
                'body' => 'required'
            ];
            $messages = [
                'body.required' => 'Mời bạn nhập nội dung bình luận'
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422); 
            }
            $data['news_id'] = $id;
            $data['film_id'] = $id;
            $comment = $this->commentRepoInter->create(
              $data
            );
            $comment = $this->commentRepoInter->with('user')->find($comment->id);
            $comment['diff'] = formatTimeDate($comment['created_at']);
            $comment['updated'] = false;   
        } elseif ($type == 'videos') {
            $rules = [
                'body' => 'required'
            ];
            $messages = [
                'body.required' => 'Mời bạn nhập nội dung bình luận'
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422); 
            }
            $data['video_id'] = $id;
            $data['film_id'] = $id;
            $comment = $this->commentRepoInter->create(
              $data
            );
            $comment = $this->commentRepoInter->with('user')->find($comment->id);
            $comment['diff'] = formatTimeDate($comment['created_at']);
            $comment['updated'] = false;
        } elseif ($type == 'film') {
            $rules = [
                'rating' => 'required'
            ];
            $messages = [
                'rating.required' => 'Mời bạn nhập đánh giá phim'
            ];
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422); 
            }
            $comments = $this->commentRepoInter->wherewhere('film_id', $id, 'user_id', $data['user_id']);
            if (count($comments) > 0) {
                $this->commentRepoInter->update($comments[0]->id, $data);
                $comment = $this->commentRepoInter->with('user')->find($comments[0]->id);
                $comment['diff'] = formatTimeDate($comment['updated_at']);
                $comment['updated'] = true;
            } else {
                $data['film_id'] = $id;
                $comment = $this->commentRepoInter->create(
                  $data
                );
                $comment = $this->commentRepoInter->with('user')->find($comment->id);
                $comment['diff'] = formatTimeDate($comment['created_at']);
                $comment['updated'] = false;
            }
            $listRating = $this->commentRepoInter->where('film_id', $id)->pluck('rating')->toArray();
            $total_rating = (!empty($listRating)) ? round(array_sum($listRating)/count($listRating), 1) : 0;
            $this->filmRepoInter->update($id, ['rating' => $total_rating]);
        }
        $comment['path_image'] = asset('') . config('admin.default_folder_image');
        broadcast(new NewComment($comment))->toOthers();

        return $comment;
    }

    public function edit($type, $id)
    {
        $comment = $this->commentRepoInter->wherewhere('film_id', $id, 'user_id', auth()->user()->id);

        return $comment[0];
    }
}
