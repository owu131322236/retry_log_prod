<footer class="bg-white border-gray-100 w-full">
    <div class="max-w-screen-xl mx-auto py-12">
        <div class="grid grid-cols-4 gap-5">
            <div>
                <div class="flex items-center space-x-2 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 16 16"><!-- Icon from Gitlab SVGs by GitLab B.V. - https://gitlab.com/gitlab-org/gitlab-svgs/-/blob/main/LICENSE --><path fill="#be38f3" fill-rule="evenodd" d="M7.32.029a8 8 0 0 1 7.18 3.307V1.75a.75.75 0 0 1 1.5 0V6h-4.25a.75.75 0 0 1 0-1.5h1.727A6.5 6.5 0 0 0 1.694 6.424A.75.75 0 1 1 .239 6.06A8 8 0 0 1 7.319.03Zm-3.4 14.852A8 8 0 0 0 15.76 9.94a.75.75 0 0 0-1.455-.364A6.5 6.5 0 0 1 2.523 11.5H4.25a.75.75 0 0 0 0-1.5H0v4.25a.75.75 0 0 0 1.5 0v-1.586a8 8 0 0 0 2.42 2.217" clip-rule="evenodd"/></svg>
                    <h1 class="text-2xl font-bold">RetryLog</h1>
                </div>
                <p class="text-base text-gray-500">あなたの「続けたい」を応援するプラットフォーム。</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4">サイトマップ</h3>
                <ul class="space-y-2">
                    <li><a class="text-gray-500 hover:text-gray-900" href="{{ route('timeline') }}">タイムライン</a></li>
                    <li><a class="text-gray-500 hover:text-gray-900" href="{{ route('challenges') }}">チャレンジ</a></li>
                    <li><a class="text-gray-500 hover:text-gray-900" href="{{ route('progress',['user' => auth()->user()]) }}"">進捗</a></li>
                    <li><a class="text-gray-500 hover:text-gray-900" href="{{ route('mypage',[auth()->user()])}}">プロフィール</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4">サポート</h3>
                <ul class="space-y-2">
                    <li><a class="text-gray-500 hover:text-gray-900" href="#">お問い合わせ（作成中）</a></li>
                    <li><a class="text-gray-500 hover:text-gray-900" href="#">利用規約（作成中）</a></li>
                    <li><a class="text-gray-500 hover:text-gray-900" href="#">プライバシーポリシー（作成中）</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold w-fit mb-4">フォローする</h3>
                <div class="flex space-x-4">
                    <a class="text-gray-500 hover:text-gray-900" href="#">
                        <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path clip-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" fill-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a class="text-gray-500 hover:text-gray-900" href="#">
                        <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.71v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                        </svg>
                    </a>
                    <a class="text-gray-500 hover:text-gray-900" href="#">
                        <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path clip-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 4.237 2.636 7.855 6.356 9.312-.062-.327-.019-.722.084-1.05l1.62-6.859c.27-.999.034-1.921-.684-2.493-1.21-1.04-1.025-2.639.388-3.411 1.748-.95 3.528.23 3.528 2.011 0 1.343-.83 3.328-1.26 4.298-.448.995.056 1.782.996 1.782.884 0 1.542-.924 1.542-2.18 0-1.83-1.282-3.153-3.056-3.153-2.128 0-3.593 1.511-3.593 3.364 0 .684.246 1.401.583 1.758a.333.333 0 01-.153.64c-.201.077-.732.252-.924-.03-1.066-1.503-.96-3.456.321-4.789C9.28 5.143 10.993 4 12.88 4c2.856 0 4.968 1.95 4.968 4.797 0 2.92-1.722 5.093-4.136 5.093-.824 0-1.602-.42-1.867-.905 0 0-.42 1.686-.522 2.072-.186.72-.693 1.339-.96 1.635C10.744 21.464 11.365 22 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2z" fill-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="mt-12 border-t pt-8 text-center text-gray-500">
            <p>© 2025 RetryLog. All rights reserved.</p>
        </div>
    </div>
</footer>