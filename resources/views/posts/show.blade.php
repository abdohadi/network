@extends('layouts.app')

@section('content')

	<div class="lg:flex mt-16">
		{{-- Left side --}}
		<div class="lg:w-1/4 mx-2 sm:hidden lg:block">
			@include('layouts._left_side')
		</div>

		<div class="lg:w-1/2 mx-2 xl:px-8">
			@include('posts._post')
		</div>

		{{-- Right side --}}
		<div class="lg:w-2/6 mx-2 sm:hidden lg:block">
			@include('layouts._right_side')
	   </div>
	</div>

@endsection