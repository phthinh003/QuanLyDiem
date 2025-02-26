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
                <h4>Quản Lý Thông Tin Niên Khoá</h4>
                <hr>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('nienkhoaManage.createNienKhoa') }}"><button class="btn btn-success">Tạo mới</button></a>
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <table style="width: 100%;" class="table table-hover table-checkable" id="danhSachNienKhoa">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">STT</th>
                        <th class="text-center">Mã Niên Khóa</th>
                        <th class="text-center">Tên Niên Khóa</th>
                        <th class="text-center">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item => $value)
                        <tr>
                            <td class="text-center font-weight-bold">{{ $item + 1 }}</td>
                            <td class="text-center">{{ $value->manienkhoa }}</td>
                            <td class="text-center">{{ $value->tennienkhoa }}</td>
                            <td class="text-center" style="display: flex; justify-content: center">
                                <table>
                                    <tr>
                                        <td class="border-0 pt-0 pb-0">
                                            <a href="{{ route('nienkhoaManage.editNienKhoa', ['manienkhoa' => $value->manienkhoa]) }}"
                                                class="btn btn-sm btn-clean btn-icon btn-primary" title="Chỉnh sửa">
                                                Chỉnh Sửa
                                            </a>
                                        </td>
                                        <td style="padding-left: 3px" class="border-0 pt-0 pb-0">
                                            <a href="{{ route('nienkhoaManage.deleteNienKhoa', ['manienkhoa' => $value->manienkhoa]) }}"
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
    <script src="{{ asset('js/crud/nienkhoa_datatables.js') }}"></script>
@endsection
