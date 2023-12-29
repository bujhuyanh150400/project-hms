<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('Admin.Layout.header')
    <title>@yield('title')</title>
    @vite([
        'resources/scss/admin/app.scss',
        'resources/js/app.js'
    ])
</head>

<body class="p-0 m-0 relative">

{{--    --}}{{-- Left menu --}}
{{--    <x-admin.section.leftmenu/>--}}
{{--    --}}{{-- End: Left menu --}}
{{--        @yield('body')--}}
{{--    </div>--}}
<div class="antialiased bg-gray-50">
    <x-admin.section.header>
    </x-admin.section.header>
    <x-admin.section.leftmenu/>

</div>

@include('Admin.Layout.footer')

@yield('script')

</body>

</html>
