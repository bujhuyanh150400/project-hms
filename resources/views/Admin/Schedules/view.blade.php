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
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="bi bi-chevron-right"></i>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Đăng kí lịch khám </span>
                </div>
            </li>
        </ol>
    </nav>
    {{-- End: Navigation --}}
    <div class="grid grid-cols-4 gap-4 mb-4">
        <div class="col-span-1 flex flex-col gap-2">
            <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow">
                <h1 class="text-xl font-bold mb-3">Thông tin bác sĩ:</h1>
                <ul class="space-y-2 text-left">
                    <li class="flex items-center space-x-2">
                        <i class="bi bi-check text-xl text-green-500"></i>
                        <p class="font-medium text-gray-500">Tên bác sĩ: <span
                                class="text-black">{{ $schedule->user->name }}</span></p>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="bi bi-check text-xl text-green-500"></i>
                        <p class="font-medium text-gray-500">Chuyên khoa: <span
                                class="text-black">{{ $schedule->user->specialties->name }}</span></p>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="bi bi-check text-xl text-green-500"></i>
                        <p class="font-medium text-gray-500">Lịch:
                            <span
                                class="text-black">{{ \Carbon\Carbon::parse($schedule->booking->date)->format('d-m-Y') }}</span>
                        </p>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="bi bi-check text-xl text-green-500"></i>
                        <p class="font-medium text-gray-500">Giờ đặt: <span
                                class="text-black">{{ TimeType::getList()[$schedule->timeType]['start'] }}
                            </span>
                        </p>
                    </li>
                </ul>
            </div>
            <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow">
                <h1 class="text-xl font-bold mb-3">Thông tin về thú cưng:</h1>
                <ul class="space-y-2 text-left">
                    <li class="flex items-center space-x-2">
                        <i class="bi bi-check text-xl text-green-500"></i>
                        <p class="font-medium text-gray-500">Tên chủ vật nuôi: <span
                                class="text-black">{{ $schedule->customer->name }} -
                                {{ $schedule->customer->gender === 1 ? 'Nam' : 'Nữ' }}</span></p>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="bi bi-check text-xl text-green-500"></i>
                        <p class="font-medium text-gray-500">Tên vật nuôi: <span
                                class="text-black">{{ $schedule->animal->name }}</span></p>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="bi bi-check text-xl text-green-500"></i>
                        <p class="font-medium text-gray-500">Loại thú cưng:
                            <span class="text-black">{{ TypeAnimal::getList()[$schedule->animal->type]['text'] }}</span>
                        </p>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="bi bi-check text-xl text-green-500"></i>
                        <p class="font-medium text-gray-500">Giống thú cưng: <span
                                class="text-black">{{ $schedule->animal->species }}</span>
                        </p>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="bi bi-check text-xl text-green-500"></i>
                        <p class="font-medium text-gray-500">Thú cưng bao tuổi: <span
                                class="text-black">{{ $schedule->animal->age }} tuổi</span>
                        </p>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="bi bi-check text-xl text-green-500"></i>
                        <p class="font-medium text-gray-500">Ghi chú khi khám: </p>
                    </li>
                    <li class="form-group">
                        <textarea class="form-input" rows="5" disabled>{{ !empty($schedule->description) ? $schedule->description : 'Không có ghi chú' }} </textarea>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-span-3 w-full p-4 bg-white border border-gray-200 rounded-lg shadow">
            <form class="form-loading-submit" action="{{ route('schedules.submit_history', ['schedule_id' => $schedule->id]) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <h1 class="font-bold text-xl mb-4">Thông tin khám bệnh</h1>
                <div class="form-group mb-4">
                    <label for="file"
                           class="flex items-center gap-2 text-sm font-medium   @error('file') text-red-500  @else text-blue-700 @enderror">
                        File đính kèm khám bệnh</label>
                    <input
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none @error('avatar')border-red-300 border-2 @enderror"
                        id="file" name="file" value="{{ old('file') }}" type="file">
                    @error('file')
                    <span class="form-alert">{{ $message }}</span>
                    @enderror
                </div>
                <input hidden id="price" name="price" value="{{$schedule->user->examination_price}}"/>
                <h1 class="text-sm font-medium text-blue-700 mb-4">Giá khám bệnh: (VND)
                    <span id="price-show" class="bg-green-100 text-green-600 font-medium me-2 px-2.5 py-0.5 rounded border border-green-400">{{  number_format($schedule->user->examination_price, 0, ',', '.')}}</span>
                </h1>
                <div class="form-group mb-4">
                    <label class="form-label">Số thuốc dùng</label>
                    <div class="grid grid-cols-12 gap-2">
                        <select class="selectize col-span-5" id="warehouse">
                            <option>Chọn thuốc</option>
                            @foreach($warehouses as $warehouse)
                                <option value="{{$warehouse->id}}-{{{$warehouse->total}}}-{{$warehouse->price}}">{{$warehouse->name}} - loại: {{$warehouse->type_material->name}} - số lượng: {{$warehouse->total}}</option>
                            @endforeach
                        </select>
                        <input type="number" id="warehouse-total" class="form-input col-span-3" placeholder="Số lượng thuốc muốn nhâp" />
                        <button type="button" class="btn-custom btn-success col-span-2" id="warehouse_add_btn">Thêm đơn thuốc</button>
                    </div>
                    <ul id="warehouse_container" class="text-sm space-y-2 font-medium text-gray-900 bg-white">

                    </ul>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="form-group">
                        <label for="description"
                               class=" @error('description_animal') form-label-error @else form-label @enderror">Tình trạng khám thú cưng</label>
                        <textarea class="ckeditor" name="description_animal" id="description_animal">{{ old('description_animal') }}</textarea>
                        @error('description_animal')
                        <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description"
                               class=" @error('prescription') form-label-error @else form-label @enderror">Kê đơn thuốc</label>
                        <textarea class="ckeditor_second" name="prescription" id="prescription">{{ old('prescription') }}</textarea>
                        @error('prescription')
                        <span class="form-alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="flex items-center justify-end gap-2">
                    <button type="submit" class="btn-custom btn-success"><i class="bi bi-plus"></i>Hoàn thành hồ sơ khám bệnh</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="module">
        const Histories = {
            remove_value:[],
            init:function (){
                $('#warehouse_add_btn').on('click',function (){
                    let warehouse = $('#warehouse')[0].selectize;
                    let warehouse_value = warehouse.getValue().split('-');
                    let id = parseInt(warehouse_value[0]) ;
                    let total = parseInt(warehouse_value[1]);
                    let price = parseInt(warehouse_value[2]);
                    const removedOption = warehouse.options[warehouse.getValue()];
                    let warehouse_total = parseInt($('#warehouse-total').val()) ;
                    if(Number.isNaN(id)){
                        notyf.open({type: 'error', message: 'Hãy chọn thuốc'});
                        return false;
                    }
                    if(Number.isNaN(warehouse_total)){
                        notyf.open({type: 'error', message: 'Hãy nhập số lượng'});
                        return false;
                    }
                    if (warehouse_total > total){
                        notyf.open({type: 'error', message: 'Số lượng còn lại của thuốc vượt quá trong kho'});
                        return false;
                    }
                    Histories.remove_value.push({
                        value: removedOption.value,
                        text: removedOption.text
                    });
                    warehouse.removeOption(removedOption.value);
                    warehouse.clear()
                    $('#warehouse-total').val(0)
                    let html = `
                        <li class="w-full flex items-center justify-between px-4 py-2 border shadow-sm rounded">
                            <input type="hidden" name="warehouse[${id}]" class="warehouse_push" value="${warehouse_total}"/>
                            <span>${removedOption.text} - Số thuốc lấy: ${warehouse_total}</span>
                            <button type="button" data-total="${warehouse_total}" data-value="${removedOption.value}" class="btn-custom btn-danger btn-icon warehouse_deleted"><i class="bi bi-trash"></i></button>
                        </li>
                    `;
                    $('#warehouse_container').append(html);
                    const totalPrice = $('#price').val()
                    const allPrice = parseInt(totalPrice) + (price * warehouse_total);
                    $('#price').val(allPrice);
                    $('#price-show').text(allPrice.toLocaleString('vi-VN'));
                });

                $(document).on('click','.warehouse_deleted',function () {
                    const value = $(this).data('value');
                    const total = parseInt($(this).data('total'));
                    const valueAdd = Histories.remove_value.find(function(item) {
                        return item.value === value;
                    });
                    let warehouse = $('#warehouse')[0].selectize;
                    warehouse.addOption(valueAdd);

                    let warehouse_value = valueAdd.value.split('-');
                    let price = parseInt(warehouse_value[2]);
                    const totalPrice = $('#price').val()
                    const allPrice = parseInt(totalPrice) - (price * total);
                    $('#price').val(allPrice);
                    $('#price-show').text(allPrice.toLocaleString('vi-VN'));
                    $(this).parent().remove();
                })
            }
        }
        Histories.init();
    </script>
@endsection
