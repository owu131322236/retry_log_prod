<div id="modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center w-full h-full z-10">
            <div class="relative layout-content-container flex flex-col items-center rounded-2xl bg-white w-fit h-fit p-10 shadow-lg">
                <div class="flex w-full">
                    <div>
                        <button id="close" class="absolute top-3 right-3"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE -->
                                <path fill="currentColor" d="m12 13.4l-4.9 4.9q-.275.275-.7.275t-.7-.275t-.275-.7t.275-.7l4.9-4.9l-4.9-4.9q-.275-.275-.275-.7t.275-.7t.7-.275t.7.275l4.9 4.9l4.9-4.9q.275-.275.7-.275t.7.275t.275.7t-.275.7L13.4 12l4.9 4.9q.275.275.275.7t-.275.7t-.7.275t-.7-.275z" />
                            </svg></button>
                        <form method="POST" action="{{ route('challenges.store') }}">
                            @csrf
                            <div class="flex flex-wrap items-end gap-4 px-4 py-3">
                                <label for="title" class="flex flex-col min-w-40 flex-1">
                                    <p class="text-[#111418] text-base font-medium leading-normal pb-2">チャレンジ名</p>
                                    <input
                                        name="title"
                                        id="title"
                                        type="text"
                                        placeholder="今日のチャレンジ"
                                        class="form-input flex w-full min-w-[500px] flex-1 resize-none overflow-hidden rounded-xl text-[#111418] focus:outline-0 focus:ring-0 border-none bg-gray-100 focus:border-none h-14 placeholder:text-[#617589] p-4 text-base font-normal leading-normal"
                                        value="" />
                                </label>
                            </div>
                            <div class="flex flex-wrap items-end gap-4 px-4 py-3">
                                <label for="description" class="flex flex-col min-w-40 flex-1">
                                    <p class="text-[#111418] text-base font-medium leading-normal pb-2">詳細</p>
                                    <textarea
                                        id="description"
                                        name="description"
                                        type="text"
                                        placeholder="チャレンジの詳細を記入する"
                                        class="form-input flex w-full min-w-[500px] flex-1 resize-none overflow-hidden rounded-xl text-[#111418] focus:outline-0 focus:ring-0 border-none bg-gray-100 focus:border-none min-h-36 placeholder:text-[#617589] p-4 text-base font-normal leading-normal"></textarea>
                                </label>
                            </div>
                    </div>
                    <div>
                        <div class="flex flex-wrap items-end gap-4 px-4 py-3">
                            <label class="flex flex-col min-w-40 flex-1">
                                <p class="text-[#111418] text-base font-medium leading-normal pb-2">チャレンジ頻度</p>
                                <select
                                    name="frequency_type"
                                    class="form-input flex w-full min-w-[500px] flex-1 resize-none overflow-hidden rounded-xl text-[#111418] focus:outline-0 focus:ring-0 border-none bg-gray-100 focus:border-none h-14 bg-[image:--select-button-svg] placeholder:text-[#617589] p-4 text-base font-normal leading-normal">
                                    <option value="daily">毎日</option>
                                    <option value="weekly">毎週</option>
                                    <option value="monthly">毎月</option>
                                </select>
                            </label>
                        </div>
                        <div class="flex flex-wrap items-end gap-4 px-4 py-3">
                            <label for="frequency_goal" class="flex flex-col min-w-40 flex-1">
                                <input type="number" id="frequency_goal" name="frequency_goal" class="rounded-xl p-2" min="1" value="1" />
                            </label>
                        </div>
                        <div class="flex flex-wrap items-end gap-4 px-4 py-3">
                            <label for="start_date" class="flex flex-col min-w-40 flex-1">
                                <p class="text-[#111418] text-base font-medium leading-normal pb-2">開始する日</p>
                                <input
                                    id="start_date"
                                    name="start_date"
                                    type="date"
                                    placeholder="e.g., 2026-12-31"
                                    class="form-input flex w-full min-w-[500px] flex-1 resize-none overflow-hidden rounded-xl text-[#111418] focus:outline-0 focus:ring-0 border-none bg-gray-100 focus:border-none h-14 placeholder:text-[#617589] p-4 text-base font-normal leading-normal"
                                    value="" />
                            </label>
                        </div>
                        <div class="flex flex-wrap items-end gap-4 px-4 py-3">
                            <label for="end_date" class="flex flex-col min-w-40 flex-1">
                                <p class="text-[#111418] text-base font-medium leading-normal pb-2">終了する日</p>
                                <input
                                    id="end_date"
                                    name="end_date"
                                    type="date"
                                    placeholder="e.g., 2026-12-31"
                                    class="form-input flex w-full min-w-[500px] flex-1 resize-none overflow-hidden rounded-xl text-[#111418] focus:outline-0 focus:ring-0 border-none bg-gray-100 focus:border-none h-14 placeholder:text-[#617589] p-4 text-base font-normal leading-normal"
                                    value="" />
                            </label>
                        </div>
                    </div>
                </div>
                <div class="flex px-4 py-3">
                    <button
                        class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-10 px-4 flex-1 bg-[#1380ec] text-white text-sm font-bold leading-normal tracking-[0.015em]">
                        <span class="truncate">追加する</span>
                    </button>
                </div>
                </form>
            </div>
        </div>