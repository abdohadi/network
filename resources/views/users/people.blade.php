<div class="lg:w-1/4 mx-2 sm:hidden lg:block">
	<div class="card">
		<div 
			class="p-2 bg-gray-400 text-center border font-bold text-gray-700 rounded-lg" 
			style="margin:-16px;margin-bottom:16px;background:rgb(247, 247, 247);"
		>Make new friends</div>

		<div>
			@forelse($users as $user)
				<div class="flex items-center mb-4">
          <a href="users/{{ $user->id }}">
              <img src="{{ gravatar($user->email) }}" class="rounded-full w-10 mr-2">
          </a> 
          <a href="users/{{ $user->id }}">
              <span class="text-gray-600 hover:text-gray-800">{{ $user->name }}</span>
          </a>
          <button class="button-outline hover:text-blue-500">Add friend</button>
      	</div>
			@empty
				<div>No users yet</div>
			@endforelse
		</div>
	</div>
</div>