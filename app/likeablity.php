<?php

namespace App;

trait likeablity {
    public function like()
    {
        $this->likes()->create(['user_id' => auth()->id()]);
    }

    public function unlike()
    {
        $this->likes()->where(['user_id' => auth()->id()])->delete();
    }

    public function toggleLike()
    {
        $this->isLiked() ? $this->unlike() : $this->like();

        return $this->likesCount;
    }

    public function isLiked()
    {
        return !! $this->likes()->where('user_id', auth()->id())->count();
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }
}