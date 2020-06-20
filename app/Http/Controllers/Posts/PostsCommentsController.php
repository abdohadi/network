<?php

namespace App\Http\Controllers\Posts;

use Image;
use Storage;
use App\Post;
use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsCommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage,comment')->only(['update', 'destroy']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post)
    {
        // validation
        $attributes = $request->validate([
            'body' => 'required',
        ]);

        // create comment
        $comment = $post->addComment($attributes);

        return [
            'commentBody' => $comment->body,
            'commentId' => $comment->id,
            'deleteCommentUrl' => route('posts.comments.destroy', [$post, $comment]),
            'updateCommentUrl' => route('posts.comments.update', [$post, $comment]),
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
        $attributes = request()->validate([
            'body' => 'required'
        ]);

        $comment->update($attributes);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, Comment $comment)
    {
        $comment->delete();
    }
}
