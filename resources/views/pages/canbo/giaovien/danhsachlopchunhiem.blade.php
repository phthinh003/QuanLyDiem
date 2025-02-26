@extends('layouts.canbo.layoutcanbo')
@section('content')
    <div class="mt-2 pt-2 card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="cart-title">
                @foreach($thongtinlop as $item => $value)
                    @foreach($value as $key => $v)
                       {{ $key }} : {{ $v }}<br/>
                    @endforeach
                @endforeach
            </div>
            <hr>
            <div class="card-toolbar">

                <a href="{{ route('canboManage.danhsachlopchunhiem', ['malop' => $malop, 'hocky' => 1]) }}">
                    <button class="btn {{ request()->is('*1') ? 'btn-success' : '' }}">Học Kì 1</button></a>
                <a href="{{ route('canboManage.danhsachlopchunhiem', ['malop' => $malop, 'hocky' => 2]) }}">
                    <button class="btn {{ request()->is('*2') ? 'btn-success' : '' }}">Học Kì 2</button></a>
                    <a href="{{ route('canboManage.bangdiemcanamlopchunhiem', ['malop' => $malop]) }}">
                        <button class="btn {{ request()->is('*3') ? 'btn-success' : '' }}">Cả Năm</button></a>
            </div>
        </div>
        <div class="card-body">
            <table style="width: 100%;" class="table table-hover table-checkable" id="danhSachLopChuNhiem">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">STT</th>
                        <th class="text-center">Họ Tên Học Sinh</th>
                        @foreach ($datamon as $item => $mon)
                            <th class="text-center">{{ $mon->tenmon }}</th>
                        @endforeach
                        <th>TB</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($danhsach as $item => $value)
                        <tr>
                            <td class="text-center font-weight-bold">{{ $item + 1 }}</td>

                            @foreach ($value as $key => $v)
                                @if ($key=='tenhocsinh' || $key=='tb')
                                <td class="text-center">{{ $key=='tb'?$v==""?"":number_format((float)$v, 1, '.', ''):$v }}</td>
                                @elseif($key=='diem')
                                    @foreach ($v as $diemkey=> $diem)
                                        <td class="text-center">{{ $diem==""?"": number_format((float)$diem, 1, '.', '') }}</td>
                                    @endforeach
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
    <script src="{{ asset('js/crud/lopchunhiem_datatables.js') }}"></script>
@endsection
