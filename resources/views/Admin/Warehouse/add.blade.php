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
                <a href="{{ route('warehouse.list') }}" class="flex items-center">
                    <i class="bi bi-chevron-right"></i>
                    <span class="ms-1 text-sm font-medium text-gray-500 hover:text-blue-600">Danh sách loại vật tư</span>
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="bi bi-chevron-right"></i>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Thêm vật tư</span>
                </div>
            </li>
        </ol>
    </nav>
    {{-- End: Navigation --}}
    <form class="form-loading-submit" action="{{ route('warehouse.add') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow ">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="flex flex-col gap-2">
                    <div class="form-group">
                        <label for="name" class=" @error('name') form-label-error @else form-label @enderror">Tên vật
                            tư</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class=" @error('name') form-input-error @else form-input @enderror"
                            placeholder="Hãy nhập vào đây">
                        @error('name')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="total" class=" @error('total') form-label-error @else form-label @enderror">Số
                            lượng</label>
                        <input type="number" name="total" min="0" id="total" value="{{ old('total') }}"
                            class="@error('total') form-input-error @else form-input @enderror"
                            placeholder="Số lượng vật tư">
                        @error('age')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                    @if ($userLogin->permission === PermissionAdmin::ADMIN)
                        <div class="form-group">
                            <label for="clinic_id"
                                class=" @error('clinic_id') form-label-error @else form-label @enderror">Vật
                                tư cho cơ sở nào</label>
                            <select name="clinic_id" id="clinic_id"
                                class=" @error('clinic_id') form-input-error @else form-input @enderror">
                                <option value="">chọn cơ sở</option>
                                @foreach ($clinics as $clinic)
                                    <option value="{{ $clinic->id }}" @if ((int) old('clinic_id') === $clinic->id) selected @endif>
                                        {{ $clinic->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('clinic_id')
                                <span class="form-alert">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="type_material_id"
                            class=" @error('type_material_id') form-label-error @else form-label @enderror">
                            Loại vật tư
                        </label>
                        <select name="type_material_id" id="type_material_id"
                            class=" @error('type_material_id') form-input-error @else form-input @enderror">
                            <option value="">Lựa chọn</option>
                            @foreach ($type_materials as $type)
                                <option value="{{ $type->id }}" @if ((int) old('type_material_id') === $type->id) selected @endif>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('type_material_id')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="type_material_id"
                               class=" @error('price') form-label-error @else form-label @enderror">
                            Giá thành vật tư (trên 1 cái)
                        </label>
                        <input type="number" min="0" name="price" id="price" value="{{ old('price') }}"
                               class=" @error('price') form-input-error @else form-input @enderror"
                               placeholder="Hãy nhập vào đây">
                        @error('price')
                        <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mt-4">
                        <label for="description"
                            class=" @error('description') form-label-error @else form-label @enderror">Mô
                            tả</label>
                        <textarea class="ckeditor" name="description" id="description">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <div class="flex items-center justify-center flex-col gap-2">
                        <label for="avatar"
                            class="flex items-center gap-2 text-sm font-medium   @error('avatar') text-red-500  @else text-blue-700 @enderror"><i
                                class="bi bi-image"></i>Ảnh vật tư</label>
                        <div class="w-64 h-64 flex items-center justify-center border-dashed border-4 bg-gray-100 rounded ">
                            <img id="avatar-preview" class="w-full h-full select-none hidden" src="" />
                            <i id="icon-preview" class="bi bi-file-earmark-arrow-up-fill text-4xl text-gray-300"></i>
                        </div>
                        <div class="form-group mt-3">
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none @error('avatar')border-red-300 border-2 @enderror"
                                id="avatar" name="avatar" value="{{ old('avatar') }}"
                                accept=".jpg,.jpeg,.png,.gif,.svg,.webp" type="file">
                            @error('avatar')
                                <span class="form-alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label for="file"
                                class="flex items-center gap-2 text-sm font-medium   @error('file') text-red-500  @else text-blue-700 @enderror">
                                File đính kèm</label>
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none @error('avatar')border-red-300 border-2 @enderror"
                                id="file" name="file" value="{{ old('file') }}" type="file">
                            @error('file')
                                <span class="form-alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group my-4">
                <div id="description_log_tooltip" role="tooltip"
                    class="absolute z-50 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                    Mỗi lần chỉnh sửa hay thêm mới sẽ vật tư sẽ được ghi lại và bên quản lý sẽ xem , bạn hãy ghi chú đầy đủ
                    về sửa hay nhập vật tư
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
                <label for="description_log"
                    class=" @error('description_log') form-label-error @else form-label @enderror">
                    Ghi chú về phần thêm mới
                    <span
                        class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded border cursor-pointer border-red-700"
                        data-tooltip-target="description_log_tooltip">Lưu ý:</span>
                </label>
                <textarea class="@error('description_log') form-input-error @else form-input @enderror"" rows="8"
                    name="description_log" id="description_log">{{ old('description_log') }}</textarea>
                @error('description_log')
                    <span class="form-alert">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex justify-end items-center gap-2">
                <a href="{{ route('warehouse.list') }}" class="btn-custom btn-default">
                    <i class="bi bi-arrow-left"></i>
                    Quay lại
                </a>
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
                    const extension = file.name.split('.').pop().toLowerCase();
                    const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'];
                    if (allowedExtensions.includes(extension)) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                        $('#avatar-preview').show();
                        $("#icon-preview").hide();
                    } else {
                        $('#avatar-preview').hide();
                        $("#icon-preview").show();
                    }
                }
            }
        });
    </script>
@endsection
