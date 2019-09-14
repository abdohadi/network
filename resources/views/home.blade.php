@extends('layouts.app')

@section('content')
    <div class="lg:flex">
        <div class="lg:w-1/4 mx-2 sm:hidden lg:block">
            {{-- Make new friends --}}
            @include('users.people_you_may_know')

            {{-- Join new groups --}}
            @include('groups.groups_you_may_join')
        </div>

        <div class="lg:w-1/2 mx-2">
            {{-- Create New Post --}}
            <div class="card mb-4">
                @include('posts.form', [
                    'action' => '/posts',
                    'submit_value' => 'Post',
                    'submit_id' => 'submit-create-post',
                ])
            </div>

            {{-- Show Posts --}}
            @forelse($posts as $post)
                @include('posts.post')
            @empty
                <div class="card">No posts yet</div>
            @endforelse
        </div>

        <div class="card lg:w-1/4 mx-2 sm:hidden lg:block">
            <a href="#group-modal" rel="modal:open" class="button-primary open-group-modal">Create Group</a>
            <ul>
                <li><a href="">friends</a></li>
                <li><a href="/groups">Groups <span>{{ count(auth()->user()->groups) }}</span></a></li>
                <li><a href="">Pages</a></li>
                <li><a href="">Sittings</a></li>
            </ul>
        </div>
    </div>


    {{-- Modals --}}
    @include('posts.edit-modal')
    @include('groups.create-modal')

@endsection