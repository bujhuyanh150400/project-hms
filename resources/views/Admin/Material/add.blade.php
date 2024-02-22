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
                <a href="{{ route('type_material.list') }}" class="flex items-center">
                    <i class="bi bi-chevron-right"></i>
                    <span class="ms-1 text-sm font-medium text-gray-500 hover:text-blue-600">Danh sách loại vật tư</span>
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="bi bi-chevron-right"></i>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Thêm loại vật tư</span>
                </div>
            </li>
        </ol>
    </nav>
    {{-- End: Navigation --}}

    <form class="form-loading-submit" action="{{ route('type_material.add') }}" method="POST">
        @csrf
        @method('POST')
        <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow ">
            <div class="grid grid-cols-1 gap-4 mb-4">
                <div class="form-group">
                    <label for="name" class=" @error('name') form-label-error @else form-label @enderror"> Tên loại
                        vật tư </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class=" @error('name') form-input-error @else form-input @enderror" placeholder="Nhập tên">
                    @error('name')
                        <span class="form-alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description" class=" @error('description') form-label-error @else form-label @enderror">Mô
                        tả</label>
                    <textarea class="ckeditor" name="description" id="description">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="form-alert">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="flex justify-end items-center gap-2">
                <a href="{{ route('type_material.list') }}" class="btn-custom btn-default"><i
                        class="bi bi-arrow-left"></i>Quay
                    lại</a>
                <button type="submit" class="btn-custom btn-success"><i class="bi bi-plus"></i>Thêm</button>
                <button type="submit" name="add_more" value="1" class="btn-custom btn-primary">
                    <i class="bi bi-plus"></i>Thêm và tiếp tục nhập tiếp
                </button>
            </div>
        </div>
    </form>
@endsection
