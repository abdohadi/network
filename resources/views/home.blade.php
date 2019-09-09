@extends('layouts.app')

@section('content')
    <div class="lg:flex">
        {{-- Make new friends --}}
        @include('users.people')

        <div class="lg:w-1/2 mx-2">
            {{-- Create New Post --}}
            <div class="card mb-4">
                @include('posts.form', [
                    'action' => '/posts',
                    'submit_value' => 'Post',
                    'submit_id' => 'submit-create',
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
            right
        </div>
    </div>


    @include('posts.edit-modal')

@endsection