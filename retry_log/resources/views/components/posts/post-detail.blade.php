<!-- ポストとコメントとの共通コンポーネント -->
@props(['target'])
<div class="rounded-3xl bg-white shadow-lg h-fit my-2 hover:border-primary/50 hover:scale-105 transition-all"
    data-target-id="{{ $target->id }}"
    data-target-type="{{ $target->getMorphClass() }}"
    onclick="goToDetail(event)">
    <div class="flex w-full flex-row items-start justify-start gap-3 p-4">
        <a href="{{ route('mypage', [$target->user])}}">
            <img
                src="{{ asset($target->user->icon?->path) ?? asset('images/icons/default.jpg') }}"
                alt="User Icon"
                class="w-10 h-10 rounded-full border object-cover hover:brightness-75" />
        </a>
        <div class="flex h-full flex-1 flex-col items-start justify-start">
            <div class="flex w-full flex-row items-start justify-start items-center">
                <p class="text-[#0d0d1c] text-base font-bold leading-normal tracking-[0.015em] m-1">{{ $target->user->name }}</p>
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE -->
                    <path fill="#0061ff" d="m12.05 19l2.85-2.825l-2.85-2.825L11 14.4l1.075 1.075q-.7.025-1.362-.225t-1.188-.775q-.5-.5-.763-1.15t-.262-1.3q0-.425.113-.85t.312-.825l-1.1-1.1q-.425.625-.625 1.325T7 12q0 .95.375 1.875t1.1 1.65t1.625 1.088t1.85.387l-.95.95zm4.125-4.25q.425-.625.625-1.325T17 12q0-.95-.363-1.888T15.55 8.45t-1.638-1.075t-1.862-.35L13 6.05L11.95 5L9.1 7.825l2.85 2.825L13 9.6l-1.1-1.1q.675 0 1.375.263t1.2.762t.763 1.15t.262 1.3q0 .425-.112.85t-.313.825zM12 22q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22" />
                </svg>
                <p class="text-[#49499c] text-base font-normal leading-normal m-4">{{ $target->created_at }}</p>
            </div>
            <p class="text-[#0d0d1c] text-base font-normal leading-normal">{{$target->content}}</p>
        </div>
    </div>
    <div class="flex flex-wrap gap-2 px-6 py-2">
        <div class="reactions-button relative flex justify-center items-center rounded-2xl border border-gray-300 py-2 px-3 hover:bg-white hover:border hover:border-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE -->
                <path fill="#49499c" d="M12 22q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2q1.075 0 2.075.213T16 2.825v2.25q-.875-.5-1.888-.788T12 4Q8.675 4 6.337 6.338T4 12t2.338 5.663T12 20t5.663-2.337T20 12q0-.8-.162-1.55T19.4 9h2.15q.225.725.338 1.463T22 12q0 2.075-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m8-15V5h-2V3h2V1h2v2h2v2h-2v2zm-4.5 4q.625 0 1.063-.437T17 9.5t-.437-1.062T15.5 8t-1.062.438T14 9.5t.438 1.063T15.5 11m-7 0q.625 0 1.063-.437T10 9.5t-.437-1.062T8.5 8t-1.062.438T7 9.5t.438 1.063T8.5 11m3.5 6.5q1.7 0 3.088-.962T17.1 14H6.9q.625 1.575 2.013 2.538T12 17.5" />
            </svg>
            <div class="reactions-menu hidden absolute top-[40px] left-0 flex bg-white rounded-2xl border border-gray-300 p-2">
                @php
                    $route = $target instanceof App\Models\Post
                        ? route('posts.reaction.toggle')
                        : route('comments.reaction.toggle');
                @endphp
                @foreach ($target->available_reactions as $reaction)
                <form method="POST" action="{{ $route }}" class="inline-block">
                    @csrf
                    <input type="hidden" name="target_type" value="{{ $target->getMorphClass() }}">
                    <input type="hidden" name="target_id" value="{{ $target->id }}">
                    <input type="hidden" name="reaction_type_id" value="{{ $reaction->id }}">
                    <button type="submit" class="rounded-lg p-1 hover:bg-blue-300">{{ $reaction->emoji }}</button>
                </form>
                @endforeach
            </div>
        </div>
        @if ($target->reactionCounts->isNotEmpty())
        <div class="reactions flex gap-2">
            @foreach ($target->reactionCounts as $count)
            <div class="flex items-center gap-x-2 text-sm bg-gray-100 rounded-2xl px-3">
                <span>{{ $count->reactionType->emoji }}</span>
                <span class="text-[#49499c]">{{ $count->count }}</span>
            </div>
            @endforeach
        </div>
        @endif
        <!-- <button class="replyFormButton flex items-center justify-center rounded-2xl border border-gray-300 gap-2 px-3 hover:border-blue-600"
            data-reply-id="{{ $target->id }}"
            data-reply-user-handle="{{ $target->user->name }}"
            data-reply-user-id="{{ $target->user->id }}"
            data-reply-user-name="{{ $target->user->name }}"
            data-reply-content="{{ $target->content }}"
            data-reply-date="{{ $target->created_at }}">
            <div class="text-[#49499c]" data-icon="ChatCircleDots" data-size="24px" data-weight="regular">
                <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor" viewBox="0 0 256 256">
                    <path
                        d="M140,128a12,12,0,1,1-12-12A12,12,0,0,1,140,128ZM84,116a12,12,0,1,0,12,12A12,12,0,0,0,84,116Zm88,0a12,12,0,1,0,12,12A12,12,0,0,0,172,116Zm60,12A104,104,0,0,1,79.12,219.82L45.07,231.17a16,16,0,0,1-20.24-20.24l11.35-34.05A104,104,0,1,1,232,128Zm-16,0A88,88,0,1,0,51.81,172.06a8,8,0,0,1,.66,6.54L40,216,77.4,203.53a7.85,7.85,0,0,1,2.53-.42,8,8,0,0,1,4,1.08A88,88,0,0,0,216,128Z"></path>
                </svg>
            </div>
            <p class="text-[#49499c] text-[13px] font-bold leading-normal tracking-[0.015em]">{{ $target->comments->count() }}</p>
        </button> -->
    </div>
</div>