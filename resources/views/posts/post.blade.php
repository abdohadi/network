<div class="card lg:w-1/2 mb-4 m-auto">
    <div class="relative">
        <i id="show-options" class="fa fa-ellipsis-h w-5 absolute right-0 mr-2 text-xl text-gray-500 hover:text-gray-600 cursor-pointer"></i>

        <div id="post-options" class="bg-white rounded-lg shadow-lg p-4 absolute right-0 mr-10 w-40 text-center" style="top: -8px;display: none">
        	<ul>
                <!-- Link to open the modal -->
        		<a data-post="{{ $post }}" href="#ex1" rel="modal:open" class="open-modal">
        			<li  class="cursor-pointer hover:text-gray-900 text-gray-600 py-1">Edit Post</li>
        		</a>

        		<a href="#">
        			<li class="cursor-pointer hover:text-gray-900 text-gray-600 py-1">Delete Post</li>
        		</a>
        	</ul>
        </div>

        <div class="flex items-center ">
            <a href="profile">
                <img src="{{ gravatar($post->owner->email) }}" class="rounded-full w-12 mr-2">
            </a> 
            <a href="profile">
                <span class="text-gray-600 hover:text-gray-800">{{ $post->owner->name }}</span>
            </a>
        </div>

        <span 
            class="block text-gray-500 text-xs absolute"
            style="left:53px; top:38px">
            {{ $post->created_at->diffForHumans() }}
        </span>
    </div>

    <div class="text-gray-800 px-6 pt-8 pb-4">{{ $post->body }}</div>
</div>