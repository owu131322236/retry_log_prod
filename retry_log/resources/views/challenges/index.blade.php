<x-app-layout>
    <div class=" py-5 @[480px]:px-4 @[480px]:py-3">
        <div
            class="px-8 max-w-[1100px] mx-auto my-8 bg-center bg-no-repeat bg-cover flex justify-between items-center overflow-hidden bg-gradient-to-r from-pink-600 from- via-rose-600 via- to-red-500 to- rounded-2xl @[480px]:rounded-xl min-h-[218px]">
            <div class="flex flex-col items-start justify-center">
                <p class="text-white text-2xl font-bold leading-tight tracking-[-0.015em] px-6 pb-6">Start Your New Challenge</p>
                <p class="text-white text-sm font-normal leading-normal tracking-[0.015em] px-6 pb-6">何度続かなくてもまた始めようとする気持ちがあるなら、それは最高の強みです。ここは何度でも始められる場所。今日のあなたの新しい挑戦を、残していきましょう。</p>
            </div>
            <Button id="open" class="p-5  h-full whitespace-nowrap rounded-2xl bg-white text-red-700 shadow-lg hover:scale-105 transition-all">
                ＋ 新しいチャレンジを始める
            </Button>
        </div>
        <x-challenges.challenge-form />
    </div>
    <!-- ダミーデータ -->
    @php
    $challenges = [
    (object)['title' => '毎日ランニング', 'is_completed' => false],
    (object)['title' => '30日スクワットチャレンジ', 'is_completed' => true],
    (object)['title' => '水を1日2L飲む', 'is_completed' => false],
    (object)['title' => '毎朝の瞑想', 'is_completed' => true],
    (object)['title' => '読書30分', 'is_completed' => true],
    (object)['title' => '新しいレシピを試す', 'is_completed' => false],
    (object)['title' => '毎日感謝日記を書く', 'is_completed' => true],
    (object)['title' => '毎日英単語を覚える', 'is_completed' => false],
    ];
    @endphp

    <div class="mt-5 mx-10">
        <h2 class="text-2xl font-bold text-gray-800 m-5">進行中のチャレンジ</h2>
        <div class="bg-gradient-to-r from-pink-600 from- via-rose-600 via- to-red-500 to- rounded-full h-2 w-[100px]"></div>
        <p class="text-sm text-gray-500 m-5">続けているチャレンジがここに表示されます。ボタンを押して今日の成功を記録しましょう！</p>
    </div>
    <div class="overflow-x-auto">
        <div class="flex space-x-8 px-10 py-5">
            @foreach($ongoingChallenges as $challenge)
            <x-challenges.challenge-ongoing-card :challenge="$challenge" />
            `@endforeach
        </div>
    </div>
    <div class="flex justify-between items-center mt-10 mx-10">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 m-5">達成済みチャレンジ</h2>
            <div class="bg-gradient-to-r from-pink-600 from- via-rose-600 via- to-red-500 to- rounded-full h-2 w-[100px] mb-5"></div>
            <p class="text-sm text-gray-500 m-5">過去に達成したチャレンジがここに表示されます。一度失敗しても、再挑戦して成功を収めましょう！</p>
        </div>
        <a class="text-medium font-bold text-blue-600 hover:underline transition-all duration-300 ease-out transform hover:translate-x-2" href="{{ route('challenge-all') }}">全ての達成済みチャレンジ→</a>
    </div>
    <div class="overflow-x-auto">
        <div class="flex space-x-8 px-10 py-5">
            @foreach ($endedChallenges as $endedchallenge)
            <x-challenges.challenge-completed-card :endedchallenge="$endedchallenge" />
            @endforeach
        </div>
    </div>
    </div>
    <script>
        const openBtn = document.getElementById("open");
        const modal = document.getElementById("modal");
        const closeBtn = document.getElementById("close");
        const addHabitBtn = document.getElementById("addHabit");
        openBtn.addEventListener("click", () => {
            modal.classList.remove("hidden");
        });
        closeBtn.addEventListener("click", () => {
            modal.classList.add("hidden");
        });
        //チャレンジカードのオプションメニュー
        document.querySelectorAll('.options-button').forEach(button => {
            button.addEventListener('click', function() {
                const parent = this.parentElement;
                const menu = parent.querySelector('.options-menu');
                if (menu.classList.contains('hidden')) {
                    menu.classList.remove('hidden');
                    setTimeout(() => menu.classList.remove('opacity-0'), 10);
                }
                menu.addEventListener('mouseleave', function handleMouseLeave() {
                    menu.classList.add('opacity-0');
                    setTimeout(() => menu.classList.add('hidden'), 10);
                    menu.removeEventListener('mouseleave', handleMouseLeave);
                });
            });
        });
    </script>
</x-app-layout>