<div class="rounded-lg m-auto mb-6 post-box">
    <div 
        class="card post" 
        data-post="{{ $post->path() }}">
        <div class="relative">
            @can('update', $post)
                <i class="show-options fa fa-ellipsis-h w-5 absolute right-0 mr-2 text-2xl text-gray-500 hover:text-gray-600 cursor-pointer"></i>
            @endcan

            {{-- Post options --}}
            <div class="options absolute card mr-10 right-0 text-center w-40 cursor-auto" style="top:-8px;display:none">
            	<ul>
                    <!-- Link to open the modal -->
            		<a data-post="{{ $post }}" href="#post-modal" rel="modal:open" class="open-post-modal">
            			<li class="cursor-pointer hover:text-gray-900 text-gray-600 py-1" id="open-post-modal">Edit Post</li>
            		</a>

                    <form action="{{ $post->path() }}" method="POST">
                        @method('DELETE')
                        @csrf

        			    <button id="delete-btn" class="cursor-pointer hover:text-gray-900 text-gray-600 py-1" onclick="if (! confirm('Are you sure you want to delete your post?')) return false;">Delete Post</button>
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

            <span class="block text-gray-500 text-xs absolute"
                  style="left:53px;top:38px">
                {{ $post->created_at->diffForHumans() }}
            </span>
        </div>

        {{-- post body --}}
        <div class="text-gray-800 px-6 pt-8 pb-4">{{ $post->body }}</div>

        {{-- post likes count --}}
        <div class="text-gray-600 post-likes-count {{ $post->likesCount ? '' : 'hidden' }}">
            <i class="fa fa-thumbs-o-up"></i> <span class="text-sm likes-count">{{ $post->likesCount }}</span>
        </div>

        {{-- middle box --}}
        <div class="flex text-center mt-2 py-1 bg-white rounded-lg border border-gray-200 text-gray-500">
            {{-- like --}}
            <div class="w-1/3">
                <span class="like-post cursor-pointer py-2 px-1 {{ $post->isLiked() ? 'text-primary' : 'text-gray-500 hover:text-gray-600' }}"
                     data-post-id="{{ $post->id }}">
                    <i class="fa fa-thumbs-o-up text-2xl" 
                        style="margin-top: 4px" aria-hidden="true">
                    </i>

                    <span class="text-sm"> Like</span>
                </span>
            </div>

            {{-- comment --}}
            <div class="w-1/3">
                <span class="comment-span cursor-pointer py-2 px-1 hover:text-gray-600">
                    <i class="fa fa-comment text-2xl" style="margin-top: 2px;"></i>

                    <span class="text-sm"> Comment</span>
                </span>
            </div>

            {{-- share --}}
            <div class="w-1/3">
                <span class="cursor-pointer py-2 px-1 hover:text-gray-600">
                    <i class="fa fa-share share-post text-xl" style="margin-top: 6px" aria-hidden="true"></i>

                    <span class="text-sm"> Share</span>
                </span>
            </div>
        </div>

        {{-- Comments box --}}
        <div class="comments-box rounded-lg bg-white">
            {{-- Add comment --}}
            <div class="flex pt-2">
                <div class="w-1/12">
                    <a href="{{ auth()->user()->path() }}">
                        <img src="{{ gravatar(auth()->user()->email) }}" class="rounded-full w-10 border mt-1">
                    </a>
                </div>

                <div class="w-11/12 ml-2">
                    <form 
                        class="flex add-comment-form" 
                        action="{{ $post->path() . '/comments' }}" 
                        method="post"
                        data-user-name="{{ auth()->user()->name }}"
                        data-post-id="{{ $post->id }}"
                        data-user-path="{{ auth()->user()->path() }}"
                        data-user-img-src="{{ gravatar(auth()->user()->email) }}">
                        @csrf

                        <div class="w-9/12">
                            <textarea name="body" 
                                class="comment-input w-full text-gray-600 px-3 py-2 border border-gray-300 focus:border-primary bg-main" 
                                placeholder="Write your comment"
                                style="height: 58px;border-radius: 1.25rem;"></textarea>

                            <span class="comment-error text-red-500 italic text-sm hidden"></span>
                        </div>

                        <div class="w-3/12">
                            <button class="ml-4 mt-2 button-outline-secondary">Commet</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- view other comments link if any --}}
            @if (request()->path() != $post->path())
                @if ($post->comments->count() > 3)
                    <p class="mt-4 ml-6">
                        <a href="{{ $post->path() }}" class="text-primary">View {{ $post->comments->count() - 3 }} other comments</a>
                    </p>
                @endif
            @endif

            {{-- show current user comments if any --}}
            <div class="user-comments">
                @if (($latest_comments = request()->path() == $post->path() ? $post->latestComments() : $post->latestComments(3))->count())
                    @foreach ($latest_comments as $comment)
                        <div class="user-comment">
                            <div class="pl-4 mt-4">
                                <div class="flex">
                                    <div class="w-1/12">
                                        <a href="{{ $comment->owner->path() }}">
                                            <img src="{{ gravatar($comment->owner->email) }}" class="rounded-full w-10 border">
                                        </a>
                                    </div>
                                    
                                    <div class="w-11/12 bg-main py-2 px-4 border border-gray-200 text-gray-600 ml-2 relative"
                                         style="word-wrap: break-word;border-radius: 1.25rem;">
                                        @can('update', $comment)
                                            <i class="show-options fa fa-ellipsis-h absolute right-0 mr-2 text-gray-500 hover:text-gray-600 cursor-pointer mr-4 text-xl"></i>

                                            {{-- Comment options --}}
                                            <div class="options absolute card mr-10 right-0 text-center w-40 cursor-auto z-10" style="top:-8px;display:none">
                                                <ul>
                                                    <!-- Link to open the modal -->
                                                    <a data-comment-id="{{ $comment->id }}"
                                                       data-post-id="{{ $post->id }}"
                                                       href="#comment-modal" 
                                                       rel="modal:open" 
                                                       class="open-comment-modal">
                                                        <li class="cursor-pointer hover:text-gray-900 text-gray-600 py-1" id="open-comment-modal">Edit Comment</li>
                                                    </a>

                                                    <a class="delete-comment cursor-pointer hover:text-gray-900 text-gray-600 py-1"
                                                            data-comment-url="{{ $comment->path() }}"
                                                    >Delete Comment</a>
                                                </ul>
                                            </div>
                                        @endcan

                                        <p>
                                            <a href="{{ $comment->owner->path() }}" class="text-gray-700 text-lg">
                                                {{ $comment->owner->name }}
                                            </a>

                                            <span class="text-gray-500 text-xs ml-2">
                                                {{ $comment->created_at->diffForHumans() }}
                                            </span>
                                        </p>

                                        <p class="comment-body">{{ $comment->body }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>