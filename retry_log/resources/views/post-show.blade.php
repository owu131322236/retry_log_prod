<!-- ポストとコメントとの共通ページ -->
<x-app-layout>
    <div class=" flex flex-wrap justify-center gap-x-10 my-10">
        <div class="flex flex-col w-3/5">
            <!-- メイン投稿 -->
            <x-posts.post-detail
            :target="$target"
            />
            <!-- 返信ポスト -->
            <div class="pl-4 border-l-2 border-gray-300 m-8">
                <div class="flex flex-col gap-3 mx-5">
                    @foreach ($target->comments as $comment )
                        <x-posts.post-reply 
                        :comment="$comment"/>
                    @endforeach
                </div>
            </div>
            <div class="sticky bottom-0 rounded-2xl bg-gray-100 z-10 my-5 w-full">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-start space-x-4 py-4">
                    
                        <form action="{{ route('comment.store') }}" method="POST" class="w-full">
                            <div class="flex-1 flex items-center space-x-2">
                                <img
                                    src="{{ auth()->user()?->icon?->path ? asset(auth()->user()->icon->path) : asset('storage/images/icons/default.jpg') }}"
                                    alt="User Icon"
                                    class="w-10 h-10 rounded-full border object-cover"/>
                                @csrf
                                <input type="hidden" name="target_type" id="inputTargetType" value="{{ $target->getMorphClass() }}">
                                <input type="hidden" name="target_id" id="inputTargetId" value="{{ $target->id }}">
                                <input type="text" name="content" class="w-full bg-background-light dark:bg-background-dark border border-gray-300 dark:border-border-dark rounded-full py-2 px-4 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-text-light dark:text-text-dark" placeholder="Post your reply" type="text" />
                                <button type="submit" class="bg-blue-500 border border-gray-300 text-white font-semibold py-2 px-4 rounded-full hover:opacity-90 transition-opacity">
                                    Reply
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col justify-start gap-5">
            <div>
                <div class="bg-gradient-to-r from-pink-600 from- via-rose-600 via- to-red-500 to- rounded-full h-2 w-[50px]"></div>
                <h2 class="ext-[#0d0d1c] tracking-light text-[28px] font-bold leading-tight text-left py-3">投稿者のプロフィール</h2>
            </div>
            <x-profile-card
                :user="$profileUser"
                :isOwnProfile="$isOwnProfile"
                :isFollowing="$isFollowing"
                :retryRate="$retryRate"
                />
        </div>
    </div>
</x-app-layout>