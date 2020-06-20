@extends('layouts.app')

@section('content')
	
	<div class="lg:px-32">
		@include('users._top')

		{{-- Friends section --}}
		<div class="mt-8">
			<div class="p-4" style="background:#f5f6f7;">
				<h3 class="text-3xl font-bold text-gray-700">
					<i class="text-2xl mr-2 fa fa-users text-gray-500"></i> @lang('site.friends')
				</h3>
			</div>

			{{-- Toggling between lists - Handled by vue --}}
			<div id="friends-list-toggling" class="friends-list relative">
				<ul class="flex" style="background:#f5f6f7;">
					<li class="text-lg font-medium mr-5 text-link cursor-pointer hover:text-gray-700 active p-4"
						:class="{ 'bg-white' : selectedList == 'friends-list' }" 
						@click="selectedList = 'friends-list'">@lang('site.all_friends')</li>

					@if (auth()->check() && $user->is(auth()->user()))
						<li class="text-lg font-medium mr-5 text-link cursor-pointer hover:text-gray-700 p-4" 
							:class="{ 'bg-white' : selectedList == 'sent-requests-list' }" 
							@click="selectedList = 'sent-requests-list'">@lang('site.sent_requests')</li>

						<li class="text-lg font-medium text-link cursor-pointer hover:text-gray-700 p-4" 
							:class="{ 'bg-white' : selectedList == 'received-requests-list' }" 
							@click="selectedList = 'received-requests-list'">@lang('site.received_requests')</li>
					@endif
				</ul>
				
				{{-- Friends list --}}
				<div class="bg-white p-4 flex flex-wrap absolute w-full list" :class="{ 'hidden' : selectedList != 'friends-list' }">
					@forelse($user->friends as $friend)
						<div class="px-1 lg:w-1/2 w-full">
							<div class="flex mb-4 border border-gray-200">
								<div class="w-1/3">
									<a href="{{ route('users.show', $friend) }}">
										<img 
											src="{{ getProfilePicture($friend) }}"
											style="width:140px;height:140px;border:1px solid #f9f9f9;">
									</a>
								</div>

								<div class="w-2/3">	
									<div class="mr-2 mb-auto mt-3 ">
										@if(auth()->check())
											@if($user->is(auth()->user()) || auth()->user()->friends->contains($friend))
												<div class="ml-auto mr-2 mb-auto mt-3 text-right">
													{{-- Unfriend a friend --}}
													<a href="#unfriend-modal" rel="modal:open" class="button-outline-secondary">@lang('site.unfriend')</a>
													
			                                        @include('users._unfriend_modal')
												</div>
											@elseif($user->isNot(auth()->user()) && $friend->isNot(auth()->user()))
												@if(auth()->user()->sentFriendRequests->contains($friend))
												    {{-- Cancel Friend Request Form --}}
													@include('users._cancel_request_form')
												@elseif(auth()->user()->receivedFriendRequests->contains($friend))
								                    <div class="flex ml-auto mr-2 mb-auto mt-3">
			                                            <div>
			                                                {{-- Accept Friend Request Form --}}
			                                                @include('users._accept_request_form')
			                                            </div>

			                                            <div class="ml-1">
			                                                {{-- Delete Friend Request Form --}}
			                                                @include('users._delete_request_form')
			                                            </div>
			                                        </div>
								                @else
								                  	{{-- Send Friend Request Form --}}
			                                        @include('users._send_request_form')
												@endif
											@endif
										@endif
									</div>

									<div class="p-2 pr-6">	
										<a href="{{ route('users.show', $friend) }}">
											<span class="text-xl text-link" title="{{ $friend->name }}">
												{{ substr($friend->name, 0, 15) . (strlen($friend->name) > 15 ? '...' : '') }}
											</span>
										</a>

										<p class="text-gray-600 mt-2">{{ substr($friend->bio, 0, 50) . (strlen($friend->bio) > 50 ? '...' : '') }}</p>
									</div>
								</div>
							</div>
						</div>
					@empty
						@lang('site.no_friends')
					@endforelse
				</div>

				@if (auth()->check() && $user->is(auth()->user()))
					{{-- Sent requests list --}}
					<div class="bg-white p-4 flex flex-wrap absolute w-full list" :class="{ 'hidden' : selectedList != 'sent-requests-list' }">
						@forelse($user->sentFriendRequests as $friend)
							<div class="px-1 lg:w-1/2 w-full">
								<div class="flex mb-4 border border-gray-200">
									<div class="w-1/3">
										<a href="{{ route('users.show', $friend) }}">
											<img 
												src="{{ getProfilePicture($friend) }}"
												style="width:140px;height:140px;border:1px solid #f9f9f9;">
										</a>
									</div>

									<div class="w-2/3">	
										<div class="mr-2 mb-auto mt-3 text-right">
										    {{-- Cancel Friend Request Form --}}
											@include('users._cancel_request_form', ['user' => $friend])
										</div>

										<div class="p-2 pr-6">	
											<a href="{{ route('users.show', $friend) }}">
												<span class="text-xl text-link" title="{{ $friend->name }}">
													{{ substr($friend->name, 0, 15) . (strlen($friend->name) > 15 ? '...' : '') }}
												</span>
											</a>

											<p class="text-gray-600 mt-2">{{ substr($friend->bio, 0, 50) . (strlen($friend->bio) > 50 ? '...' : '') }}</p>
										</div>
	                                </div>
								</div>
							</div>
						@empty
							@lang('site.no_requests_have_been_sent')
						@endforelse
					</div>

					{{-- Received requests list --}}
					<div class="bg-white p-4 flex flex-wrap absolute w-full list" :class="{ 'hidden' : selectedList != 'received-requests-list' }">
						@forelse($user->receivedFriendRequests as $friend)
							<div class="px-1 lg:w-1/2 w-full user-box-{{$friend->id}}">
								<div class="flex mb-4 border border-gray-200">
									<div class="w-1/3">
										<a href="{{ route('users.show', $friend) }}">
											<img 
												src="{{ getProfilePicture($friend) }}"
												style="width:140px;height:140px;border:1px solid #f9f9f9;">
										</a>
									</div>

									<div class="w-2/3">	
									    <div class="flex mr-2 mt-3">
	                                        <div class="ml-auto">
	                                            {{-- Accept Friend Request Form --}}
	                                            @include('users._accept_request_form', ['user' => $friend])
	                                        </div>

	                                        <div class="ml-1">
	                                            {{-- Delete Friend Request Form --}}
	                                            @include('users._delete_request_form', ['user' => $friend])
	                                        </div>
	                                    </div>

										<div class="p-2 pr-6">	
											<a href="{{ route('users.show', $friend) }}">
												<span class="text-xl text-link" title="{{ $friend->name }}">
													{{ substr($friend->name, 0, 15) . (strlen($friend->name) > 15 ? '...' : '') }}
												</span>
											</a>

											<p class="text-gray-600 mt-2">{{ substr($friend->bio, 0, 50) . (strlen($friend->bio) > 50 ? '...' : '') }}</p>
										</div>
	                                </div>
								</div>
							</div>
						@empty
							@lang('site.no_requests_have_been_received')
						@endforelse
					</div>
				@endif
			</div>
		</div>
	</div>

@endsection