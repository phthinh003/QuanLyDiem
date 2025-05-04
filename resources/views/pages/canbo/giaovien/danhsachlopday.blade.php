@extends('layouts.canbo.layoutcanbo')
@section('content')
    <div class="mt-2 pt-2 card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="cart-title">
                <input type="hidden" name="filename" value="{{ $filename }}" >
                @foreach ($thongtinlop as $item => $value)
                    @foreach ($value as $key => $v)
                        {{ $key }} : {{ $v }}<br />
                    @endforeach
                @endforeach
            </div>
            <hr>
            <div class="card-toolbar">
                {{-- <a href="{{ route('canboManage.createCanbo') }}"><button class="btn btn-success">Tạo mới</button></a> --}}
                <!--end::Button-->
                <a href="{{ route('canboManage.danhsachlopday', ['mamonhoc' => $mamonhoc, 'hocky' => 1]) }}">
                    <button class="btn {{ request()->is('*1') ? 'btn-success' : '' }}">Học Kì 1</button></a>
                <a href="{{ route('canboManage.danhsachlopday', ['mamonhoc' => $mamonhoc, 'hocky' => 2]) }}">
                    <button class="btn {{ request()->is('*2') ? 'btn-success' : '' }}">Học Kì 2</button></a>
                <a href="{{ route('canboManage.bangdiemcanamlopday', ['mamonhoc' => $mamonhoc]) }}">
                    <button class="btn {{ request()->is('*3') ? 'btn-success' : '' }}">Cả Năm</button></a>
                <a href="{{ route('canboManage.excelExport') }}">
                    <button class="btn">Excel</button></a>
            </div>
        </div>
        <div class="card-body">
            <table style="width: 100%;" class="table table-bordered table-hover table-checkable" id="danhSachDiem">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">STT</th>
                        <th class="text-center">Họ Tên Học Sinh</th>
                        @foreach ($dataloaidiem as $item => $loaidiem)
                            <th name="{{ $loaidiem->soluong > 1 ? 'nhieucot' : '' }}" class="text-center diem"
                                data-dt-order="disable">
                                {{ $loaidiem->tenloaidiem }}
                                <input type="hidden" value="{{ $loaidiem->soluong }}" />
                            </th>
                            @for ($i = 0; $i < $loaidiem->soluong - 1; $i++)
                                <th name="hidden" class="diem" data-dt-order="disable"></th>
                            @endfor
                        @endforeach
                        @if ($hocki < 3)
                            <th class="text-center diem">TBM</th>
                            <th class="text-center noExport">Thao tác</th>
                        @endif

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
                                    <td class="text-center diem">{{ $v == '' ? '' : number_format((float) $v, 1, '.', '') }}</td>
                                @elseif ($key == 'mahocsinh')
                                    @if ($hocki < 3)
                                        <td class="text-center">
                                            <a href="{{ route('diemManage.edit', ['hocki' => $hocki, 'mamonhoc' => $mamonhoc, 'mahocsinh' => $v]) }}"
                                                class="btn btn-primary" title="Chỉnh sửa">Chỉnh sửa</a>
                                        </td>
                                    @endif
                                @elseif($key == 'diem')
                                    @foreach ($v as $keydiem => $diem)
                                        <td class="text-center">{{ $diem == '' ? '' : number_format((float) $diem, 2, '.', '') }}
                                        </td>
                                    @endforeach
                                @else
                                    <td class="text-center">{{ $v == '' ? '' : number_format((float) $v, 1, '.', '') }}</td>
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
    <script>
        const columns = document.getElementsByName('nhieucot');
        columns.forEach(element => {
            let socot = element.getElementsByTagName('input')[0].value;
            element.setAttribute("colspan", socot);
        });

        const colDel = document.getElementsByName('hidden');
        colDel.forEach(element => {
            element.style.display = "none";
        });
    </script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script> --}}
@endsection
