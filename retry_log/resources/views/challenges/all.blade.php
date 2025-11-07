<x-app-layout>
    <div class="m-10 w-full">
        <div class="bg-gradient-to-r from-pink-600 from- via-rose-600 via- to-red-500 to- rounded-full h-2 w-[50px] m-5"></div>
        <h2 class="text-2xl font-bold mt-5 mx-10">達成済みチャレンジ一覧</h2>
        <p class="text-gray-600 text-sm mx-10 mt-3">みんながこれまでの挑戦の軌跡を振り返りながら、自分の成長を確認しましょう。そしてまだ挑んでいないチャレンジにも、もう一度挑戦してみましょう。</p>
        <div x-data="{ search: '',filter: 'all'}">
            <div class="w-full flex justify-center items-center">
                <input x-model="search" type="text" placeholder="チャレンジを検索" class="bg-white shadow-lg border form-input w-2/3 h-12 mx-5 mt-10 rounded-xl p-5 text-lg focus:outline-0 focus:ring-0 border-none focus:border-none placeholder:text-gray-600 text-gray-800" type="text" placeholder="チャレンジを検索">
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-xl mx-5 mt-10">検索</button>
            </div>
            <!-- <div class="flex justify-between items-center mt-10 mx-10">
                <p class="text-gray-600">全100件</p>
                <div class="relative inline-block text-left items-left min-w-[150px]">
                    <button id="sort-button" class="flex hover:bg-gray-300 rounded-lg p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 25 25">
                            <path fill="none" stroke="#7a7a7a" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 3v18m-7-3l-3 3l-3-3m3 3V3m13 3l-3-3l-3 3" />
                        </svg>
                        <p class="text-gray-600 text-sm">並び替え</p>
                    </button>
                    <div id="sort-menu" class="hidden absolute mt-2 flex flex-col bg-white rounded-lg p-3 transition-all min-w-full shadow-lg">
                        <button class="w-fit text-left p-3 hover:bg-gray-300">新しい順</button>
                        <button class="w-fit text-left p-3 hover:bg-gray-300">古い順</button>
                    </div>
                </div>
            </div> -->
            <div class="mx-10 flex gap-5 h-fit m-5">
                @php
                    $completedChallengesCount = count($endedChallenges ->where('state.value', 'COMPLETED'));
                    $interruptedChallengesCount = count($endedChallenges ->where('state.value', 'FAILED'||'INTERRUPTED'));
                @endphp
                <button
                    @click="filter = filter === 'cleared' ? 'all' : 'cleared'"
                    :class="filter === 'cleared'
                        ? 'border-2 border-blue-600 bg-blue-50 text-blue-600'
                        : 'border border-gray-300 text-blue-600'"
                        class="flex items-center rounded-2xl space-x-2 p-5 my-3 transition">
                    <div class="bg-blue-600 rounded-full h-3 w-3"></div>
                    <span>クリアしたチャレンジ数:{{ $completedChallengesCount }}件</span>
                </button>
                <button
                    @click="filter = filter === 'paused' ? 'all' : 'paused'"
                        :class="filter === 'paused'
                        ? 'border-2 border-rose-500 bg-rose-50 text-rose-600'
                        : 'border border-gray-300 text-rose-600'"
                        class="flex items-center rounded-2xl space-x-2 p-5 my-3 transition">
                    <div class="bg-red-600 rounded-full h-3 w-3"></div>
                    <span>中断中チャレンジ:{{ $interruptedChallengesCount }}件</span>
                </button>
            </div>
            <div class="flex flex-wrap gap-10 m-10">
                @foreach ($endedChallenges as $endedChallenge)
                @php
                $state = strtolower($endedChallenge->state->value);
                $filterState = in_array($state, ['interrupted', 'failed']) ? 'paused' : $state;
                $title = strtolower($endedChallenge->title);
                @endphp

                <div
                    x-show="
                '{{ $title }}'.includes(search.toLowerCase())
                &&
                (
                    filter === 'all'
                    || filter === '{{ $filterState }}'
                )
            "
                    x-transition>
                    <x-challenges.challenge-completed-card :endedchallenge="$endedChallenge" />
                </div>
                @endforeach
            </div>
            <!-- @for ($i=0; $i
            < 10; $i++)
                <div class="bg-white rounded-2xl shadow-lg min-w-[300px] h-fit p-6 hover:scale-105 transition-all">
                <div class="flex justify-between items-center mb-4 opacity-60">
                    <div class="flex space-x-3 items-center ">
                        <div class="w-12 h-12 rounded-2xl bg-gray-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                                <path fill="#008cb4" d="M29.435 2.565a4 4 0 0 0-5.657 0l-.034.034a1 1 0 0 0-1.353 1.353l-8.516 8.516l-.146-.146a.5.5 0 0 0-.707 0l-.708.707a.5.5 0 0 0 0 .707l.147.146l-6.714 6.714a1.5 1.5 0 0 0 0 2.122L4.45 24.014a3 3 0 0 0-.7 1.098L2.269 29.2a.417.417 0 0 0 .534.534l4.087-1.486a3 3 0 0 0 1.096-.698l1.297-1.297a1.5 1.5 0 0 0 2.122 0l6.714-6.714l.08.08a.5.5 0 0 0 .706 0l.707-.708a.5.5 0 0 0 0-.707l-.079-.08l4.004-4.003a1 1 0 0 0 1.611 1.134l4.95-4.95a1 1 0 0 0 0-1.414l-.666-.666l.004-.003a4 4 0 0 0 0-5.657m-1.418 4.246L25.19 3.983l.003-.004a2 2 0 1 1 2.829 2.829zm-4.242-1.414l2.828 2.828l-8.485 8.486l-2.829-2.829zm-16.26 16.26l6.36-6.36l2.829 2.828l-6.36 6.36zm-.707 4.95a1 1 0 1 1-1.415-1.415a1 1 0 0 1 1.415 1.415" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">毎日の瞑想</h3>
                    </div>
                    <span class="bg-rose-100 text-rose-800 text-sm font-medium px-3 py-1 rounded-full">中断</span>
                </div>
                <div class="mb-4 opacity-60">
                    <div class="flex justify-between text-gray-600 mb-1">
                        <span>進捗</span>
                        <span>15/30日</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-rose-500 h-2.5 rounded-full" style="width: 50%"></div>
                    </div>
                </div>
                <div class="flex items-center text-sm text-gray-500 space-x-4 mb-6 opacity-60">
                    <div class="flex items-center">

                        <span>現在: 0日</span>
                    </div>
                    <div class="flex items-center">

                        <span>最高: 15日</span>
                    </div>
                    <div class="flex items-center">
                        <span>中断: 2025年6月20日</span>
                    </div>
                </div>
                <button class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-teal-600 transition duration-300 flex items-center justify-center">
                    もう一度挑戦する
                </button>

            </div>
            @endfor -->
        </div>
    </div>
    <script>
        const sortButton = document.getElementById('sort-button');
        const sortMenu = document.getElementById('sort-menu');

        sortButton.addEventListener('click', () => {
            if (sortMenu.classList.contains('hidden')) {
                sortMenu.classList.remove('hidden');
            } else {
                sortMenu.classList.add('hidden');
            }
        });
        document.addEventListener('click', (event) => {
            if (!sortButton.contains(event.target) && !sortMenu.contains(event.target)) {
                sortMenu.classList.add('hidden');
            }
        });

        const clearedButton = document.getElementById('cleared-button');
        const pausedButton = document.getElementById('paused-button');

        clearedButton.addEventListener('click', () => {
            if (clearedButton.classList.contains('bg-blue-200')) {
                clearedButton.classList.remove('bg-blue-200');

                const existingSvg = clearedButton.querySelector('svg');
                if (existingSvg) existingSvg.remove();
            } else {
                clearedButton.classList.add('bg-blue-200');
                const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                svg.setAttribute("xmlns", "http://www.w3.org/2000/svg");
                svg.setAttribute("width", "15");
                svg.setAttribute("height", "15");
                svg.setAttribute("viewBox", "0 0 15 15");
                svg.innerHTML = `<path fill="#3B82F6" fill-rule="evenodd" d="M.877 7.5a6.623 6.623 0 1 1 13.246 0a6.623 6.623 0 0 1-13.246 0M7.5 1.827a5.673 5.673 0 1 0 0 11.346a5.673 5.673 0 0 0 0-11.346m2.354 3.32a.5.5 0 0 1 0 .707L8.207 7.5l1.647 1.646a.5.5 0 0 1-.708.708L7.5 8.207L5.854 9.854a.5.5 0 0 1-.708-.708L6.793 7.5L5.146 5.854a.5.5 0 0 1 .708-.708L7.5 6.793l1.646-1.647a.5.5 0 0 1 .708 0" clip-rule="evenodd"/>`;

                clearedButton.appendChild(svg);
            }

        });
        pausedButton.addEventListener('click', () => {
            if (pausedButton.classList.contains('bg-rose-200')) {
                pausedButton.classList.remove('bg-rose-200');
                const existingSvg = pausedButton.querySelector('svg');
                if (existingSvg) existingSvg.remove();
            } else {
                pausedButton.classList.add('bg-rose-200');
                const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                svg.setAttribute("xmlns", "http://www.w3.org/2000/svg");
                svg.setAttribute("width", "15");
                svg.setAttribute("height", "15");
                svg.setAttribute("viewBox", "0 0 15 15");
                svg.innerHTML = `<path fill="#F43F5E" fill-rule="evenodd" d="M.877 7.5a6.623 6.623 0 1 1 13.246 0a6.623 6.623 0 0 1-13.246 0M7.5 1.827a5.673 5.673 0 1 0 0 11.346a5.673 5.673 0 0 0 0-11.346m2.354 3.32a.5.5 0 0 1 0 .707L8.207 7.5l1.647 1.646a.5.5 0 0 1-.708.708L7.5 8.207L5.854 9.854a.5.5 0 0 1-.708-.708L6.793 7.5L5.146 5.854a.5.5 0 0 1 .708-.708L7.5 6.793l1.646-1.647a.5.5 0 0 1 .708 0" clip-rule="evenodd"/>`;

                pausedButton.appendChild(svg);
            }
        });
    </script>
</x-app-layout>