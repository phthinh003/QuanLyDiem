@extends('layouts.admin.layout')
@section('content')
    <div class="card pt-2 mt-2">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            {{ $page_title }}
            @if ($errors->any())
                <div class="alert alert-danger pt-6 pb-0">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="alert-text">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <hr>
            <a href="{{ route('lophocManage.editLopHoc', ['malop' => $info->malop]) }}"><button class="btn btn-success">Thêm học sinh vào lớp</button></a>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('lopManage.updateLop') }}" class="form" name="formEditLop"
                id="formeditlop">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-xl-2"></div>
                    <div class="col-xl-8">
                        <div class="my-5">
                            <input type="hidden" name="malop" id="malop" value="{{ $info->malop }}">
                            <div class="row mb-3 align-items-center justify-content-center">
                                <label class="col-3">Tên lớp
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-6">
                                    <input type="text" name="tenlop" id="tenlop" class="form-control"
                                        placeholder="Nhập tên lớp" value="{{ old('tenlop', $info->tenlop) }}" />
                                </div>
                            </div>
                            <div class="mb-3 align-items-center justify-content-center row">
                                <label class="col-3">Niên khóa<span
                                    class="text-danger">*</span></label>
                            <div class="col-6">
                                <select class="form-select" name="nienkhoa" id="nienkhoa">
                                    @foreach($datanienkhoa as $item =>$nienkhoa)
                                    <option {{ old('manienkhoa') == $nienkhoa->manienkhoa ? "selected" : "" }} value="{{ $nienkhoa->manienkhoa }}" {{ $info->nienkhoa==$nienkhoa->manienkhoa ? 'selected' : ''}}>{{ $nienkhoa->tennienkhoa }}</option>
                                    @endforeach
                                </select>
                            </div>

                            </div>
                            <div class="mb-3 align-items-center justify-content-center row">
                                <label class="col-3">Cán bộ chủ nhiệm<span
                                    class="text-danger">*</span></label>
                            <div class="col-6">
                                <select class="form-select" name="chunhiem" id="chunhiem">
                                    @foreach($datacanbo as $item =>$canbo)
                                    <option {{ old('chunhiem') == $canbo->macanbo ? "selected" : "" }} value="{{ $canbo->macanbo }}" {{ $info->chunhiem==$canbo->macanbo ? 'selected' : ''}}>{{$canbo->macanbo}} : {{ $canbo->hoten }}</option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
                            <div class="modal-footer mt-5 me-5">
                                <div class="d-flex flex-wrap border-0 pt-6 pb-0">
                                    <div class="d-flex">
                                        <a href="{{ route('lopManage.indexLop') }}" @include('layouts.button._button_back')
                                        </a>
                                        <div class="btn-group">
                                            @include('layouts.button._button_save')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card pt-2 mt-2">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            Danh sách học sinh của lớp
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
                                <a href="{{ route('lophocManage.deleteLophoc', ['malophoc' => $value->malophoc]) }}"
                                    id="delete" class="btn btn-sm btn-icon btn-danger"
                                    data-confirm-delete="true" title="xoá">
                                    <i class="la la-trash"></i>Xoá học sinh khỏi lớp
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endsection
@section('scripts')
    <script src="{{ asset('js/crud/hocsinh_datatables.js') }}"></script>
@endsection
