<div 
    class="post {{ (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '') != $post->path() ? 'cursor-pointer hover:border-blue-400 hover:shadow-lg' : '' }}" 
    data-post="{{ $post->path() }}" 
    data-in-show-page="{{ (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '') == $post->path() }}">
    <div class="relative">
        @can('update', $post)
            <i id="show-options" class="fa fa-ellipsis-h w-5 absolute right-0 mr-2 text-xl text-gray-500 hover:text-gray-600 cursor-pointer"></i>
        @endcan

        <div id="post-options" class="bg-white rounded-lg shadow-lg p-4 absolute right-0 mr-10 w-40 text-center" style="top:-8px;display:none">
        	<ul>
                <!-- Link to open the modal -->
        		<a data-post="{{ $post }}" href="#post-modal" rel="modal:open" class="open-post-modal">
        			<li class="cursor-pointer hover:text-gray-900 text-gray-600 py-1" id="open-post-modal">Edit Post</li>
        		</a>

                <form action="{{ $post->path() }}" method="POST">
                    @method('DELETE')
                    @csrf

    			    <button id="delete-btn" class="cursor-pointer hover:text-gray-900 text-gray-600 py-1" onclick="if (! confirm('Are you sure you want to delete that post?')) return false;">Delete Post</button>
                </form>
        	</ul>
        </div>

        <div class="flex items-center">
            <a href="{{ $post->owner->path() }}">
                <img src="{{ gravatar($post->owner->email) }}" class="rounded-full w-12 mr-2">
            </a> 
            <a href="{{ $post->owner->path() }}">
                <span>{{ $post->owner->name }}</span>
            </a>
        </div>

        <span
            class="block text-gray-500 text-xs absolute"
            style="left:53px;top:38px">
            {{ $post->created_at->diffForHumans() }}
        </span>
    </div>

    <div class="text-gray-800 px-6 pt-8 pb-4">{{ $post->body }}</div>
</div>