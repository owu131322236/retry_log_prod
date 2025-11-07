<div id="replyForm" class="hidden fixed bg-black/50 flex items-center justify-center w-full h-full z-10">
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-xl font-display text-text-light p-5">
        <form action="{{ route('comment.store') }}" method="POST">
            <div class="flex w-full justify-end">
                <button id="closeForm" class="text-text-light rounded-full hover:bg-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE -->
                        <path fill="currentColor" d="m12 13.4l-4.9 4.9q-.275.275-.7.275t-.7-.275t-.275-.7t.275-.7l4.9-4.9l-4.9-4.9q-.275-.275-.275-.7t.275-.7t.7-.275t.7.275l4.9 4.9l4.9-4.9q.275-.275.7-.275t.7.275t.275.7t-.275.7L13.4 12l4.9 4.9q.275.275.275.7t-.275.7t-.7.275t-.7-.275z" />
                    </svg>
                </button>
            </div>
            <div>
                <div class="flex">
                    <div class="flex flex-col gap-3 items-center flex-shrink-0 mr-3">
                        <img id="replyUserIcon" alt="User avatar" class="w-10 h-10 rounded-full" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAPVLwZiBlE-9TtmmyeeE6cSu_zDvD8U09t6jPhWzAFeXEfCitMJ6lb437eGTvNUB1t4GufDcoFMFzjSOzugkXvDX60m7itRvuJrrjdr3AOfc3UzlGXhJEcb1ZldoOvDRt0VOehsI34HZSrbCjXP4psB6qlXSxdy0e8wHpSskRu6MKAqto2fPbtQw40_zsaZUaIIW8rMnwgkO15dDvVF6sUSs4a4tTAaQh4VbaNqiijtBdm7xijI66ObaaML8VFpu435psdq8-_yUPV" />
                        <div class="w-0.5 bg-gray-300 h-full mx-auto"></div> <!-- 線 -->
                    </div>
                    <div class="flex flex-col">
                        <div class="flex items-center">
                            <span id="replyUserName" class="font-bold">み</span>
                            <span id="replyDate" class="text-text-secondary-light ml-2 text-sm">@WepEt3x6lgPvnfI · 10月22日</span>
                        </div>
                        <p id="replyContent" class="mt-1 text-sm">次25日行きます😇<br />久々にかっけぇも見られるので楽しみしております！😇</p>
                    </div>
                </div>
                @csrf
                <input type="hidden" name="target_type" id="inputTargetType">
                <input type="hidden" name="target_id" id="inputTargetId">
                <input type="hidden" name="parent_id" id="inputParentId">
                <div class="flex mt-2">
                    <div class="flex-shrink-0 mr-3">
                        <img id="currentUserIcon" alt="Replying user avatar" class="w-10 h-10 rounded-full" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAnFNS6rNWKuGH3cAaFeD_9BmdSXmBZ_fKfhis_gL12MZXsnGmlb83RqVB2M-IJF--mZG51rTzJmov-Rk2N5OMFwb9cJferjiljn2cK_EpYZZ5vlrHB3iU0OGG_x-vlc6zOw_lN_BWN9ip5Au_xcvj_7d3ZFPMDdHZuuNEFAvRwIrrNgx6TC4Uk8t_5q0aq3uQxWEdhWyEg5YB-75ryRUmHEzFp91EfEWfkCGsiGz-20k3h0AkAFya8hz9KfJ_IlNC8ZCCN04B8bAOM" />
                    </div>
                    <div class="flex flex-col w-full">
                        <p class="mt-3 text-sm">返信先: <a id="replyUserHandle" data-profile-url="{{ route('mypage','USER_ID_PLACEHOLDER') }}" class="text-blue-600 hover:underline">@ユーザー名</a>さん</p>
                        <textarea name="content" id="replyTextarea" class="w-full bg-transparent text-lg resize-none border-none focus:outline-none focus:ring-0 focus:border-transparent" placeholder="返信をポスト" rows="4"></textarea>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end w-full">
                <button type="submit" class="bg-blue-600 text-white text-lg rounded-full px-8 py-3 font-bold hover:bg-primary/90 disabled:bg-primary/50 text-sm">返信</button>
            </div>
        </label>
    </div>
</div>