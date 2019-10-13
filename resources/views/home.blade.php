@extends('layouts.app')

@section('content')
    <div class="lg:flex mt-16">
        <div class="lg:w-2/6 mx-2 sm:hidden lg:block">
            @if (count(peopleYouMayKnow()))
                {{-- Make new friends --}}
                <div class="card mb-8">
                    <div 
                        class="p-2 text-center border font-bold text-gray-700 rounded-lg" 
                        style="margin:-16px;margin-bottom:16px;background:rgb(247, 247, 247);"
                        >Make New Friends
                    </div>

                    <div>
                        @foreach(array_slice(peopleYouMayKnow(), 0, 3) as $user)
                            @include('users.people_you_may_know')
                        @endforeach

                        <div class="text-center text-primary mt-6">
                            <a href="/find_people">Find More</a>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Join new groups --}}
            @include('groups.groups_you_may_join')
        </div>

        <div class="lg:w-3/5 mx-2">
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

        @include('layouts.right_side')
    </div>


    {{-- Modals --}}
    @include('posts.edit-modal')
    @include('groups.create-modal')

@endsection