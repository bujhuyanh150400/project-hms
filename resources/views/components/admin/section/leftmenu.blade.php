<aside
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0"
    aria-label="Sidenav"
    id="drawer-navigation"
>
    <div class="overflow-y-auto py-5 px-3 h-full bg-white">
        <form action="#" method="GET" class="mb-2">
            <label for="sidebar-search" class="sr-only">Search</label>
            <div class="relative">
                <div
                    class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none"
                >
                    <svg
                        class="w-5 h-5 text-gray-500 dark:text-gray-400"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        ></path>
                    </svg>
                </div>
                <input
                    type="text"
                    name="search"
                    id="sidebar-search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Tìm kiếm"
                />
            </div>
        </form>
        <ul class="space-y-2">
            @foreach ($list_menu as $key => $menu)
                @if (isset($menu['space_menu']) && $menu['space_menu'] === true)
                    <li class="my-1">
                        <span class="text-xs text-gray-600 font-bold">{{ $menu['title'] }}</span>
                    </li>
                @else
                    @if (!isset($menu['sub_menu']))
                        <li>
                            <a
                                href="{{ $menu['action'] }}"
                                class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg  hover:bg-gray-200 {{ !isset($menu['sub_menu']) && $current_route === $menu['route_name'] ? 'bg-gray-200' : '' }}"
                            >
                                <span class="text-lg">{!! $menu['icon'] !!}</span>
                                <span class="ml-3">{{ $menu['title'] }}</span>
                            </a>
                        </li>
                    @else
                        <li>
                            <button
                                type="button"
                                class="flex items-center p-2 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-200"
                                aria-controls="left-menu-{{$key}}"
                                data-collapse-toggle="left-menu-{{$key}}"
                            >
                                {!! $menu['icon'] !!}
                                <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ $menu['title'] }}</span>
                                <svg
                                    aria-hidden="true"
                                    class="w-6 h-6"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                            </button>
                            <ul id="left-menu-{{$key}}"  class="navmenu__left-sub-item hidden py-2 space-y-2">
                                @foreach ($menu['sub_menu'] as $sub_menu)
                                    <li @if ($current_route === $sub_menu['route_name']) data-active="true" @endif>
                                        <a href="{{ $sub_menu['action'] }}"

                                            class="flex items-center p-2 pl-9 w-full text-base font-medium text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-200 {{ $current_route === $sub_menu['route_name'] ? 'bg-gray-200' : '' }}">
                                            {{ $sub_menu['title'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endif
            @endforeach



        </ul>
    </div>
</aside>
