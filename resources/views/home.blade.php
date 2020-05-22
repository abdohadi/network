@extends('layouts.app')

@section('content')

    <div class="lg:flex mt-16">
        {{-- Left side --}}
        <div class="lg:w-1/5 mx-2 sm:hidden lg:block">
            @include('layouts._left_side')
        </div>

        <div class="lg:w-7/12 mx-2 xl:px-8">
            {{-- Create New Post --}}
            <div class="card mb-4">
                @include('posts._create_post_form')
            </div>

            {{-- Show Posts --}}
            @forelse($posts as $post)
                @include('posts._post')
            @empty
                <div class="card">@lang('site.no_posts_yet')</div>
            @endforelse
        </div>

        {{-- Right side --}}
        <div class="lg:w-2/6 mx-2 sm:hidden lg:block">
            {{-- Make new friends --}}
            @include('users._people_you_may_know')

            {{-- Join new groups --}}
            @include('groups._suggested_groups')
        </div>
    </div>

@endsection