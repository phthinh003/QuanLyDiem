@extends('layouts.canbo.layoutcanbo')
@section('content')
    <div class="mt-2 pt-2 card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="cart-title">
                <input type="hidden" name="filename" value="{{ $filename }}">
                @foreach ($thongtinlop as $item => $value)
                    @foreach ($value as $key => $v)
                        {{ $key }} : {{ $v }}<br />
                    @endforeach
                @endforeach
            </div>
            <hr>
            <div class="card-toolbar">
                <a href="{{ route('canboManage.danhsachlopday', ['mamonhoc' => $mamonhoc, 'hocky' => 1]) }}">
                    <button class="btn {{ request()->is('*1') ? 'btn-success' : '' }}">Học Kì 1</button></a>
                <a href="{{ route('canboManage.danhsachlopday', ['mamonhoc' => $mamonhoc, 'hocky' => 2]) }}">
                    <button class="btn {{ request()->is('*2') ? 'btn-success' : '' }}">Học Kì 2</button></a>
                <a href="{{ route('canboManage.bangdiemcanamlopday', ['mamonhoc' => $mamonhoc]) }}">
                    <button class="btn {{ request()->is('*3') ? 'btn-success' : '' }}">Cả Năm</button></a>
                <a href="{{ route('canboManage.excelExport', ['$thongtinlop->malop']) }}">
                    <button class="btn">Excel</button></a>
            </div>
        </div>
        <div class="card-body">
            <table style="width: 100%;" class="table table-bordered table-hover table-checkable" id="danhSachDiem">
                <thead class="thead-light">
                    <tr>
                        <th rowspan="2" class="text-center">STT</th>
                        <th rowspan="2" class="text-center">Họ Tên Học Sinh</th>
                        @foreach ($dataloaidiem as $item => $loaidiem)
                            <th colspan="{{ $loaidiem->soluong }}" class="text-center diem" data-dt-order="disable">
                                {{ $loaidiem->tenloaidiem }}
                                {{ $lankt[] = $loaidiem->soluong }}
                            </th>
                        @endforeach
                        @if ($hocki < 3)
                            <th rowspan="2" class="text-center diem">TBM</th>
                            <th rowspan="2" class="text-center noExport">Thao tác</th>
                        @endif
                    </tr>
                    <tr>
                        @foreach ($lankt as $value)
                            @for ($i=1; $i <= $value ; $i++)
                                <th data-dt-order="disable" class="text-center">L{{ $i }}</th>
                            @endfor
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    @foreach ($danhsach as $item => $value)
                        <tr>
                            <td class="text-center font-weight-bold">{{ $item + 1 }}</td>
                            @foreach ($value as $key => $v)
                                @if ($key == 'tenhocsinh')
                                    <td class="text-center">{{ $v }}</td>
                                @elseif ($key == 'tbm' && $hocki < 3)
                                    <td class="text-center diem">
                                        {{ $v == '' ? '' : number_format((float) $v, 1, '.', '') }}</td>
                                @elseif ($key == 'mahocsinh')
                                    @if ($hocki < 3)
                                        <td class="text-center">
                                            <a href="{{ route('diemManage.edit', ['hocki' => $hocki, 'mamonhoc' => $mamonhoc, 'mahocsinh' => $v]) }}"
                                                class="btn btn-primary" title="Chỉnh sửa">Chỉnh sửa</a>
                                        </td>
                                    @endif
                                @elseif($key == 'diem')
                                    @foreach ($v as $keydiem => $diem)
                                        <td class="text-center">
                                            {{ $diem == '' ? '' : number_format((float) $diem, 2, '.', '') }}
                                        </td>
                                    @endforeach
                                @else
                                    <td class="text-center">{{ $v == '' ? '' : number_format((float) $v, 1, '.', '') }}
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!--end: Datatable-->
        </div>
    </div>
@endsection
@section('styles')
    {{-- <link rel="stylesheet" href="{{ asset('css/crud/datatables/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.bundle.css') }}"> --}}
@endsection
@section('scripts')
    <script src="{{ asset('js/crud/lopday_datatables.js') }}"></script>
@endsection
