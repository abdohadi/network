@extends('layouts.app')

@section('content')

	<div class="mt-20 card">
		<form-component 
			class="m-auto w-1/2" 
			url="{{ localizeURL(auth()->user()->path() . '/update_info') }}"
			method="patch"
		>
			<template slot-scope="{ form }">
				@csrf
				@method('PATCH')

				<div class="flex mb-4">
					<div class="mb-2 w-3/12 mt-2 text-center">
						<label for="name" class="text-gray-600 font-bold">@lang('site.name')</label>
					</div>
					
					<div class="w-5/6">
						<input 
							type="text" id="name" name="name" placeholder="@lang('site.your_name')" 
							value="{{ auth()->user()->name }}"
							class="border rounded py-2 px-4 w-full focus:border-blue-300" 
							:class="{ 'border-red-300':form.errors.has('name') }" 
						>

						<span class="text-red-400 italic" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
					</div>
				</div>

				<div class="flex mb-4">
					<div class="mb-2 w-3/12 mt-2 text-center">
						<label for="email" class="text-gray-600 font-bold">@lang('site.email_address')</label>
					</div>
					
					<div class="w-5/6">
						<input 
							type="email" id="email" name="email" placeholder="@lang('site.your_email_address')" 
							value="{{ auth()->user()->email }}"
							class="border rounded py-2 px-4 w-full focus:border-blue-300" 
							:class="{ 'border-red-300':form.errors.has('email') }"
						>
						
						<span class="text-red-400 italic" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></span>
					</div>
				</div>

				<div class="flex mb-4">
					<div class="mb-2 w-3/12 mt-2 text-center">
						<label for="Birth Date" class="text-gray-600 font-bold">@lang('site.birth_date')</label>
					</div>
					
					<div class="w-5/6">
						<input 
							type="date" id="Birth Date" name="birth_date" 
							value="{{ auth()->user()->birth_date }}"
							class="border rounded py-2 px-4 w-full focus:border-blue-300" 
							:class="{ 'border-red-300':form.errors.has('birth_date') }"
						>

						<span class="text-red-400 italic" v-if="form.errors.has('birth_date')" v-text="form.errors.get('birth_date')"></span>
					</div>
				</div>

				<div class="flex mb-4">
					<div class="mb-2 w-3/12 mt-2 text-center">
						<label for="address" class="text-gray-600 font-bold">@lang('site.address')</label>
					</div>
					
					<div class="w-5/6">
						<input 
							type="text" id="address" name="address" placeholder="@lang('site.your_address')" 
							value="{{ auth()->user()->address }}"
							class="border rounded py-2 px-4 w-full focus:border-blue-300" 
							:class="{ 'border-red-300':form.errors.has('address') }"
						>

						<span class="text-red-400 italic" v-if="form.errors.has('address')" v-text="form.errors.get('address')"></span>
					</div>
				</div>

				<div class="flex mb-4">
					<div class="mb-2 w-3/12 mt-2 text-center">
						<label for="phone" class="text-gray-600 font-bold">@lang('site.phone')</label>
					</div>
					
					<div class="w-5/6">
						<input 
							type="text" id="phone" name="phone" placeholder="@lang('site.your_phone')" 
							value="{{ auth()->user()->phone }}"
							class="border rounded py-2 px-4 w-full focus:border-blue-300" 
							:class="{ 'border-red-300':form.errors.has('phone') }"
						>

						<span class="text-red-400 italic" v-if="form.errors.has('phone')" v-text="form.errors.get('phone')"></span>
					</div>
				</div>

				<div class="flex mb-4">
					<div class="mb-2 w-3/12 mt-2 text-center">
						<label for="gender" class="text-gray-600 font-bold">@lang('site.gender')</label>
					</div>
					
					<div class="w-5/6">
						<select 
							name="gender" id="gender" 
							class="border rounded py-2 px-4 w-full focus:border-blue-300"
							:class="{ 'border-red-300':form.errors.has('gender') }"
						>
							<option value="" {{ auth()->user()->gender == '' ? 'selected' : '' }}>@lang('site.choose_your_gender')</option>
							<option value="male" {{ auth()->user()->gender == 'male' ? 'selected' : '' }}>@lang('site.male')</option>
							<option value="female" {{ auth()->user()->gender == 'female' ? 'selected' : '' }}>@lang('site.female')</option>
						</select>

						<span class="text-red-400 italic" v-if="form.errors.has('gender')" v-text="form.errors.get('gender')"></span>
					</div>
				</div>

				<div class="flex mb-4">
					<div class="mb-2 w-3/12 mt-2 text-center">
						<label for="college" class="text-gray-600 font-bold">@lang('site.college')</label>
					</div>
					
					<div class="w-5/6">
						<input 
							type="text" id="college" name="college" placeholder="@lang('site.your_college')" 
							value="{{ auth()->user()->college }}"
							class="border rounded py-2 px-4 w-full focus:border-blue-300" 
							:class="{ 'border-red-300':form.errors.has('college') }"
						>

						<span class="text-red-400 italic" v-if="form.errors.has('college')" v-text="form.errors.get('college')"></span>
					</div>
				</div>

				<div class="flex mb-4">
					<div class="mb-2 w-3/12 mt-2 text-center">
						<label for="bio" class="text-gray-600 font-bold">@lang('site.bio')</label>
					</div>
					
					<div class="w-5/6">
						<textarea 
							id="bio" name="bio" placeholder="@lang('site.your_bio')"
							class="border rounded py-2 px-4 w-full focus:border-blue-300" 
							:class="{ 'border-red-300':form.errors.has('bio') }"
						>{{ auth()->user()->bio }}</textarea>

						<span class="text-red-400 italic" v-if="form.errors.has('bio')" v-text="form.errors.get('bio')"></span>
					</div>
				</div>

				<div class="flex">
					<button class="button-primary ml-auto">@lang('site.save')</button>
				</div>
			</template>
		</form-component>
	</div>

@endsection