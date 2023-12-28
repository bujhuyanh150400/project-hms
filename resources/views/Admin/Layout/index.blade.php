<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('Admin.Layout.header')
    <title>@yield('title')</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>

<body class="bg-gray-200">
    @yield('body')

    @include('Admin.Layout.footer')

    @yield('script')
    <script type="text/javascript">
        $(document).ready(function() {
            // Lặp qua từng menu con và kiểm tra điều kiện
            $('.collapse.navbar-nav').each(function() {
                // Kiểm tra điều kiện, nếu đúng thì thêm class 'show' vào ul cha
                if ($(this).find('.nav-link.active').length > 0) {
                    $(this).addClass('show');
                }
            });
        });
    </script>
</body>

</html>
