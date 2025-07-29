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
                <h4>Phân Công Giảng Dạy</h4>
            </div>
            <hr>
            <div class="card-toolbar">

                <!--end::Button-->
                <div class="row">
                    <div class="col-2">
                        {{-- Tao lop moi --}}
                        <a href="{{ route('monhocManage.createMonHoc') }}"><button class="btn btn-success">Tạo mới</button></a>
                        <!--end::Button-->
                    </div>
                    <div class="col-4">

                        <form method="get" action="{{ route('monhocManage.indexMonHoc') }}" id="lietke">
                            <div class="row">
                                <div class="col">
                                    <select class="form-select" name="nienkhoa" id="nienkhoa">
                                        <option {{ $manienkhoa == 'all' ? 'selected' : '' }} value="all">Tất cả</option>
                                        @foreach ($nienkhoa as $item => $nk)
                                            <option {{ $manienkhoa == $nk->manienkhoa ? 'selected' : '' }}
                                                value="{{ $nk->manienkhoa }}">{{ $nk->tennienkhoa }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col"><button type="submit" class="btn btn-primary">Liệt kê</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table style="width: 100%;" class="table table-hover table-checkable" id="danhSachMonHoc">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">STT</th>
                        <th class="text-center">Tên Lớp</th>
                        <th class="text-center">Niên Khóa</th>
                        <th class="text-center">Môn</th>
                        <th class="text-center">Cán bộ giảng dạy</th>
                        <th class="text-center">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item => $value)
                        <tr>
                            <td class="text-center font-weight-bold">{{ $item + 1 }}</td>
                            <td class="text-center">{{ $value->tenlop }}</td>
                            <td class="text-center">{{ $value->tennienkhoa }}</td>
                            <td class="text-center">{{ $value->tenmon }}</td>
                            <td class="text-center">{{ $value->hoten }}</td>
                            <td class="text-center" style="display: flex; justify-content: center">
                                <table>
                                    <tr>
                                        <td class="border-0 pt-0 pb-0">
                                            <a href="{{ route('monhocManage.editMonHoc', ['mamonhoc' => $value->mamonhoc]) }}"
                                                class="btn btn-sm btn-clean btn-icon btn-primary" title="Chỉnh sửa">
                                                Chỉnh Sửa
                                            </a>
                                        </td>
                                        <td style="padding-left: 3px" class="border-0 pt-0 pb-0">
                                            <a href="{{ route('monhocManage.deleteMonHoc', ['mamonhoc' => $value->mamonhoc]) }}"
                                                id="delete" class="btn btn-sm btn-icon btn-danger"
                                                data-confirm-delete="true" title="xoá">
                                                <i class="la la-trash"></i>Xoá
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
    <script src="{{ asset('js/crud/monhoc_datatables.js') }}"></script>
@endsection
