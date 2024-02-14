@extends('Admin.Layout.index')
@section('title', $title)
@section('head')
    @vite(['resources/js/ckeditor.js'])
@endsection
@section('body')
    {{-- Navigation --}}
    <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 max-w-fit mb-4"
        aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-blue-600">
                    <i class="bi bi-house-door-fill"></i>
                    Trang chủ
                </a>
            </li>
            <li>
                <a href="{{ route('customer.list') }}" class="flex items-center">
                    <i class="bi bi-chevron-right"></i>
                    <span class="ms-1 text-sm font-medium text-gray-500 hover:text-blue-600">Danh sách khách hàng</span>
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="bi bi-chevron-right"></i>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Thêm Khách hàng</span>
                </div>
            </li>
        </ol>
    </nav>
    {{-- End: Navigation --}}
    <form class="form-loading-submit" action="{{ route('customer.add') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow ">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="flex flex-col gap-2">
                    <div class="form-group">
                        <label for="email" class=" @error('email') form-label-error @else form-label @enderror"><i
                                class="bi bi-envelope"></i>Email Khách hàng</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class=" @error('email') form-input-error @else form-input @enderror"
                            placeholder="name@company.com">
                        @error('email')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone" class=" @error('phone') form-label-error @else form-label @enderror"><i
                                class="bi bi-phone"></i>Điện thoại</label>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                            class=" @error('phone') form-input-error @else form-input @enderror"
                            placeholder="Hãy nhập vào đây">
                        @error('phone')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name" class=" @error('name') form-label-error @else form-label @enderror"><i
                                class="bi bi-people"></i>Tên Khách hàng</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class=" @error('name') form-input-error @else form-input @enderror"
                            placeholder="Hãy nhập vào đây">
                        @error('name')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="birth" class=" @error('birth') form-label-error @else form-label @enderror"><i
                                class="bi bi-calendar"></i>Ngày sinh</label>
                        <input type="text" name="birth" id="birth" value="{{ old('birth') }}"
                            class="datepicker @error('birth') form-input-error @else form-input @enderror"
                            placeholder="dd-mm-yyyy">
                        @error('birth')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="gender" class=" @error('gender') form-label-error @else form-label @enderror"><i
                                class="bi bi-gender-ambiguous"></i>Giới tính</label>
                        <select name="gender" id="gender"
                            class=" @error('gender') form-input-error @else form-input @enderror">
                            <option value="">Lựa chọn</option>
                            <option value="1" @if ((int) old('gender') === 1) selected @endif>Nam</option>
                            <option value="2" @if ((int) old('gender') === 2) selected @endif>Nữ</option>
                        </select>
                        @error('gender')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <label for="member_register" class="relative inline-flex items-center my-4 cursor-pointer w-fit">
                        <input type="checkbox" id="member_register" name="member_register" value="true"
                            class="sr-only peer" @if (old('member_register') == true) checked @endif>
                        <div
                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                        </div>
                        <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Đăng kí member ?</span>
                    </label>
                    <div id="form_member_register"
                        @if (old('member_register') == true) style="display: block" @else style="display: none" @endif>
                        <div class="form-group mb-2">
                            <label for="password"
                                class=" @error('password') form-label-error @else form-label @enderror"><i
                                    class="bi bi-lock"></i>Mật khẩu</label>
                            <input type="password" name="password" id="password"
                                class=" @error('password') form-input-error @else form-input @enderror"
                                placeholder="HASH PASSWORD" autocomplete="">
                            @error('password')
                                <span class="form-alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password"
                                class=" @error('conf_pass') form-label-error @else form-label @enderror"><i
                                    class="bi bi-lock"></i>Nhập lại mật khẩu</label>
                            <input type="password" name="conf_pass" id="conf_pass"
                                class=" @error('conf_pass') form-input-error @else form-input @enderror"
                                placeholder="HASH PASSWORD" autocomplete>
                            @error('conf_pass')
                                <span class="form-alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="">
                    <x-admin.provinces province="province" district="district" ward="ward" address="address" />
                    <div class="form-group mt-4">
                        <label for="description"
                            class=" @error('description') form-label-error @else form-label @enderror">Mô
                            tả về Khách hàng</label>
                        <textarea class="ckeditor" name="description" id="description">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="flex justify-end items-center gap-2">

                <a href="{{ route('users.list') }}" class="btn-custom btn-default"><i class="bi bi-arrow-left"></i>Quay
                    lại</a>
                <button type="submit" class="btn-custom btn-success"><i class="bi bi-plus"></i>Thêm</button>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <script type="module">
        $(document).ready(function() {
            $('#member_register').on('change', function() {
                const isCheck = $(this).prop('checked');
                if (isCheck === true) {
                    $('#form_member_register').slideDown(200);
                } else {
                    $('#form_member_register').slideUp(200);
                }
            })
        });
    </script>
@endsection
