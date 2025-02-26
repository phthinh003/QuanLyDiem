@extends('layouts.phuhuynh.layoutphuhuynh')
@section('content')
    <div class="mt-2 pt-2 card card-custom">

        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="cart-title mb-3">
                @foreach ($thongtinhs as $item => $value)
                    @foreach ($value as $key => $v)
                        {{ $key }} : {{ $v }}<br />
                    @endforeach
                @endforeach
            </div>
            <hr>
            <div class="card-toolbar">
                <a
                    href="{{ route('phuhuynhManage.diemhocsinhPH', ['mahocsinh' => $mahocsinh, 'malop' => $malop, 'hocki' => 1]) }}">
                    <button class="btn  {{ request()->is('*1') ? 'btn-success' : '' }}">Học kì 1</button>
                </a>
                <a
                    href="{{ route('phuhuynhManage.diemhocsinhPH', ['mahocsinh' => $mahocsinh, 'malop' => $malop, 'hocki' => 2]) }}">
                    <button class="btn {{ request()->is('*2') ? 'btn-success' : '' }}">Học kì 2</button>
                </a>
                <a href="{{ route('phuhuynhManage.getDiemCaNamHSPH', ['mahocsinh' => $mahocsinh, 'malop' => $malop]) }}">
                    <button class="btn {{ request()->is('*3') ? 'btn-success' : '' }}">Cả năm</button>
                </a>
                {{-- <a href="{{ route('canboManage.createCanbo') }}"><button class="btn btn-success">Tạo mới</button></a> --}}
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <table style="width: 100%;" class="table table-hover table-checkable" id="danhSachDiem">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">STT</th>
                        <th class="text-center">Tên Môn</th>
                        @foreach ($dataloaidiem as $item => $loaidiem)
                            <th class="text-center" colspan="{{ $loaidiem->soluong }}">{{ $loaidiem->tenloaidiem }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($danhsach as $item => $value)
                        <tr>
                            <td class="text-center font-weight-bold">{{ $item + 1 }}</td>
                            @foreach ($value as $key => $v)
                                @if ($key == 'diem')
                                    @foreach ($v as $keydiem => $diem)
                                        <td class="text-center">{{ $diem == '' ? '' : number_format((float) $diem, 2, '.', '') }}
                                        </td>
                                    @endforeach
                                @elseif($key == 'tenmon')
                                    <td class="text-center">{{ $v }}</td>
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
@section('scripts')
    <script src="{{ asset('js/crud/canbo_datatables.js') }}"></script>
@endsection
