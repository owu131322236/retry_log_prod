<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="fixed flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#e7e7f4] bg-[#f8f8fc]/95 w-full h-20 z-50 px-10 py-3">
        <div class="flex items-center gap-4 text-[#0d0d1c]">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 16 16"><!-- Icon from Gitlab SVGs by GitLab B.V. - https://gitlab.com/gitlab-org/gitlab-svgs/-/blob/main/LICENSE -->
                <path fill="#be38f3" fill-rule="evenodd" d="M7.32.029a8 8 0 0 1 7.18 3.307V1.75a.75.75 0 0 1 1.5 0V6h-4.25a.75.75 0 0 1 0-1.5h1.727A6.5 6.5 0 0 0 1.694 6.424A.75.75 0 1 1 .239 6.06A8 8 0 0 1 7.319.03Zm-3.4 14.852A8 8 0 0 0 15.76 9.94a.75.75 0 0 0-1.455-.364A6.5 6.5 0 0 1 2.523 11.5H4.25a.75.75 0 0 0 0-1.5H0v4.25a.75.75 0 0 0 1.5 0v-1.586a8 8 0 0 0 2.42 2.217" clip-rule="evenodd" />
            </svg>
            <a class="flex" href="{{ route('timeline') }}">
                <h2 class="text-[#0d0d1c] text-lg font-bold leading-tight tracking-wide">Retry</h2>
                <h2 class="text-gray-500 text-lg font-bold leading-tight tracking-wide">Log</h2>
            </a>
        </div>

        <div class="flex flex-1 justify-end gap-8">
            <div class="flex items-center gap-9">
                <a id="nav-timeline" class="text-[#0d0d1c] text-base leading-normal rounded-lg transition-all duration-300 hover:text-blue-600 hover:scale-110 hover:font-bold relative group p-3" href="{{ route('timeline') }}">Timeline</a>
                <a id="nav-challenges" class=" text-[#0d0d1c] text-base leading-normal rounded-lg  transition-all duration-300 hover:text-blue-600 hover:scale-110 hover:font-bold relative group p-3" href="{{ route('challenges') }}">Challenges</a>
                <a id="nav-progress" class=" text-[#0d0d1c] text-base leading-normal rounded-lg  transition-all duration-300 hover:text-blue-600 hover:scale-110 hover:font-bold relative group p-3" href="{{ route('progress',['user' => auth()->user()]) }}">Progress</a>
                <a id="nav-profile" class=" text-[#0d0d1c] text-base leading-normal rounded-lg  transition-all duration-300 hover:text-blue-600 hover:scale-110 hover:font-bold relative group p-3" href="{{ route('mypage',[auth()->user()])}}">Profile</a>
                <button class="post-form-open text-white text-sm font-bold leading-normal tracking-wider py-2 px-8 rounded-lg bg-blue-600 hover:scale-105 transition">＋New Post</button>
                <x-posts.post-create-form />

            </div>
            <!-- Settings Dropdown -->
            <div class="sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500  hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <img
                                src="{{ auth()->user()?->icon?->path ? asset(auth()->user()->icon->path) : asset('storage/images/icons/default.jpg') }}"
                                alt="User Icon"
                                class="w-10 h-10 rounded-full border object-cover" />
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Edit profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <!-- <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div> -->
        </div>
    </div>


    <!-- </div>
    </div> -->

    <!-- Responsive Navigation Menu -->
    <!-- <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div> -->

    <!-- Responsive Settings Options -->
    <!-- <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link> -->

    <!-- Authentication -->
    <!-- <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div> -->
</nav>