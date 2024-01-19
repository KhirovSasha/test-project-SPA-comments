<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Http\Resources\UserResource;
use App\Http\Services\CommentServices;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MainPageController extends Controller
{
    protected $commentServices;

    public function __construct(CommentServices $commentServices)
    {
        $this->commentServices = $commentServices;
    }

    public function index()
    {
        $sortQuery = request()->query('sort');
        $urlWithParameters = request()->getRequestUri();

        $commentsResult = $this->commentServices->prepareCommentQueryWithSort($sortQuery, $urlWithParameters);

        $comments = $commentsResult['comments']->paginate(25);

        return Inertia::render('MainPage', [
            'comments' => CommentResource::collection($comments),
            'sort' => $commentsResult['sort'],
            'urlWithParameters' => $commentsResult['urlWithParameters'],
            'sortAttribute' => $commentsResult['sortAttribute']
        ]);
    }



}
