<x-app-layout>
    <div class="h-48 w-full fixed">
        <img class="w-full h-48 object-cover" src="https://kenblo.com/wp-content/uploads/2018/03/twitter-header-nature006.jpg" alt="Banner Image">
        <div class="absolute bottom-0 w-full h-48 bg-gradient-to-b from-transparent to-gray-100"></div>
    </div>
    <div class="mt-7 p-4 flex justify-around z-10 relative">
        <x-profile-card 
        :user="$profileUser"
        :isOwnProfile="$isOwnProfile"
        :isFollowing="$isFollowing"
        :retryRate="$retryRate"
        />
        <div class="flex flex-col w-2/3">
            <div class="bg-gradient-to-r from-pink-600 from- via-rose-600 via- to-red-500 to- rounded-full h-2 w-[50px]"></div>
            <h2 class="text-[#0d0d1c] tracking-light text-[28px] font-bold leading-tight text-left pb-3 pt-5 ">{{ $profileUser->name }}のProfile</h2>
            <div id="timeSelector" class="relative bg-gray-900/5 shadow-lg border border border-gray-300/30 backdrop-blur-lg rounded-full h-fit w-fit m-5 p-2 flex gap-2">
                <div id="indicator" class="absolute top-1/2 left-2 h-4/5 w-1/4 rounded-full bg-gray-900 transition-all duration-300 -translate-y-1/2"></div>
                <!-- z軸の方向に手前に動かす -->
                <button data-target="posts" class="relative z-10 px-6 py-2 rounded-full text-gray-800">投稿</button>
                <button data-target="likes" class="relative z-10 px-6 py-2 rounded-full text-gray-800">いいね</button>
                <button data-target="challenges" class="relative z-10 px-6 py-2 rounded-full text-gray-800">チャレンジ</button>
            </div>
            <div id="posts-template" class="hidden flex flex flex-wrap gap-5 w-full mx-5">
                @foreach ($posts as $post)
                <x-posts.post-card :post="$post" />
                @endforeach
            </div>
            <div id="likes-template" class="hidden flex flex-wrap gap-5 w-full mx-5">
                @foreach ($reactionPosts as $post)
                <x-posts.post-card :post="$post" />
                @endforeach
            </div>
            <div id="challenges-template" class="hidden flex flex-col m-5">
                    <h2 class="text-2xl font-bold text-gray-800">進行中のチャレンジ</h2>
                    <div class="flex items-center m-2 gap-2">
                        <div class="bg-blue-600 rounded-full h-3 w-3"></div>
                        <p class="text-sm text-blue-600 w-fit">{{ $challenges->count() }}challenges</p>
                    </div>
                <div class="flex flex-wrap gap-5 w-full m-5">
                    @foreach($challenges as $challenge)
                    <x-challenges.challenge-public-ongoing-card :challenge="$challenge" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const buttons = document.querySelectorAll('#timeSelector button');
            const indicator = document.getElementById('indicator');
            const templates = {
                posts: document.getElementById('posts-template'),
                likes: document.getElementById('likes-template'),
                challenges: document.getElementById('challenges-template'),
            }

            function modeIndicator(btn) {
                const offsetLeft = btn.offsetLeft;
                const offsetWidth = btn.offsetWidth;
                indicator.style.left = offsetLeft + 'px';
                indicator.style.width = offsetWidth + 'px';
            }

            modeIndicator(buttons[0]);
            buttons[0].classList.add('text-white');
            templates['posts'].classList.remove('hidden');
            // content.innerHTML = document.getElementById(buttons[0].dataset.template).innerHTML;

            buttons.forEach(button => {
                button.addEventListener('click', async () => {
                    const target = button.dataset.target;
                    //buttonUIの挙動
                    modeIndicator(button);
                    buttons.forEach(button => {
                        button.classList.remove('bg-white', 'text-white');
                        button.classList.add('text-gray-800');
                    });
                    button.classList.remove('text-gray-800');
                    button.classList.add('text-white');
                    //contentの挙動
                    Object.values(templates).forEach(t => t.classList.add('hidden')); //tはemplateの略
                    templates[target].classList.remove('hidden');
                });
            });
        });
    </script>
</x-app-layout>