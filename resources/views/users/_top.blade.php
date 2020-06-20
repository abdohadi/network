{{-- Errors for profile_picture and profile_cover --}}
@if (auth()->user()->is($user))
	@if ($errors->has('profile_picture') || $errors->has('profile_cover'))
		<ul 
			class="bg-white border absolute z-10 r-0 right-0 pl-2 pr-6 pt-6 pb-2" 
			style="border-top: 6px solid red;top: 105px;max-width: 396px;">
			<span 
				class='absolute text-gray-500 cursor-pointer text-sm hover:font-bold' 
				style='right: 17px;top: 7px;' 
				title='Close'
				onclick='script: this.parentElement.style.display = "none"' 
			>X</span>

			@foreach ($errors->all() as $error)
				<div class="flex py-4 ">
					<div class="text-center" style="width: 31px;">
						<span class="rounded-full text-red-700 bg-red-200 text-sm" style="padding: 1px 6px">x</span>
					</div>

					<div class="break-normal px-4 text-red-600">
						<li>{{ $error }}</li>
					</div>
				</div>
			@endforeach
		</ul>
	@endif
@endif

<div class="relative" style="height:300px;">
	{{-- Profile cover --}}
	<a href="{{ asset('/uploads/images/user_images/covers/' . $user->profile_cover) }}" target="_blank">
		<img 
			src="{{ '/uploads/images/user_images/covers/' . $user->profile_cover }}" 
			class="cover-img w-full h-full" >
	</a>

	@if(auth()->user()->is($user))
		{{-- Change cover --}}
		<div class="absolute p-2" style="top: 13px;left: 13px;background: #333">
			<button class="change-cover-btn border border-gray-500 text-gray-500 py-2 rounded-full px-4 hover:border-blue-400 hover:text-blue-400">@lang('site.change_cover')</button>

			<form 
				class="profile-cover-form hidden ml-2" 
				action="{{ route('users.update_cover', auth()->user()) }}" 
				method="POST" 
				enctype="multipart/form-data"
			>
				@csrf
				@method('PATCH')

				<input class="cover-input hidden" type="file" name="profile_cover">

				<button 
					class="cancel-cover-btn button-outline-secondary mt-1" 
					style="font-size: 12px" 
					data-cover-src="{{ '/uploads/images/user_images/covers/' . $user->profile_cover }}"
				>@lang('site.cancel')</button>
				<button 
					class="submit-cover-btn button-outline-primary" 
					style="font-size: 12px"
				>@lang('site.save')</button>
			</form>
		</div>
	@endif


	{{-- Profile Picture section --}}
	@if(auth()->user()->is($user))
		<div class="flex items-center">
			<div 
				class="profile-pic-parent-overlay" 
				style="width: 163px; overflow: hidden; border-radius: 50%; position: absolute; height: 164px; z-index: 10; bottom: -16px; left: 57px;">
				<div 
					class="profile-pic-overlay hidden text-gray-200 text-center cursor-pointer absolute" style="width: 166px;background: #000000c9;height: 109px;border-radius: 0px 0 50% 50%;top: 91px;">
					<div><i class="fa fa-camera mt-4 text-2xl mb-1"></i></div>

					<div class="font-bold">@lang('site.change')</div>
				</div>
				
				{{-- Show profile pic --}}
				<div 
					class="show-pic-overlay text-gray-200 text-center absolute hidden" 
					style="width: 165px;background: #000000c9;height: 109px;border-radius: 50% 50% 0 0;top: -18px;"
				>
					<a href="{{ getProfilePicture($user, 60) }}" target="_blank">
						<span 
							class="py-2 px-3 border border-gray-500 text-gray-500 rounded-full relative hover:border-blue-400 hover:text-blue-400"
							style="top: 53px;"
						>@lang('site.show')</span>
					</a>
				</div>

				{{-- Update profile picture form --}}
				<div 
					class="profile-form-pic-overlay text-gray-200 text-center absolute hidden" 
					style="width: 164px;background: #000000c9;height: 105px;border-radius: 50% 50% 0 0;top: -14px;"
				>
					<form 
						class="profile-picture-form" 
						action="{{ route('users.update_picture', auth()->user()) }}" 
						method="post" 
						enctype="multipart/form-data"
					>
						@csrf
						@method('PATCH')

						<input class="hidden profile-picture-input" type="file" name="profile_picture">

						<button 
							class="button-outline-primary submit-profile-pic-btn block m-auto mt-10" 
							style="font-size: 11px"
						>@lang('site.save')</button>
					</form>

					<button 
						class="button-outline-secondary cancel-profile-pic-btn mt-1" 
						style="font-size: 11px" 
						data-pic-src="{{ getProfilePicture($user) }}"
					>@lang('site.cancel')</button>
				</div>
			</div>

			{{-- Profile picture --}}
			<img 
				class="profile-picture bg-gray-100 p-1 rounded-full absolute"
				src="{{ getProfilePicture($user, 60) }}" 
				style="width: 170px;height: 170px;left: 53px;bottom: -19px;">

			<span class="text-2xl text-white font-bold ml-8 mt-16 absolute" style="left: 222px; bottom: 30px;">{{ $user->name }}</span>
		</div>
	@else
		<a href="{{ getProfilePicture($user, 60) }}" target="_blank">
			<img 
				class="profile-picture bg-gray-100 p-1 rounded-full absolute"
				src="{{ getProfilePicture($user, 60) }}" 
				style="width: 170px;height: 170px;left: 52px;bottom: -19px;">
		</a>
	@endif

	@if ($user->isNot(auth()->user()))
		<div class="absolute px-5 py-2 bg-white rounded-sm" style="right:15px;bottom:20px">
			@if (auth()->user()->sentFriendRequests->contains($user))
				{{-- Cancel Friend Request Form --}}
				@include('users._cancel_request_form')
	      	@else
	      		{{-- Send Friend Request Form --}}
				@include('users._send_request_form')
	      	@endif
    	</div>
  	@endif
</div>