@props(['user', 'isOwnProfile' =>false, 'isFollowing'=>false, 'retryRate'])
<div class="layout-content-container flex flex-col bg-white w-80 h-fit rounded-2xl shadow-lg hover:border">
    <div class="flex py-10 @container">
        <div class="flex w-full flex-col gap-4 items-center">
        <img
            src="{{ $user->icon?->path ? asset($user->icon->path) : asset('storage/images/icons/default.jpg') }}"
            alt="User Icon"
            class="w-32 h-32 rounded-full border object-cover"/>
            <div class="flex flex-col items-center justify-center justify-center">
                <div class="flex gap-1 items-center py-1">
                    <p class="text-[#0d0d1c] text-[22px] font-bold leading-tight tracking-[-0.015em] text-center">{{$user->name}}</p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE -->
                        <path fill="#0061ff" d="m12.05 19l2.85-2.825l-2.85-2.825L11 14.4l1.075 1.075q-.7.025-1.362-.225t-1.188-.775q-.5-.5-.763-1.15t-.262-1.3q0-.425.113-.85t.312-.825l-1.1-1.1q-.425.625-.625 1.325T7 12q0 .95.375 1.875t1.1 1.65t1.625 1.088t1.85.387l-.95.95zm4.125-4.25q.425-.625.625-1.325T17 12q0-.95-.363-1.888T15.55 8.45t-1.638-1.075t-1.862-.35L13 6.05L11.95 5L9.1 7.825l2.85 2.825L13 9.6l-1.1-1.1q.675 0 1.375.263t1.2.762t.763 1.15t.262 1.3q0 .425-.112.85t-.313.825zM12 22q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22" />
                    </svg>
                </div>

                <!-- <p class="text-[#49499c] text-base font-normal leading-normal text-center">@emily_carter</p> -->
            </div>
            <div class="flex gap-3 items-center py-1">
                <div class="flex items-center hover:underline">
                    <p class="text-subtext-light ">{{$user->followings_count}}</p>
                    <p class="font-bold text-center">フォロー</p>
                </div>
                <div class="flex items-center hover:underline">
                    <p class="text-subtext-light">{{ $user->followers_count }}</p>
                    <p class="font-bold text-center">フォロワー</p>
                </div>
            </div>
            <!-- <h3 class="text-[#0d0d1c] text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">Bio</h3> -->
            <p class="text-[#0d0d1c] text-base text-center font-normal leading-normal pb-3 pt-1 px-4">{{ $user->bio }}</p>
        </div>
    </div>
    <div class="flex flex-wrap gap-3 px-4 py-3">
        <div class="flex min-w-[111px] flex-1 basis-[fit-content] flex-col gap-2 rounded-lg border border-[#cecee8] p-3 items-center text-center">
            <p class="text-[#0d0d1c] tracking-light text-2xl font-bold leading-tight">{{$user->posts_count}}</p>
            <div class="flex items-center gap-2">
                <p class="text-[#49499c] text-sm font-normal leading-normal">ポスト数</p>
            </div>
        </div>
        <div class="flex min-w-[111px] flex-1 basis-[fit-content] flex-col gap-2 rounded-lg border border-[#cecee8] p-3 items-center text-center">
            <p class="text-[#0d0d1c] tracking-light text-2xl font-bold leading-tight">{{ $retryRate }}%</p>
            <div class="flex items-center gap-2">
                <p class="text-[#49499c] text-sm font-normal leading-normal">立ち直り率</p>
            </div>
        </div>
        <div class="flex min-w-[111px] flex-1 basis-[fit-content] flex-col gap-2 rounded-lg border border-[#cecee8] p-3 items-center text-center">
            <p class="text-[#0d0d1c] tracking-light text-2xl font-bold leading-tight">{{$user->challenges_count}}</p>
            <div class="flex items-center gap-2">
                <p class="text-[#49499c] text-sm font-normal leading-normal">挑戦中のチャレンジ</p>
            </div>
        </div>
    </div>
    @if($isOwnProfile)
    <a href="{{ route('profile.edit') }}" class="w-full flex justify-center">
        <button class="bg-primary text-white text-sm font-bold leading-normal tracking-[-0.015em] w-full py-2 px-4 m-4 rounded-full bg-black hover:bg-blue-600 hover:scale-105 transition">Edit Profile</button>
    </a>
    @elseif($isFollowing)
    <form action="{{ route('unfollow',$user) }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="w-full flex justify-center">
            <button class="bg-primary text-white text-sm font-bold leading-normal tracking-[-0.015em] w-full py-2 px-4 m-4 rounded-full bg-black hover:bg-blue-600 hover:scale-105 transition">フォロー解除</button>
        </div>
    </form>
    @else
    <form action="{{ route('follow',$user) }}" method="POST">
        @csrf
        <div class="w-full flex justify-center">
            <button class="bg-primary text-white text-sm font-bold leading-normal tracking-[-0.015em] w-full py-2 px-4 m-4 rounded-full bg-black hover:bg-blue-600 hover:scale-105 transition">フォローする</button>
        </div>
    </form>
    @endif
</div>