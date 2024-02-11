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
                <a href="{{ route('specialties.list') }}" class="flex items-center">
                    <i class="bi bi-chevron-right"></i>
                    <span class="ms-1 text-sm font-medium text-gray-500 hover:text-blue-600">Danh sách phòng khám</span>
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="bi bi-chevron-right"></i>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Sửa phòng khám</span>
                </div>
            </li>
        </ol>
    </nav>
    {{-- End: Navigation --}}

    <form class="form-loading-submit" action="{{ route('specialties.edit', ['id' => $specialty->id]) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow ">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="flex flex-col gap-2">
                    <div class="form-group">
                        <label for="name" class=" @error('name') form-label-error @else form-label @enderror"><i
                                class="bi bi-hospital"></i> Tên phòng khám </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $specialty->name) }}"
                            class=" @error('name') form-input-error @else form-input @enderror"
                            placeholder="Nhập tên cơ sở">
                        @error('name')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex items-start justify-center flex-col gap-2">
                        <label for="logo"
                            class="flex items-center gap-2 text-sm font-medium @error('logo') text-red-500  @else text-blue-700 @enderror"><i
                                class="bi bi-image"></i>Ảnh đại diện phòng khám</label>
                        <div
                            class="w-full h-[400px] flex items-center justify-center border-dashed border-4 bg-gray-100 rounded ">
                            @if (!empty($specialty->logo))
                                <img class="w-full h-full select-none" id="avatar-preview"
                                    src="{{ route('file.show', ['filepath' => $user->avatar]) }}" />
                            @else
                                <img id="avatar-preview" class="w-full h-full select-none hidden" src="" />
                                <i id="icon-preview" class="bi bi-person text-4xl text-gray-300"></i>
                            @endif
                        </div>
                        <div class="form-group w-full mt-8">
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none @error('logo')border-red-300 border-2 @enderror"
                                id="logo" name="logo" value="{{ old('logo') }}"
                                accept=".jpg,.jpeg,.png,.gif,.svg,.webp" type="file">
                            @error('logo')
                                <span class="form-alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-3">
                    <div class="form-group">
                        <label for="description"
                            class=" @error('description') form-label-error @else form-label @enderror">Mô tả</label>
                        <textarea class="ckeditor" name="description" id="description">{{ old('description', $specialty->description) }}</textarea>
                        @error('description')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="active" class=" @error('active') form-label-error @else form-label @enderror">Trạng
                            thái hoạt động</label>
                        <select class=" @error('active') form-input-error @else form-input @enderror" id="active"
                            name="active">
                            <option value=""> Chọn trạng thái </option>
                            <option value="1" @if ((int) old('active', $specialty->active) === 1) selected @endif> Active </option>
                            <option value="2" @if ((int) old('active', $specialty->active) === 2) selected @endif> In-Active </option>
                        </select>
                        @error('active')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="flex justify-end items-center gap-2">
                <a href="{{ route('specialties.list') }}" class="btn-custom btn-default"><i
                        class="bi bi-arrow-left"></i>Quay
                    lại</a>
                <button type="submit" class="btn-custom btn-success"><i class="bi bi-pencil-square"></i>Sửa</button>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <script type="module">
        $(document).ready(function() {
            $('#logo').change(function() {
                previewImage(this);
            });

            function previewImage(input) {
                const preview = $('#avatar-preview')[0];
                const file = input.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                    $('#avatar-preview').show();
                    $("#icon-preview").hide();
                }
            }
        });
    </script>
@endsection
