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
                <a href="{{ route('users.list') }}" class="flex items-center">
                    <i class="bi bi-chevron-right"></i>
                    <span class="ms-1 text-sm font-medium text-gray-500 hover:text-blue-600">Danh sách nhân sự</span>
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="bi bi-chevron-right"></i>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">{{ $title }}:
                        {{ $user->name }}</span>
                </div>
            </li>
        </ol>
    </nav>
    {{-- End: Navigation --}}
    <form class="form-loading-submit" action="{{ route('users.edit', ['id' => $user->id]) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow">
            <div class="grid grid-cols-2 gap-2">
                <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-4">
                    <div class="form-group">
                        <label for="email" class=" @error('email') form-label-error @else form-label @enderror"><i
                                class="bi bi-envelope"></i> Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                            class=" @error('email') form-input-error @else form-input @enderror"
                            placeholder="name@company.com">
                        @error('email')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name" class=" @error('name') form-label-error @else form-label @enderror"><i
                                class="bi bi-people"></i>Tên</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                            class=" @error('name') form-input-error @else form-input @enderror"
                            placeholder="Hãy nhập vào đây">
                        @error('name')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address" class=" @error('address') form-label-error @else form-label @enderror"><i
                                class="bi bi-house"></i>Địa chỉ</label>
                        <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}"
                            class=" @error('address') form-input-error @else form-input @enderror"
                            placeholder="Hãy nhập vào đây">
                        @error('address')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="birth" class=" @error('birth') form-label-error @else form-label @enderror"><i
                                class="bi bi-calendar"></i>Ngày sinh</label>
                        <input type="text" name="birth" id="birth" value="{{ old('birth', $user->birth) }}"
                            class="datepicker @error('birth') form-input-error @else form-input @enderror"
                            placeholder="dd-mm-yyyy">
                        @error('birth')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone" class=" @error('phone') form-label-error @else form-label @enderror"><i
                                class="bi bi-phone"></i>Điện thoại</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                            class=" @error('phone') form-input-error @else form-input @enderror"
                            placeholder="Hãy nhập vào đây">
                        @error('phone')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="gender" class=" @error('gender') form-label-error @else form-label @enderror"><i
                                class="bi bi-gender-ambiguous"></i>Giới tính</label>
                        <select name="gender" id="gender"
                            class=" @error('gender') form-input-error @else form-input @enderror">
                            <option value="">Lựa chọn</option>
                            <option value="1" @if ((int) old('gender', $user->gender) === 1) selected @endif>Nam</option>
                            <option value="2" @if ((int) old('gender', $user->gender) === 2) selected @endif>Nữ</option>
                        </select>
                        @error('gender')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="permission"
                            class=" @error('permission') form-label-error @else form-label @enderror"><i
                                class="bi bi-house-dash"></i>Phân quyền</label>
                        <select name="permission" id="permission"
                            class=" @error('permission') form-input-error @else form-input @enderror">
                            <option value="">Lựa chọn</option>
                            @foreach (PermissionAdmin::getList() as $permission)
                                <option value="{{ $permission['value'] }}"
                                    @if ((int) old('permission', $user->permission) === $permission['value']) selected @endif>{{ $permission['text'] }}</option>
                            @endforeach
                        </select>
                        @error('permission')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="clinic_id" class=" @error('clinic_id') form-label-error @else form-label @enderror">Cơ
                            sở
                            trực thuộc</label>
                        <select id="clinic_id" name="clinic_id"
                            class=" @error('clinic_id') form-input-error @else form-input @enderror">
                            <option value="">Chọn phòng khám</option>
                            @foreach ($listClinic as $clinic)
                                <option value="{{ $clinic->id }}" @if (old('clinic_id', $user->clinic_id) == $clinic->id) selected @endif>
                                    Phòng khám {{ $clinic->name }} - cơ sở {{ $clinic->province_detail['name'] }}</option>
                            @endforeach
                        </select>
                        @error('clinic_id')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="specialties_id"
                            class=" @error('specialties_id') form-label-error @else form-label @enderror">
                            Chuyên khoa phụ trách
                        </label>
                        <select id="specialties_id" name="specialties_id"
                            class=" @error('specialties_id') form-input-error @else form-input @enderror">
                            <option value="">Chọn chuyên khoa</option>
                            @foreach ($listSpecialties as $specialty)
                                <option value="{{ $specialty->id }}" @if (old('specialties_id', $user->specialties_id) == $specialty->id) selected @endif>
                                    {{ $specialty->name }}</option>
                            @endforeach
                        </select>
                        @error('specialties_id')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user_status"
                            class=" @error('user_status') form-label-error @else form-label @enderror">Cấp bậc</label>
                        <select id="user_status" name="user_status"
                            class=" @error('user_status') form-input-error @else form-input @enderror">
                            <option value="">Chọn cấp bậc</option>
                            @foreach ($listUserStatus as $userStatus)
                                <option value="{{ $userStatus['value'] }}"
                                    @if (old('user_status', $user->user_status) == $userStatus['value']) selected @endif>
                                    {{ $userStatus['text_vn'] }}</option>
                            @endforeach
                        </select>
                        @error('user_status')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class="flex items-center justify-center flex-col gap-2">
                        <label for="avatar"
                            class="flex items-center gap-2 text-sm font-medium   @error('avatar') text-red-500  @else text-blue-700 @enderror"><i
                                class="bi bi-image"></i>Ảnh đại diện</label>
                        <div
                            class="w-64 h-64 flex items-center justify-center border-dashed border-4 bg-gray-100 rounded ">
                            @if (!empty($user->avatar))
                                <img class="w-full h-full select-none" id="avatar-preview"
                                    src="{{ route('file.show', ['filepath' => $user->avatar]) }}" />
                            @else
                                <img id="avatar-preview" class="w-full h-full select-none hidden" src="" />
                                <i id="icon-preview" class="bi bi-person text-4xl text-gray-300"></i>
                            @endif
                        </div>
                        <div class="form-group mt-8">
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none @error('avatar')border-red-300 border-2 @enderror"
                                id="avatar" name="avatar" value="{{ old('avatar', $user->avatar) }}"
                                accept=".jpg,.jpeg,.png,.gif,.svg,.webp" type="file">
                            @error('avatar')
                                <span class="form-alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mt-4">
                        <label for="description"
                            class=" @error('description') form-label-error @else form-label @enderror">Mô
                            tả</label>
                        <textarea class="ckeditor" name="description" id="description">{{ old('description', $user->description) }}</textarea>
                        @error('description')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mt-4">
                        <label for="examination_price"
                            class=" @error('examination_price') form-label-error @else form-label @enderror">Tiền
                            giá khám mỗi lần khám (VND)</label>
                        <input type="number" min="0" name="examination_price" id="examination_price"
                            value="{{ old('examination_price', $user->examination_price) }}"
                            class="@error('examination_price') form-input-error @else form-input @enderror"
                            placeholder="Giá tiền">
                        @error('examination_price')
                            <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end items-center gap-2">

                <a @if ($userLogin->permission === PermissionAdmin::ADMIN || $userLogin->permission === PermissionAdmin::MANAGER) href="{{ route('users.list') }}" @else href="{{ route('admin.dashboard') }}" @endif
                    class="btn-custom btn-default"><i class="bi bi-arrow-left"></i>Quay
                    lại</a>
                <button type="submit" class="btn-custom btn-success"><i class="bi bi-pencil-square"></i>Sửa</button>
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
