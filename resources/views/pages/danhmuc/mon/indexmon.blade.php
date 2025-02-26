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
                <h4>Quản Lý Thông Tin Môn</h4>
                <hr>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('monManage.createMon') }}"><button class="btn btn-success">Tạo mới</button></a>
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <table style="width: 100%;" class="table table-hover table-checkable" id="danhSachMon">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">STT</th>
                        <th class="text-center">Mã Môn</th>
                        <th class="text-center">Tên Môn</th>
                        <th class="text-center">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item => $value)
                        <tr>
                            <td class="text-center font-weight-bold">{{ $item + 1 }}</td>
                            <td class="text-center">{{ $value->mamon }}</td>
                            <td class="text-center">{{ $value->tenmon }}</td>
                            <td class="text-center" style="display: flex; justify-content: center">
                                <table>
                                    <tr>
                                        <td class="border-0 pt-0 pb-0">
                                            <a href="{{ route('monManage.editMon', ['mamon' => $value->mamon]) }}"
                                                class="btn btn-sm btn-clean btn-icon btn-primary" title="Chỉnh sửa">
                                                Chỉnh Sửa
                                            </a>
                                        </td>
                                        <td style="padding-left: 3px" class="border-0 pt-0 pb-0">
                                            <a href="{{ route('monManage.deleteMon', ['mamon' => $value->mamon]) }}"
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
    <script src="{{ asset('js/crud/mon_datatables.js') }}"></script>
@endsection
