@extends('layouts.admin.layout')
@section('content')
    <div class="mt-2 pt-2 card card-custom">
        {{-- @if (session('success'))
            <div class="alert alert-success">
                <p>{{ session('success') }}</p>
            </div>
        @endif --}}
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            {{-- @include('layout.base._pagename') --}}
            <div class="cart-title">
                Thêm học sinh vào lớp {{ $lop->tenlop }}
            </div>
            <div class="card-toolbar">
                {{-- <a href="{{ route('lopManage.createLop') }}"><button class="btn btn-success">Tạo mới</button></a> --}}
                <!--end::Button-->
            </div>
            <hr>
        </div>
        <div class="card-body">
            <table style="width: 100%;" class="table table-hover table-checkable" id="danhSachHocSinh">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">STT</th>
                        <th class="text-center">Mã số</th>
                        <th class="text-center">Họ Tên</th>
                        {{-- <th class="text-center">Lớp</th> --}}
                        <th class="text-center">Giới Tính</th>
                        <th class="text-center">Ngày sinh</th>
                        <th class="text-center">Địa chỉ</th>
                        <th class="text-center">SĐT</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item => $value)
                        <tr>
                            <td class="text-center font-weight-bold">{{ $item + 1 }}</td>
                            <td class="text-center">{{ $value->mahocsinh }}</td>
                            <td class="text-center">{{ $value->hotenhocsinh }}</td>
                            {{-- <td class="text-center"></td> --}}
                            <td class="text-center">
                                @if ($value->gioitinh == 0)
                                    Nam
                                @else
                                    @if ($value->gioitinh == 1)
                                        Nữ
                                    @else
                                        Khác
                                    @endif
                                @endif
                            </td>
                            <td class="text-center">{{ $value->ngaysinh }}</td>
                            <td class="text-center">{{ $value->diachi }}</td>
                            <td class="text-center">{{ $value->sdt }}</td>
                            <td class="text-center">
                                    <a href="{{ route('lophocManage.storeLophoc', ['mahocsinh' => $value->mahocsinh,'malop'=>$lop->malop]) }}"
                                        class="btn btn-sm btn-clean btn-icon btn-primary" title="Thêm">
                                        Thêm vào lớp {{ $lop->tenlop }}
                                    </a>
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
    <script src="{{ asset('js/crud/hocsinh_datatables.js') }}"></script>
@endsection
