<?php

namespace App;

use App\Post;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name', 'description', 'visibility', 'cover', 'user_id'];

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function path()
    {
        return route('groups.show', $this);
    }

    public function owner()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Accepted and not accepted users but not admins
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'group_member', 'group_id', 'member_id')
                    ->withPivot('member_status', 'member_position')
                    ->withTimestamps();
    }

    public function admins()
    {
        return $this->members()
                    ->wherePivot('member_position', 'admin');
    }

    public function joinRequests()
    {
        return $this->members()
                    ->wherePivot('member_status', 'pending');
    }

    public function acceptedMembers()
    {
        return $this->members()
                    ->wherePivot('member_status', 'accepted');
    }

    public function join(User $user)
    {
    	$this->joinRequests()->attach($user, ['member_status' => 'pending']);
    }

    public function acceptRequest(User $user)
    {
        $this->joinRequests()
            ->find($user->id)
            ->pivot
            ->update(['member_status' => 'accepted']);
    }

    public function removeRequest(User $user)
    {
        $this->joinRequests()->detach($user);
    }

    public function addMember(User $user)
    {
        $this->acceptedMembers()->attach($user, ['member_status' => 'accepted']);
    }

    public function removeMember(User $user)
    {
        $this->acceptedMembers()->detach($user);
    }

    public function assignAdmin(User $member)
    {
        $this->acceptedMembers()
            ->find($member->id)
            ->pivot
            ->update(['member_position' => 'admin']);
    }

    public function dismissAdmin(User $admin)
    {
        $this->admins()
            ->find($admin->id)
            ->pivot
            ->update(['member_position' => 'regular_member']);
    }

    public function hasAdmin(User $member)
    {
        return $this->admins->contains($member);
    }

    public function hasAcceptedMember(User $member)
    {
        return $this->acceptedMembers->contains($member);
    }

    public function hasRequest(User $user)
    {
        return $this->joinRequests->contains($user);
    }

    public function posts()
    {
        return $this->hasMany(Post::class)->latest();
    }
}
