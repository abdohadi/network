<div class="card post mb-4" style="box-shadow: none;">
    <div class="relative">
        @can('update', $post->sharedPost)
            <i class="show-options fa fa-ellipsis-h w-5 absolute right-0 mr-2 text-2xl text-gray-500 hover:text-gray-600 cursor-pointer"></i>
        @endcan

        {{-- Post options --}}
        <div class="options absolute card mr-10 right-0 text-center w-40 cursor-auto" style="top:-8px;display:none">
        	<ul>
                {{-- Link to open the edit-post modal --}}
        		<a data-post="{{ $post->sharedPost }}" href="#post-modal" rel="modal:open" class="open-post-modal">
        			<li class="cursor-pointer hover:text-gray-900 text-gray-600 py-1" id="open-post-modal">@lang('site.edit')</li>
        		</a>

                {{-- Delete Post --}}
                <form action="{{ localizeURL($post->sharedPost->path()) }}" method="post">
                    @method("DELETE")
                    @csrf

    			    <button id="delete-btn"
                            class="cursor-pointer hover:text-gray-900 text-gray-600 py-1" 
                            onclick="if (! confirm('Are you sure you want to delete your post?')) return false;"
                            >@lang('site.delete')
                    </button>
                </form>
        	</ul>
        </div>

        <div class="flex items-center">
            <a href="{{ $post->sharedPost->owner->path() }}">
                <img src="{{ gravatar($post->sharedPost->owner->email) }}" class="rounded-full w-12 mr-2">
            </a> 

            <a href="{{ $post->sharedPost->owner->path() }}">
                <span class="font-medium text-gray-700 text-lg">{{ $post->sharedPost->owner->name }}</span>
            </a>
        </div>

        <span class="block text-gray-500 text-xs absolute"
              style="left:53px;top:38px">
            {{ $post->sharedPost->created_at->diffForHumans() }}
        </span>
    </div>

    {{-- post body --}}
    <div class="text-gray-800 px-6 pt-8 pb-4">{{ $post->sharedPost->body }}</div>
</div>