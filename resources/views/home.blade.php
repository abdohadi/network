@extends('layouts.app')

@section('content')
    <div class="lg:flex mt-16">
        {{-- Left side --}}
        <div class="lg:w-1/4 mx-2 sm:hidden lg:block">
            @include('layouts._left_side')
        </div>

        <div class="lg:w-3/6 mx-2 xl:px-8">
            {{-- Create New Post --}}
            <div class="card mb-4">
                @include('posts._form', [
                    'action' => '/posts',
                    'type' => 'post',
                    'submit_value' => 'Post',
                    'submit_id' => 'submit-create-post',
                ])
            </div>

            {{-- Show Posts --}}
            @forelse($posts as $post)
                @include('posts._post')
            @empty
                <div class="card">No posts yet</div>
            @endforelse
        </div>

        {{-- Right side --}}
        <div class="lg:w-2/6 mx-2 sm:hidden lg:block">
            @include('layouts._right_side')
        </div>
    </div>

@endsection