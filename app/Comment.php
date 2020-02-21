<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
   protected $guarded = [];

   public function owner()
   {
   	return $this->belongsTo('App\User', 'user_id');
   }

   public function post()
   {
   	return $this->belongsTo('App\Post');
   }

   public function path()
   {
   	return "{$this->post->path()}/comments/$this->id";
   }
}
