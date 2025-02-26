@extends('layouts.admin.layout')
@section('content')
    <div class="card pt-2 mt-2">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                {{ $page_title }}
            </div>
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
            <div class="card-toolbar">
                @if($phuhuynh==null)
                    <div class="alert alert-danger">Chưa liên kết với tài khoản phụ huynh
                        <a href="{{ route('hocsinhManage.editLienKet',['mahocsinh'=>$info->mahocsinh]) }}">
                            <button class="btn btn-success">Liên kết tài khoản phụ huynh</button>
                        </a>

                    </div>

                @endif

            </div>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('hocsinhManage.update') }}" class="form" name="formEditHocSinh"
                id="formedithocsinh">
                {{ csrf_field() }}
                @method("put")
                <div class="row">
                    <div class="col-xl-2"></div>
                    <div class="col-xl-8">
                        <div class="my-5">
                            <input type="hidden" name="mahocsinh" id="mahocsinh" value="{{ $info->mahocsinh }}">
                            <div class="row mb-3 align-items-center justify-content-center">
                                <label class="col-3">Họ tên <span class="text-danger">*</span>
                                </label>
                                <div class="col-6">
                                    <input type="text" name="hotenhocsinh" id="hoten" class="form-control"
                                        placeholder="Nhập họ tên học sinh" value="{{ $info->hotenhocsinh }}" />
                                </div>
                            </div>
                            <div class="mb-3 align-items-center justify-content-center row">
                                <label class="col-3">Giới tính<span class="text-danger">*</span></label>
                                <div class="col-6">
                                    <input type="radio" value="0" name="gioitinh" id="nam" {{ $info->gioitinh==0 ? "checked" : "" }}>Nam
                                    <input type="radio" value="1" name="gioitinh" id="nu" {{ $info->gioitinh==1 ? "checked" : "" }}>Nữ
                                    <input type="radio" value="2" name="gioitinh" id="khac" {{ $info->gioitinh==2 ? "checked" : "" }}>Khác
                                </div>
                            </div>
                            <div class="mb-3 align-items-center justify-content-center row">
                                <label class="col-3">Ngày Sinh<span class="text-danger">*</span></label>
                                <div class="col-6">
                                    <input type="date" name="ngaysinh" id="ngaysinh" class="form-control" value="{{ $info->ngaysinh }}">
                                </div>
                            </div>
                            <div class="mb-3 align-items-center justify-content-center row">
                                <label class="col-3">Địa Chỉ<span
                                        class="text-danger">*</span></label>
                                <div class="col-6">
                                    <textarea class="form-control" name="diachi" id="diachi" cols="30" rows="5"
                                        placeholder="Nhập vào địa chỉ">{{ $info->diachi }}</textarea>
                                </div>
                            </div>
                            <div class="mb-3 align-items-center justify-content-center row">
                                <label class="col-3">Số Điện Thoại<span
                                        class="text-danger">*</span></label>
                                <div class="col-6">
                                    <input class="form-control" type="text" name="sdt" id="sdt"
                                        placeholder="Nhập vào số điện thoại" value="{{ $info->sdt }}"/>
                                </div>
                            </div>
                            <div class="mb-3 align-items-center justify-content-center row">
                                <label class="col-3">Mật Khẩu<span
                                        class="text-danger">*</span></label>
                                <div class="col-6">
                                    <input class="form-control" type="password" name="matkhau" id="matkhau"
                                        placeholder="Không nhập nếu không cập nhật mật khẩu"/>
                                </div>
                            </div>
                            <div class="modal-footer mt-5 me-5">
                                <div class="d-flex flex-wrap border-0 pt-6 pb-0">
                                    <div class="d-flex">
                                        <a href="{{ route('hocsinhManage.index') }}" @include('layouts.button._button_back')
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
    @if ($phuhuynh!=null)
    <div class="card pt-2 mt-2">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">


                Tài khoản phụ huynh đã liên kết
            </div>
            <div class="card-body">
                <table style="width: 100%;" class="table table-hover table-checkable" id="danhSachPhuHuynh">
                    <thead class="thead-light">
                        <tr>
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
                            <tr>
                                <td class="text-center">{{ $phuhuynh->maphuhuynh }}</td>
                                <td class="text-center">{{ $phuhuynh->tenphuhuynh }}</td>
                                <td class="text-center">
                                    @if ($phuhuynh->gioitinh == 0)
                                        Nam
                                    @else
                                        @if ($phuhuynh->gioitinh == 1)
                                            Nữ
                                        @else
                                            Khác
                                        @endif
                                    @endif
                                </td>
                                <td class="text-center">{{ $phuhuynh->ngaysinh }}</td>
                                <td class="text-center">{{ $phuhuynh->diachi }}</td>
                                <td class="text-center">{{ $phuhuynh->sdt }}</td>
                                <td class="text-center" style="display: flex; justify-content: center">
                                    <a href="{{ route('hocsinhManage.deleteLienKet', ['mahocsinh'=>$info->mahocsinh]) }}"
                                        id="delete" class="btn btn-sm btn-icon btn-danger"
                                        data-confirm-delete="true" title="xoá">
                                        <i class="la la-trash"></i>Huỷ liên kết tài khoản
                                    </a>
                                </td>
                            </tr>
                    </tbody>
                </table>
            </div>



    </div>
    @endif
@endsection

