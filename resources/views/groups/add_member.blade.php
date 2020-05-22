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
					<div class="card">
				   		<div class="text-lg text-gray-700 mb-4 mb-6 pb-2" style="border-bottom: 1px solid #eee;">
							<i class="fa fa-user-plus mr-1"></i> @lang('site.add_member_from_friends')</small>
				   		</div>

						<div>
						   @forelse (auth()->user()->friends as $friend)
								<div class="flex items-center mb-4 relative">
									<a href="{{ route('users.show', $friend) }}">
										<img src="{{ getProfilePicture($friend) }}" class="rounded-full w-16 mr-2" style="border:1px solid rgb(241, 239, 239);border-radius:50%" title="{{ $friend->name }}">
									</a> 

									<a href="{{ route('users.show', $friend) }}" class="text-gray-700 text-lg" title="{{ $friend->name }}">{{ $friend->name }}</a>								

				   					<div class="ml-auto flex">
								        <form-component 
								        	class="form-changes" 
								            cur-action="{{ route('groups.add_member', [$group, $friend]) }}"
								            cur-method="post"
								            new-action="{{ route('groups.remove_member', [$group, $friend]) }}"
								            new-method="delete"
								        >
								            @csrf
								  	        
								            <button-component
								              	cur-class="button-outline-primary"
								              	title="@lang('site.click_to_add_member')"
								              	value="@lang('site.add')"
								              	new-class="button-outline-secondary"
								              	new-title="@lang('site.click_to_remove')"
								              	new-value="@lang('site.remove')">
								            </button-component>
								        </form-component>
								    </div>
								</div>
							@empty
								<div>@lang('site.no_friends')</div>
					   		@endforelse
					   	</div>
					</div>
				</div>

				{{-- Right side --}}
				<div class="lg:w-2/6 sm:hidden lg:block lg:w-5/12 ml-4">
				   @include('groups._suggested_groups')
				</div>
			</div>
		</div>
   </div>

@endsection