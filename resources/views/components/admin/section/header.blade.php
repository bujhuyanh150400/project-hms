<nav
    class="bg-white border-b border-gray-200 px-4 py-2.5 dark:bg-gray-800 dark:border-gray-700 fixed left-0 right-0 top-0 z-50">
    <div class="flex flex-wrap justify-between items-center">
        <div class="flex justify-start items-center">
            <button data-drawer-target="drawer-navigation" data-drawer-toggle="drawer-navigation"
                aria-controls="drawer-navigation"
                class="p-2 mr-2 text-gray-600 rounded-lg md:hidden cursor-pointer hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 focus:ring-2 focus:ring-gray-100">
                <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
                <svg aria-hidden="true" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Toggle sidebar</span>
            </button>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-between gap-2">
                <svg class="w-6 h-6 text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 22 22">
                    <path
                        d="M15 11 9.186 8.093a.933.933 0 0 1-.166-.039L9 8.047v6.885c0 .018.009.036.011.054l2.49-3.125L15 11Z" />
                    <path
                        d="m10.366 2.655 5.818 3.491a4.2 4.2 0 0 1 1.962 3.969 3.237 3.237 0 0 1-2.393 2.732c-.024.007-.048.005-.073.011-.065.032-.132.06-.2.084l-2.837.7-2.077 2.606a1.99 1.99 0 0 1-.7.56c.05.036.09.081.144.113a2.127 2.127 0 0 0 2.08.037c.618-.348 2.242-1.262 4.836-3.038l.291-.2c1.386-.94 3.772-2.565 4.138-4.428A10.483 10.483 0 0 0 6.869 1.349c1.211.302 2.385.74 3.497 1.306Z" />
                    <path
                        d="M4.023 16.341V9.558A3.911 3.911 0 0 1 5.784 6.3a4.062 4.062 0 0 1 3.58-.257c.184.031.362.088.53.169l6 3c.086.052.168.11.246.174a2.247 2.247 0 0 0-.994-1.529L9.4 4.407c-1.815-.9-4.074-1.6-5.469-1.152a10.46 10.46 0 0 0 .534 15.953 18.151 18.151 0 0 1-.442-2.867Z" />
                    <path
                        d="m18.332 15.376-.283.192c-2.667 1.827-4.348 2.773-4.9 3.083a4.236 4.236 0 0 1-2.085.556 4.092 4.092 0 0 1-2.069-.561 3.965 3.965 0 0 1-1.951-3.373A1.917 1.917 0 0 1 7 15V8c0-.025.009-.049.01-.074A1.499 1.499 0 0 0 6.841 8a1.882 1.882 0 0 0-.82 1.592v6.7c.072 1.56.467 3.087 1.16 4.486A10.474 10.474 0 0 0 21.3 13.047a20.483 20.483 0 0 1-2.968 2.329Z" />
                </svg>
                <span class="self-center text-xl font-semibold whitespace-nowrap ">HMS Admin</span>
            </a>
        </div>
        <div class="flex items-center gap-4">
            <!-- User -->
            <button type="button"
                class="flex mx-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300"
                id="user-menu-button" data-dropdown-toggle="user-dropdown">
                <img class="w-8 h-8 rounded-full"
                    @if (!empty($user->avatar)) src="{{ route('file.show', ['filepath' => $user->avatar]) }}"
                    @else
                        src="{{ asset('assets/images/user-admin.png') }}" @endif
                    alt="user photo" />
            </button>
            <div class="hidden z-50 my-4 w-56 text-base list-none bg-white rounded divide-y divide-gray-100 shadow rounded-xl"
                id="user-dropdown">
                <div class="py-3 px-4">
                    <p class="block text-sm font-semibold text-gray-900 ">
                        {{ $user->name }}
                    </p>
                    <p class="bg-blue-200 text-blue-800 w-fit text-xs font-medium me-2 px-2.5 py-0.5 rounded">
                        @isset(PermissionAdmin::getList()[$user->permission])
                            {{ PermissionAdmin::getList()[$user->permission]['text'] }}
                        @endisset
                    </p>
                </div>
                <ul class="py-1 text-gray-700 dark:text-gray-300" aria-labelledby="user-menu-button">
                    <li>
                        <a href="{{ route('users.view', ['id' => $user->id]) }}"
                            class="block py-2 px-4 text-sm hover:bg-gray-100 ">Thông tin cá nhân</a>
                    </li>
                    <li>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                            class="w-full flex items-center justify-start">
                            @csrf
                            <button type="submit" class="text-start w-full py-2 px-4 text-sm hover:bg-gray-100 ">
                                Đăng xuất</button>
                        </form>
                    </li>
                </ul>
            </div>
            <!-- End: User -->

            <!-- Notifications -->
            <button type="button" data-dropdown-toggle="notification-dropdown" data-dropdown-trigger="hover"
                class="px-3 py-2 mr-1 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100  focus:ring-4 focus:ring-gray-300">
                <i class="bi bi-bell-fill"></i>
            </button>
            <div class="hidden overflow-hidden z-50 my-4 max-w-sm text-base list-none bg-white rounded divide-y divide-gray-100 shadow-lg dark:divide-gray-600 dark:bg-gray-700 rounded-xl"
                id="notification-dropdown">
                <div
                    class="block py-2 px-4 text-base font-medium text-center text-gray-700 bg-gray-50 dark:bg-gray-600 dark:text-gray-300">
                    Thông báo
                </div>
                <div>
                    <a href="#" class="flex py-3 px-4 hover:bg-gray-100 dark:hover:bg-gray-600">
                        <div class="flex-shrink-0">
                            <img class="w-11 h-11 rounded-full"
                                src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/robert-brown.png"
                                alt="Robert image" />
                            <div
                                class="flex absolute justify-center items-center ml-6 -mt-5 w-5 h-5 bg-purple-500 rounded-full border border-white dark:border-gray-700">
                                <svg aria-hidden="true" class="w-3 h-3 text-white" fill="currentColor"
                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="pl-3 w-full">
                            <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">
                                <span class="font-semibold text-gray-900 dark:text-white">Robert Brown</span>
                                posted a new video: Glassmorphism - learn how to implement
                                the new design trend.
                            </div>
                            <div class="text-xs font-medium text-primary-600 dark:text-primary-500">
                                3 hours ago
                            </div>
                        </div>
                    </a>
                </div>
                <a href="#"
                    class="block py-2 text-md font-medium text-center text-gray-900 bg-gray-50 hover:bg-gray-100 dark:bg-gray-600 dark:text-white dark:hover:underline">
                    <div class="inline-flex items-center">
                        <svg aria-hidden="true" class="mr-2 w-4 h-4 text-gray-500 dark:text-gray-400"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                            <path fill-rule="evenodd"
                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        View all
                    </div>
                </a>
            </div>
            <!-- End: Notifications -->
        </div>
    </div>
</nav>
