<div id="edit-group-modal" class="modal group-modal">
  	<h3 class="font-semibold mb-6 text-2xl text-center">@lang('site.edit_your_group')</h3>

	<form-component 
			cur-action="{{ route('groups.update', $group) }}"
			cur-method="patch"
		>
		<template slot-scope="{ form }">
			@csrf

			<div class="mb-4">
				<div class="mb-2">
					<span for="name" class="text-light">@lang('site.group_name')</span>
				</div>
		  	
			  	<div>
				  	<input 
						name="name" id="name" placeholder="@lang('site.group_name')" 
						class="border rounded p-2 w-full" 
						:class="{ 'border-red-300':form.errors.has('name') }"
						value="{{ $group->name }}" 
					>
					
					<span class="text-red-400 italic" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
				</div>
			</div>

			<div class="mb-4">
				<div class="mb-2">
					<span for="description" class="text-light">@lang('site.group_description')</span>
				</div>
		  	
			  	<div>
				  	<textarea 
						name="description" id="description" placeholder="@lang('site.group_description')" 
						class="border rounded p-2 w-full" 
						rows="4">{{ $group->description }}</textarea>

					<span class="text-red-400 italic" v-if="form.errors.has('description')" v-text="form.errors.get('description')"></span>
				</div>
			</div>

			<div class="flex justify-between items-center">
				<button class="button-primary ml-auto">@lang('site.save')</button>
			</div>
		</template>
	</form-component>
</div>