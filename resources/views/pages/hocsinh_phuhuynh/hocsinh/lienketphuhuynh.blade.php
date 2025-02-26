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
                Liên kết tài khoản phụ huynh cho học sinh: {{ $info->hotenhocsinh }}
            </div>
            <hr>
        </div>
        <div class="card-body">
            <table style="width: 100%;" class="table table-hover table-checkable" id="danhSachPhuHuynh">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">STT</th>
                        <th class="text-center">Mã số</th>
                        <th class="text-center">Họ Tên</th>
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
                            <td class="text-center">{{ $value->maphuhuynh }}</td>
                            <td class="text-center">{{ $value->tenphuhuynh }}</td>
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
                            <td class="text-center" style="display: flex; justify-content: center">
                                <table>
                                    <tr>
                                        <td class="border-0 pt-0 pb-0">
                                            <a href="{{ route('hocsinhManage.storeLienKet', ['mahocsinh'=>$info->mahocsinh,'maphuhuynh' => $value->maphuhuynh]) }}"
                                                class="btn btn-sm btn-clean btn-icon btn-primary" title="Liên kết với tài khoản học sinh {{ $info->hotenhocsinh }}">
                                                Liên kết tài khoản học sinh
                                            </a>
                                        </td>
                                    </tr>
                                </table>
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
    <script src="{{ asset('js/crud/phuhuynh_datatables.js') }}"></script>
@endsection
