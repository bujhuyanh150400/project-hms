<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('Admin.Layout.header')
    <title>{{ $title }}</title>
    @vite(['resources/scss/Admin/app.scss', 'resources/js/app.js'])
</head>

<body>
<main class="bg-gray-300 flex items-center justify-center w-screen h-screen fixed">
    <div class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8">
        <form action="{{ route('admin.login-submit') }}" method="POST" novalidate class="space-y-6">
            @csrf
            @method('POST')
            <h5 class="text-xl font-medium text-gray-900 ">Đăng nhập vào Admin panel HMS</h5>
            <div class="form-group">
                <label for="email" class="form-label @error('email') text-red-400 @enderror">Email</label>
                <input type="email" name="email" id="email"
                       value="{{ old('email') }}"
                       class="form-input"
                       placeholder="email@email.com" required>
                @error('email')
                <span class="form-alert">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password" class="form-label @error('password') text-red-400 @enderror">Password</label>
                <input type="password" name="password" id="password"
                       placeholder="••••••••"
                       class="form-input" required>
                @error('password')
                <span class="form-alert">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex items-start">
                <label for="remember_me" class="relative inline-flex items-center gap-2 cursor-pointer font-medium text-sm">
                    <input type="checkbox" name="remember_me" id="remember_me" value="1" class="sr-only peer" {{ old('remember_me') ? 'checked' : '' }}>
                    <span class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300  rounded-full peer  peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></span>
                    Ghi nhớ đăng nhập
                </label>
            </div>
            <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Đăng nhập</button>
        </form>
    </div>
</main>
@error('login')
<script type="module" defer>
    notyf.error('{{ $message }}');
</script>
@enderror
@include('Admin.Layout.footer')
</body>
</html>
