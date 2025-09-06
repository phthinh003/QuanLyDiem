@extends('layouts.canbo.layoutcanbo')
@section('content')
    <div class="mt-2 pt-2 card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="cart-title">
                @foreach($thongtinlop as $key => $value)
                       {{ $key }} : {{ $value }}<br/>
                @endforeach
            </div>
            <hr>
        </div>
        <div class="card-body">
            <table style="width: 100%;" class="table table-hover table-checkable" id="danhSachLop">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">STT</th>
                        <th class="text-center">Mã số</th>
                        <th class="text-center">Họ Tên Học Sinh</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($danhsachlop as $item => $value)
                        <tr>
                            <td class="text-center font-weight-bold">{{ $item + 1 }}</td>
                            <td class="text-center">{{ $value->mahocsinh }}</td>
                            <td class="text-center">{{ $value->hotenhocsinh }}</td>
                            <td class="text-center">
                                <a href="{{ route('canboManage.danhgiahocsinh', [$malop, $value->mahocsinh]) }}">
                                    <button class="btn btn-success">Đánh giá</button>
                                </a>
                                {{-- <br>
                                <hr>
                                <a class="mt-1" href="">
                                    <button class="btn btn-success">Chỉnh sửa</button>
                                </a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!--end: Datatable-->
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/crud/danhgianamhoc_datatables.js') }}"></script>
@endsection
