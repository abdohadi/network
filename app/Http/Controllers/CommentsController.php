<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Image;
use Storage;
use Illuminate\Http\Request;

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

        // $attributes = ['body' => $request->body];

        // // resize & save image
        // if ($request->image) {
        //     Image::make($request->image)
        //         ->resize(300, null, function ($constraint) {
        //         $constraint->aspectRatio();
        //     })
        //     ->save(public_path('uploads/images/comment_images/' .$request->image->hashName()));

        //     $attributes['image'] = $request->image->hashName();
        // }

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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post, Comment $comment)
    {
        // validation
        request()->validate([
            'body' => 'required'
        ]);

        abort_if(auth()->user()->cannot('update', $comment), 403);

        // update comment
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
        // delete the image if exists
        // if ($comment->image) {
        //     Storage::disk('public_uploads')->delete("images/commment_images/{$comment->image}");
        // }

        abort_if(auth()->user()->cannot('update', $comment), 403);

        $comment->delete();
    }
}
