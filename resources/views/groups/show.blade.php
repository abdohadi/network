@extends('layouts.app')

@section('content')

	<div class="lg:flex mt-16 px-8">
      	{{-- Left side --}}
		<div class="lg:w-1/5 mx-2 sm:hidden lg:block">
			@include('groups._left_side')
		</div>

		<div class="lg:w-4/5 lg:ml-2 xl:ml-6">
			@include('groups._top_side')

			<div class="flex">
				<div class="lg:w-8/12 xl:pr-8">
				   {{-- Create New Post --}}
				   {{-- <div class="card mb-4">
				       @include('posts._create_post_form')
				   </div> --}}

				   {{-- Show Posts --}}
				   {{-- @forelse($group->posts as $post)
				       @include('posts._post')
				   @empty
				       <div class="card">@lang('site.no_posts_yet')</div>
				   @endforelse --}}
				</div>

				{{-- Right side --}}
				<div class="lg:w-2/6 sm:hidden lg:block lg:w-5/12 ml-4">
				   @include('groups._suggested_groups')
				</div>
			</div>
		</div>
    </div>	

@endsection