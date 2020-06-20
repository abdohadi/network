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
				<div class="lg:w-8/12 xl:pr-4">
					{{-- Create New Post --}}
					@if (auth()->user()->can('create-post', $group))
						<div class="card mb-4">
							<form action="{{ route('groups.posts.store', $group) }}" method="post">
								@csrf

								<div class="mb-4">
							  		<textarea 
										name="body" 
										id="body" 
										placeholder="@lang('site.what_is_in_your_mind')" 
										class="border w-full p-2 rounded"
										rows="2"></textarea>

									<span class="post-error text-red-500 italic text-sm"></span>
								</div>

								<div class="flex justify-between items-center">
									<input type="submit" class="button-primary ml-auto" value="@lang('site.post_it')">
								</div>
							</form>
						</div>

						@forelse($group->posts as $post) 
							@include('posts._post')
						@empty
							<div class="card">@lang('site.no_posts_yet')</div>
						@endforelse
			      	@endif
				</div>

				{{-- Right side --}}
				<div class="lg:w-2/6 sm:hidden lg:block lg:w-5/12 ml-4">
				   @include('groups._suggested_groups')
				</div>
			</div>
		</div>
    </div>	

@endsection