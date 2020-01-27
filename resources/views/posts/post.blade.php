<div class="rounded-lg m-auto mb-6 post-box">
    <div 
        class="card post {{ (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '') != $post->path() ? 'cursor-pointer hover:border-blue-400' : '' }}" 
        data-post="{{ $post->path() }}" 
        data-in-show-page="{{ (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '') == $post->path() }}">
        <div class="relative">
            @can('update', $post)
                <i id="show-options" 
                    class="fa fa-ellipsis-h w-5 absolute right-0 mr-2 text-2xl text-gray-500 hover:text-gray-600 cursor-pointer"></i>
            @endcan

            {{-- Post options --}}
            <div id="post-options" class="absolute card mr-10 right-0 text-center w-40 cursor-auto" style="top:-8px;display:none">
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
                    <span class="font-medium text-gray-700 text-lg">{{ $post->owner->name }}</span>
                </a>
            </div>

            <span
                class="block text-gray-500 text-xs absolute"
                style="left:53px;top:38px">
                {{ $post->created_at->diffForHumans() }}
            </span>
        </div>

        {{-- post body --}}
        <div class="text-gray-800 px-6 pt-8 pb-4">{{ $post->body }}</div>

        {{-- post likes count --}}
        <div class="text-gray-600 mt-1 post-likes-count {{ $post->likes->count() ? '' : 'hidden' }}">
            <i class="fa fa-thumbs-o-up"></i> <span class="text-sm likes-count">{{ $post->likes->count() }}</span>
        </div>
    </div>

    <div class="flex text-center">
        {{-- like --}}
        <div class="w-1/6 border rounded-lg py-1 bg-white">
            <i class="fa fa-thumbs-o-up text-2xl cursor-pointer like-post {{ auth()->user()->likes()->where('post_id', $post->id)->first() ? 'text-primary' : 'text-gray-500' }}" 
                style="margin-top: 4px" aria-hidden="true" data-post-id="{{ $post->id }}"></i>
        </div>

        {{-- comment --}}
        <div class="w-4/6 border rounded-lg bg-white">
            <form class="py-2">
                <input type="text" name="comment" class="w-full text-gray-600 px-3" placeholder="Write your comment">
            </form>
        </div>

        {{-- share --}}
        <div class="w-1/6 border rounded-lg py-1 bg-white">
            <i class="fa fa-share share-post text-xl text-gray-500" style="margin-top: 6px" aria-hidden="true"></i>
        </div>
    </div>
</div>