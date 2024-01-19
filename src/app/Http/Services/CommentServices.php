<?php

namespace App\Http\Services;

use App\Models\Comment;

class CommentServices
{
    function prepareCommentQueryWithSort($request = null, $urlWithParameters)
    {
        $commentsQuery = Comment::where('parentCommentID', null)->with('user');
        $sortOrder = 'DESC';
        $sortAttribute = '';

        $urlWithParameters = strstr($urlWithParameters, '&') ? $urlWithParameters : null;

        if ($request) {
            $sortAttribute = $request;

            strncmp($sortAttribute, '-', 1) !== 0 ? $sortOrder = 'ASC' : $sortAttribute = substr($sortAttribute, 1);

            if ($sortAttribute === 'userName') {
                $commentsQuery = $this->sortComments('userName', $sortOrder);
            } elseif ($sortAttribute === 'email') {
                $commentsQuery = $this->sortComments('email', $sortOrder);
            } elseif ($sortAttribute == 'created_at') {
                $commentsQuery = $this->sortComments('created_at', $sortOrder);
            } else {
                $commentsQuery->latest();
            }

        } else {
            $commentsQuery->latest();
        }

        return ['comments' => $commentsQuery, 'sort' => $sortOrder, 'sortAttribute' => $sortAttribute, 'urlWithParameters' => $urlWithParameters];
    }

    private function sortComments($sortAttribute, $sortOrder)
    {
        return Comment::whereNull('parentCommentID')
            ->join('users', 'comments.userID', '=', 'users.id')
            ->select('comments.*', 'users.userName', 'users.email', 'users.created_at')
            ->orderBy("users.$sortAttribute", $sortOrder);
    }
}
