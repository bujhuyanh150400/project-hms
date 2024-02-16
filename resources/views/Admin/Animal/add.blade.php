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
                <a href="{{ route('animal.list') }}" class="flex items-center">
                    <i class="bi bi-chevron-right"></i>
                    <span class="ms-1 text-sm font-medium text-gray-500 hover:text-blue-600">Danh sách thú cưng</span>
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="bi bi-chevron-right"></i>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Thêm thú cưng</span>
                </div>
            </li>
        </ol>
    </nav>
    {{-- End: Navigation --}}
    <form class="form-loading-submit" action="{{ route('animal.add', ['cust_id' => $customer->id]) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow ">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="flex flex-col gap-2">
                    <div class="form-group">
                        <label for="name" class=" @error('name') form-label-error @else form-label @enderror"><i
                                class="bi bi-people"></i>Tên thú cưng</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class=" @error('name') form-input-error @else form-input @enderror"
                            placeholder="Hãy nhập vào đây">
                        @error('name')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="age" class=" @error('age') form-label-error @else form-label @enderror"><i
                                class="bi bi-calendar"></i>Tuổi</label>
                        <input type="number" name="age" min="0" max="30" id="age"
                            value="{{ old('age') }}" class="@error('age') form-input-error @else form-input @enderror"
                            placeholder="Số tuổi (0 - 30)">
                        @error('age')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="gender" class=" @error('gender') form-label-error @else form-label @enderror"><i
                                class="bi bi-gender-ambiguous"></i>Giới tính</label>
                        <select name="gender" id="gender"
                            class=" @error('gender') form-input-error @else form-input @enderror">
                            <option value="">Lựa chọn</option>
                            <option value="1" @if ((int) old('gender') === 1) selected @endif>Đực</option>
                            <option value="2" @if ((int) old('gender') === 2) selected @endif>Cái</option>
                        </select>
                        @error('gender')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="type" class=" @error('type') form-label-error @else form-label @enderror">
                            Loại động vật
                        </label>
                        <select name="type" id="type"
                            class=" @error('type') form-input-error @else form-input @enderror">
                            <option value="">Lựa chọn</option>
                            @foreach (TypeAnimal::getList() as $type)
                                <option value="{{ $type['value'] }}" @if ((int) old('type') === $type['value']) selected @endif>
                                    {{ $type['text'] }}</option>
                            @endforeach
                        </select>
                        @error('type')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="species" class=" @error('species') form-label-error @else form-label @enderror">
                            Giống
                        </label>
                        <input type="text" name="species" id="species" value="{{ old('species') }}"
                            class=" @error('species') form-input-error @else form-input @enderror"
                            placeholder="nhập giống loài vào đây" />
                        @error('species')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class="flex items-center justify-center flex-col gap-2">
                        <label for="avatar"
                            class="flex items-center gap-2 text-sm font-medium   @error('avatar') text-red-500  @else text-blue-700 @enderror"><i
                                class="bi bi-image"></i>Ảnh thú cưng</label>
                        <div class="w-64 h-64 flex items-center justify-center border-dashed border-4 bg-gray-100 rounded ">
                            <img id="avatar-preview" class="w-full h-full select-none hidden" src="" />
                            <i id="icon-preview" class="bi bi-person text-4xl text-gray-300"></i>
                        </div>
                        <div class="form-group mt-8">
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none @error('avatar')border-red-300 border-2 @enderror"
                                id="avatar" name="avatar" value="{{ old('avatar') }}"
                                accept=".jpg,.jpeg,.png,.gif,.svg,.webp" type="file">
                            @error('avatar')
                                <span class="form-alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mt-4">
                        <label for="description"
                            class=" @error('description') form-label-error @else form-label @enderror">Mô
                            tả về thú cưng</label>
                        <textarea class="ckeditor" name="description" id="description">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="flex justify-end items-center gap-2">
                <a href="{{ route('animal.list') }}" class="btn-custom btn-default"><i class="bi bi-arrow-left"></i>Quay
                    lại</a>
                <button type="submit" class="btn-custom btn-success"><i class="bi bi-plus"></i>Thêm</button>
                <button type="submit" name="add_more" value="1" class="btn-custom btn-primary">
                    <i class="bi bi-plus"></i>Thêm và tiếp tục nhập tiếp
                </button>
            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <script type="module">
        $(document).ready(function() {
            $('#avatar').change(function() {
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
