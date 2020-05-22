<?php

namespace App\Http\Controllers\Comments;

use Image;
use Storage;
use App\Post;
use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post)
    {
        // validation
        $request->validate([
            'body' => 'required',
        ]);

        // create comment
        $comment = $post->addComment($request->all());

        return [
            'commentBody' => $comment->body,
            'commentId' => $comment->id,
            'commentPath' => $comment->path(),
            'message' => 'Your comment was added successfully'
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @param  \App\Post  $post
     */
    public function update(Request $request, Post $post, Comment $comment)
    {
        request()->validate([
            'body' => 'required'
        ]);

        abort_if(auth()->user()->cannot('update', $comment), 403);

        $comment->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, Comment $comment)
    {
        abort_if(auth()->user()->cannot('update', $comment), 403);

        $comment->delete();
    }
}
