@extends('Admin.Layout.index')
@section('title', $title)
@section('title-header', 'Dashboard')

@section('body')
    {{-- Navigation --}}
    <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 max-w-fit mb-10" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li>
                <p
                   class="inline-flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <i class="bi bi-house-door-fill"></i>
                    Trang chủ
                </p>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="bi bi-chevron-right"></i>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Thống kê</span>
                </div>
            </li>
        </ol>
    </nav>
    {{-- End: Navigation --}}

    @if (!empty($histories) and count($histories) > 0)
        <x-admin.table>
            <x-slot:header>
                <tr>
                    <th class="text-center align-middle" width='80'>
                        ID giao dịch
                    </th>
                    <th class="text-center align-middle" width='80'>
                        ID lịch khám
                    </th>
                    <th class="text-center align-middle">
                        Khách hàng
                    </th>
                    <th class="text-center align-middle">
                        Tên thú cưng
                    </th>
                    <th class="text-center align-middle">
                        Giống thú cưng
                    </th>
                    <th class="text-center align-middle">
                        Bác sĩ khám
                    </th>
                    <th class="text-center align-middle">
                        Giá tiền lịch khám
                    </th>
                </tr>
            </x-slot:header>
            <x-slot:body>
                @foreach ($histories as $history)
                    <tr>
                        <td class="text-start align-middle">
                            {{ $history->id }}
                        </td>
                        <td class="text-start align-middle">
                            {{ $history->schedule_id }}
                        </td>
                        <td class="text-start align-middle font-bold">
                            {{ $history->animal->customer->name }}
                        </td>
                        <td class="text-start align-middle">
                            {{ $history->animal->name }} - {{ $history->animal->species }}
                        </td>
                        <td class="text-start align-middle">
                            @isset(TypeAnimal::getList()[$history->animal->type])
                                {{ TypeAnimal::getList()[$history->animal->type]['text'] }}
                            @endisset
                        </td>
                        <td class="text-start align-middle">
                            {{ $history->schedules->user->name }} - {{ $history->schedules->user->specialties->name }} - {{ $history->schedules->user->clinic->name }}
                        </td>
                        <td class="text-start align-middle">
                            {{ number_format($history->price) }} VND
                        </td>
                    </tr>
                @endforeach
            </x-slot:body>
        </x-admin.table>
        {!! $histories->links() !!}
    @else
        <div class="flex items-center gap-2 p-4 mb-4 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50"
             role="alert">
            <i class="bi bi-info-circle-fill"></i>
            <div>
                <span class="font-medium">Lưu ý!</span> Không tìm thấy dữ liệu nào cả
            </div>
        </div>
    @endif

@endsection
