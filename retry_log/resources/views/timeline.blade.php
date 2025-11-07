<x-app-layout>
    <div class="fixed flex bg-black text-center justify-center items-center tracking-widest text-white text-sm h-12 w-full z-10">
        RetryLogはまだまだ成長中！新しい機能や改善を随時追加しています✨　ぜひ触って体験して、フィードバックも送ってください！
        <a href="https://docs.google.com/forms/d/e/1FAIpQLSdsxBtpULdzC-1T4l4MIvKiRHaWNII4NSnWUiESX8Bl8b0BMQ/viewform?usp=header" target="_blank" class="text-xs underline underline-offset-2 hover:text-gray-300 ml-2">フィードバックを送る →

        </a>
    </div>
    <!-- </header>  -->
    <div class="pb-40 h-full">
        <div class="flex flex-col justify-center items-center mt-10 py-5">

            <div
                class="px-8 max-w-[1100px] mx-auto my-5 bg-center bg-no-repeat bg-cover flex justify-between items-center overflow-hidden bg-gradient-to-r from-pink-600 from- via-rose-600 via- to-red-500 to- rounded-2xl @[480px]:rounded-xl min-h-[218px]"
                style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCyuWSbUlVXDheil_kgFnx9QFMK2U37-YCFN_Iwg-4pzFhlmbv9AvXxSuYvxITnCT_c7tGDNBxmXbQeUZMqT4McGSYs7ed_ZJjOnQhFHY7d8R7G-JfmlWTj1TdXt9rI-YNwGvo5cZLH_MAQ35sjfP1buDWK-pAF23jJwc6IIO7slzCkYyZiNURU_4ffrQx9U2gKtTPNkYMT6T0-3ApUM1zBvQfF2mDxMKjBVaZKqSTD7ryViY7o0AUdZ1wozw8vmnOgg-ggvjagTlM");'>
                <div class="flex flex-col items-start justify-center">
                    <p class="text-white text-2xl font-bold leading-tight tracking-[-0.015em] px-6 pb-6">Welcome to RETRY LOG</p>
                    <p class="text-white text-sm font-normal leading-normal tracking-[0.015em] px-6 pb-6">後ろを向いた日があっても、それは終わりじゃない。今日またここに来てくれたこと、それが一歩です。あなたの“続けたい”を、ここで分かち合いましょう。</p>
                </div>
                <Button id="open" class="header-open p-5  h-full whitespace-nowrap rounded-2xl bg-white text-red-700 shadow-lg hover:scale-105 transition-all">
                    ＋つぶやきを投稿する
                </Button>

            </div>
            <div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="relative layout-content-container flex flex-col items-center justify-center rounded-2xl bg-white p-10 m-10 shadow-lg">
                    <button id="close" class="absolute top-3 right-3"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE -->
                            <path fill="currentColor" d="m12 13.4l-4.9 4.9q-.275.275-.7.275t-.7-.275t-.275-.7t.275-.7l4.9-4.9l-4.9-4.9q-.275-.275-.275-.7t.275-.7t.7-.275t.7.275l4.9 4.9l4.9-4.9q.275-.275.7-.275t.7.275t.275.7t-.275.7L13.4 12l4.9 4.9q.275.275.275.7t-.275.7t-.7.275t-.7-.275z" />
                        </svg></button>
                    <div class="flex space-x-5 w-full h-full">
                        <div
                            class="bg-center bg-no-repeat aspect-square bg-cover rounded-full top-10 w-10 h-10 shrink-0"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCKZS_WEnpFEjPE5zOX4qN27VKdVIVnmYg667RwXbsEghVpnxweJZFiJ7PTtC78QKX9Qs8XW63-1bnDhaOu1Zg9LnBAmaFtlfOxj0M7fhUi_OkxaB6yIjju-fttAXiweHcXcwxoKMLlxG4eICa3NgfLWswiDXRLOBEZZvZcn3qoz7vm2_7kTUQjRF2-vMwrhhJ5hqjnU1R3ls92UqX903x3Wimk7eUpNSQYDNFo3-llMAa2RoQXsFOfxoUkGDe4iMQQoHC9oP4yTbk");'></div>
                        <textarea
                            rows="10" cols="50"
                            placeholder="今日のつぶやきをどうぞ..."
                            class="form-input flex flex-1 resize-none overflow-hidden rounded-xl text-[#111418] text-xl focus:outline-0 focus:ring-0 border-none bg-white focus:border-none placeholder:text-[#617589] text-base font-normal leading-normal"></textarea>
                    </div>
                    <div class="flex w-full items-center justify-between">
                        <p class="text-red-700">残り30文字</p>
                        <button
                            id="header-open" class="flex flex-none w-fit h-fit cursor-pointer items-center justify-center overflow-hidden rounded-2xl p-5 flex-1 bg-[#1380ec] text-white text-sm font-bold leading-normal tracking-widest shadow-lg hover:bg-[#0d6efd] transition-all hover:scale-95">
                            <span class="truncate">投稿する</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap justify-around p-4 my-5">
            <x-profile-card
                :user="$profileUser"
                :isOwnProfile="$isOwnProfile"
                :isFollowing="$isFollowing"
                :retryRate="$retryRate" />
            <div class="layout-content-container flex flex-col items-center w-2/3">
                <div class="bg-gradient-to-r from-pink-600 from- via-rose-600 via- to-red-500 to- rounded-full h-2 w-[100px]"></div>
                <h2 class="text-[#0d0d1c] tracking-light text-[28px] font-bold leading-tight text-left py-3">タイムライン</h2>

                <div class="flex w-full px-4 py-5 justify-center">
                    <div id="postSelector" class="relative flex h-10 w-3/5 w-full items-center justify-center rounded-xl bg-gray-200 p-1">
                        <div id="postIndicator" class="absolute top-1/2 left-2 h-4/5 w-1/2 rounded-xl bg-blue-600 transition-all duration-300 -translate-y-1/2"></div>
                        <button onclick="loadPosts('fail')" data-target="moon" id="moon" class="relative w-2/3 z-10 px-6 py-2 rounded-full text-center text-lg">moon</button>
                        <button onclick="loadPosts('success')" data-target="sun" id="sun" class="relative w-1/3 z-10 px-6 py-2 rounded-full text-center text-lg">sun</button>
                    </div>
                </div>
                <p class="text-sm text-gray-500 text-center m-1">「Moon」モードは穏やかで静かな投稿を、「Sun」モードは元気で前向きな投稿を表示します。</p>
                <div id="posts" class="flex flex-col m-5 w-full">
                    @include('partials.timeline-posts', ['timeline' => $timeline])
                </div>
            </div>
        </div>
    </div>
    <script>
        async function loadPosts(contentType) {
            const responce = await fetch(`/timeline/${contentType}`);
            const html = await responce.text();
            document.getElementById('posts').innerHTML = html;

            if (typeof window.initFormEvents === 'function') window.initFormEvents();
            if (typeof window.initReactionsEvents === 'function') window.initReactionsEvents();
        }
        //背景の変更
        function changePageBackGround(target) {
            const bg = document.getElementsByClassName('page-bg')[0];

            bg.classList.remove(
                'bg-gray-100',
                'bg-[#FFF8E7]',
            );

            if (target === 'moon') {
                bg.classList.add('bg-gray-100');
            } else {
                bg.classList.add('bg-[#FFF8E7]');
            }
        }
        //ポストの表示変更
        const postButtons = document.querySelectorAll("#postSelector button");
        const postIndicator = document.getElementById("postIndicator");

        function postModeIndicator(btn) {
            const offsetLeft = btn.offsetLeft;
            const offsetWidth = btn.offsetWidth;
            const target = btn.dataset.target;
            postIndicator.style.left = offsetLeft + 'px';
            postIndicator.style.width = offsetWidth + 'px';
            if (target === 'moon') {
                postIndicator.classList.remove('bg-[#FF8C1A]');
                postIndicator.classList.add('bg-blue-600')
            } else if (target === 'sun') {
                postIndicator.classList.remove('bg-blue-600');
                postIndicator.classList.add('bg-[#FF8C1A]');
            }
            changePageBackGround(target);
        }
        postModeIndicator(postButtons[0]);
        loadPosts('fail');
        postButtons[0].classList.add('text-white', 'font-bold');
        postButtons.forEach(button => {
            button.addEventListener('click', async () => {
                const target = button.dataset.target;
                postModeIndicator(button);
                postButtons.forEach(button => {
                    button.classList.remove('text-white', 'font-bold');
                    button.classList.add('text-gray-500');
                });
                button.classList.remove('text-gray-500');
                button.classList.add('text-white', 'font-bold');
            });
        });
    </script>
</x-app-layout>