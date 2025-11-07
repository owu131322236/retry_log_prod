@props(['challenge'])
<div class="bg-white rounded-2xl shadow-lg w-[350px] w-max-[350px] p-6 flex-shrink-0 hover:scale-105 transition-all">
    <div class="flex justify-between items-center mb-4">
        <div class="flex space-x-3 items-center">
            <div class="w-12 h-12 rounded-2xl bg-gray-100 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                    <path fill="#008cb4" d="M29.435 2.565a4 4 0 0 0-5.657 0l-.034.034a1 1 0 0 0-1.353 1.353l-8.516 8.516l-.146-.146a.5.5 0 0 0-.707 0l-.708.707a.5.5 0 0 0 0 .707l.147.146l-6.714 6.714a1.5 1.5 0 0 0 0 2.122L4.45 24.014a3 3 0 0 0-.7 1.098L2.269 29.2a.417.417 0 0 0 .534.534l4.087-1.486a3 3 0 0 0 1.096-.698l1.297-1.297a1.5 1.5 0 0 0 2.122 0l6.714-6.714l.08.08a.5.5 0 0 0 .706 0l.707-.708a.5.5 0 0 0 0-.707l-.079-.08l4.004-4.003a1 1 0 0 0 1.611 1.134l4.95-4.95a1 1 0 0 0 0-1.414l-.666-.666l.004-.003a4 4 0 0 0 0-5.657m-1.418 4.246L25.19 3.983l.003-.004a2 2 0 1 1 2.829 2.829zm-4.242-1.414l2.828 2.828l-8.485 8.486l-2.829-2.829zm-16.26 16.26l6.36-6.36l2.829 2.828l-6.36 6.36zm-.707 4.95a1 1 0 1 1-1.415-1.415a1 1 0 0 1 1.415 1.415" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 w-4/5">{{ $challenge->title }}</h3>
        </div>
        <div class="relative">
            <button type="submit" class="options-button relative p-2 rounded-xl hover:bg-gray-200 cursor-pointer" data-challenge-id="{{ $challenge->id }}" data-type="ongoing">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 15 15" class="hover:bg-gray-200">
                    <path fill="#7a7a7a" d="M7 4c0-.14 0-.209.008-.267a.85.85 0 0 1 .725-.725C7.79 3 7.86 3 8 3s.209 0 .267.008a.85.85 0 0 1 .725.725C9 3.79 9 3.86 9 4s0 .209-.008.267a.85.85 0 0 1-.725.725C8.21 5 8.14 5 8 5s-.209 0-.267-.008a.85.85 0 0 1-.725-.725C7 4.21 7 4.14 7 4m0 4c0-.14 0-.209.008-.267a.85.85 0 0 1 .725-.725C7.79 7 7.86 7 8 7s.209 0 .267.008a.85.85 0 0 1 .725.725C9 7.79 9 7.86 9 8s0 .209-.008.267a.85.85 0 0 1-.725.725C8.21 9 8.14 9 8 9s-.209 0-.267-.008a.85.85 0 0 1-.725-.725C7 8.21 7 8.14 7 8m0 4c0-.139 0-.209.008-.267a.85.85 0 0 1 .724-.724c.059-.008.128-.008.267-.008s.21 0 .267.008a.85.85 0 0 1 .724.724c.008.058.008.128.008.267s0 .209-.008.267a.85.85 0 0 1-.724.724c-.058.008-.128.008-.267.008s-.209 0-.267-.008a.85.85 0 0 1-.724-.724C7 12.209 7 12.139 7 12" />
                </svg>
            </button>
            <ul class="options-menu hidden bg-gray-100 absolute top-10 right-0 p-2 w-fit rounded-lg shadow-lg z-10
                opacity-0 transition-opacity duration-150 ease-in-out">
                <li>
                    <form action="{{ route('challenges.restart',$challenge) }}" method="POST">
                        @csrf
                        @method('POST')
                        <label for="start_date">
                            <input name="start_date" id="start_date" type="hidden" name="start_date" value="{{ \Carbon\Carbon::now()}}">
                        </label>
                        <label for="end_date">
                            <input name="end_date" id="end_date" type="hidden" name="end_date" value="{{ \Carbon\Carbon::now()->addDays(5) }}">
                            <!-- 仮で5日を設定 -->
                        </label>
                        <button type="submit" class="replicate-btn hover:text-gray-500 min-w-[80px] my-2">コピー</button>
                    </form>
                </li>
                <li>
                    <form action="{{ route('challenges.destroy', $challenge) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <!-- POSTメソッドではなくDELETEメソッドを使用 -->
                        <button class="delete-btn hover:text-red-500 min-w-[80px] my-2">削除</button>
                    </form>
                </li>
            </ul>
        </div>

    </div>
    <div class="mb-4">
        <div class="flex justify-between text-gray-600 mb-1">
            <span>進捗</span>
            <span>{{ round(count($challenge->challengeLogs)) }}日/{{round($challenge->duration_days)}}日</span>
        </div>
        @php
        $rate = $challenge->achievement_rate ?? 0;
        @endphp
        <div class="w-full bg-gray-100 rounded-full h-2.5">
            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $rate }}%"></div>
        </div>
    </div>
    <div class="flex items-center text-sm text-gray-500 space-x-4 mb-6">
        <!-- 一時的な表示のためviewに記載 -->
        @php
        $latestLog = $challenge->challengeLogs->max('logged_at');
        @endphp
        <div class="flex items-center">
            <span>更新日: {{optional($latestLog)->format('m/d')}}</span>
        </div>
        <div class="flex items-center">
            <span>最高: {{ $challenge->max_streak}}日</span>
        </div>
        <div class="flex items-center">
            <span>開始: {{optional($challenge->start_date)->format('Y/m/d')}}</span>
        </div>
    </div>
    @if($challenge->is_recorded_today == false)
    <form action="{{ route('challenge_logs.store') }}" method="POST">
        @csrf
        <input type="hidden" name="challenge_id" value="{{ $challenge->id }}">
        <input type="hidden" name="status" value="success">
        <button type="submit" id="addHabit" class="flex justify-center w-full bg-gray-900 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-600 transition duration-300">
            今日の習慣を記録
        </button>
    </form>
    @else
    <button disabled class="flex justify-center items-center gap-2 w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-lg cursor-not-allowed">
        記録済み
    </button>
    @endif
    <!-- 使用先に書く用のJS -->
    <!-- <script>
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
    </script> -->
</div>