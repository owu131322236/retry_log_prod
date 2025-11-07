<div id="header-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <form action="{{ route('post.store') }}" method="POST">
        @csrf
        @method("POST")
        <div class="relative layout-content-container flex flex-col items-center justify-center rounded-2xl bg-white p-10 m-10 shadow-lg">
            <button id="header-close" class="absolute top-3 right-3 rounded-full hover:bg-gray-300"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE -->
                    <path fill="currentColor" d="m12 13.4l-4.9 4.9q-.275.275-.7.275t-.7-.275t-.275-.7t.275-.7l4.9-4.9l-4.9-4.9q-.275-.275-.275-.7t.275-.7t.7-.275t.7.275l4.9 4.9l4.9-4.9q.275-.275.7-.275t.7.275t.275.7t-.275.7L13.4 12l4.9 4.9q.275.275.275.7t-.275.7t-.7.275t-.7-.275z" />
                </svg></button>
            <div class="flex w-full justify-center items-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M12 17q.425 0 .713-.288T13 16v-4q0-.425-.288-.712T12 11t-.712.288T11 12v4q0 .425.288.713T12 17m0-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                </svg>
                <p class="text-sm text-gray-500 text-center m-1">「Moon」モードは穏やかで静かな投稿を、「Sun」モードは元気で前向きな投稿を表示します。</p>
            </div>
            <div id="postFormSelector" class="relative flex h-10 w-3/5 w-4/5 items-center justify-between rounded-full bg-gray-200 p-1">
                <div id="postFormIndicator" class="absolute top-1/2 left-2 h-4/5 w-1/2 rounded-full bg-white transition-all duration-300 -translate-y-1/2"></div>
                <button type="button" id="success" class="relative text-sm text-center w-1/2 z-10 px-6 py-1 rounded-full text-gray-500">moon</button>
                <button type="button" id="fail" class="relative text-sm text-center w-1/2 z-10 px-6 py-1 rounded-full text-gray-900">sun</button>
                <input type="hidden" id="content_type" name="content_type" value="fail">
            </div>

            <div class="flex space-x-5 w-full h-full m-5">
                <img src="{{ auth()->user()?->icon?->path ? asset(auth()->user()->icon->path) : asset('storage/images/icons/default.jpg') }}" alt="User Icon"
                    class="w-10 h-10 rounded-full border object-cover">
                <textarea name="content"
                    rows="10" cols="50"
                    placeholder="今日のつぶやきをどうぞ..."
                    class="form-input flex flex-1 resize-none overflow-hidden rounded-xl text-[#111418] text-xl focus:outline-0 focus:ring-0 border-none bg-white focus:border-none placeholder:text-[#617589] text-base font-normal leading-normal"></textarea>
            </div>
            <div class="flex w-full items-center justify-end">
                <!-- <p class="text-red-700">残り30文字</p> -->
                <button
                    type="submit" class="flex flex-none w-fit h-fit cursor-pointer items-center justify-center overflow-hidden rounded-2xl py-5 px-10 flex-1 bg-[#1380ec] text-white text-sm font-bold leading-normal tracking-widest shadow-lg hover:bg-[#0d6efd] transition-all hover:scale-95">
                    <span class="truncate">投稿する</span>
                </button>
            </div>
        </div>
    </form>
</div>
<script>
</script>