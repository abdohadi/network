<div class="mb-4 relative" style="height:300px;">
	<a href="{{ asset('/uploads/images/group_covers/' . $group->cover) }}" target="_blank">
		<img src="{{ '/uploads/images/group_covers/' . $group->cover }}" class="h-full w-full" alt="cover">
	</a>

	@if (auth()->user()->isNot($group->owner))
		<div class="absolute px-5 py-2 bg-white rounded-sm" style="left:15px;bottom:20px;">
			@if ($group->hasAcceptedMember(auth()->user()))
				<div class="py-2">
			        <a href="#leave-group-modal" rel="modal:open" class="button-secondary font-bold" style="padding:14px 25px;width: 146px;">@lang('site.leave_group')</a>
				</div>
	      	@elseif ($group->hasRequest(auth()->user()))
		        <form-component 
		            class="form-changes" 
		            cur-action="{{ route('groups.cancel_request', $group) }}"
		            cur-method="delete"
		            new-action="{{ route('groups.join', $group) }}"
		            new-method="post"
		        >
		            @csrf
		  	        
		            <button-component
		              	cur-class="button-secondary font-bold"
		              	title="@lang('site.click_to_cancel_the_request')"
		              	value="@lang('site.cancel_request')"
		              	new-title="@lang('site.click_to_send_a_join_request')"
		              	new-value="<i class='fa fa-plus'></i> @lang('site.join_group')"
		              	new-class="button-primary font-bold"
			            style="padding:10px;width: 146px;">
		            </button-component>
		        </form-component>
	      	@else
			    <form-component 
		            class="form-changes" 
		            cur-action="{{ route('groups.join', $group) }}"
		            cur-method="post"
		            new-action="{{ route('groups.cancel_request', $group) }}"
		            new-method="delete"
		        >
		            @csrf
		  	        
		            <button-component
		              	cur-class="button-primary font-bold"
		              	title="@lang('site.click_to_send_a_join_request')"
		              	value="<i class='fa fa-plus'></i> @lang('site.join_group')"
		              	new-title="@lang('site.click_to_cancel_the_request')"
		              	new-value="@lang('site.cancel_request')"
		              	new-class="button-secondary font-bold"
			            style="padding:10px;width: 146px;">
		            </button-component>
		        </form-component>
	      	@endif
		</div>
	@endif
</div>