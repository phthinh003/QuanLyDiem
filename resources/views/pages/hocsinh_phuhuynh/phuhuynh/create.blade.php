@extends('layouts.admin.layout')
@section('content')
    <div class="card pt-2 mt-2">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            Thêm mới thông tin phụ huynh
            @if ($errors->any())
                <div class="alert alert-danger pt-6 pb-0">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="alert-text">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('phuhuynhManage.store') }}" class="form" name="formCreatePhuHuynh"
                id="formcreatephuhuynh">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-xl-2"></div>
                    <div class="col-xl-8">
                        <div class="my-5">
                            <div class="row mb-3 align-items-center justify-content-center">
                                <label class="col-3">Họ tên <span class="text-danger">*</span>
                                </label>
                                <div class="col-6">
                                    <input type="text" name="tenphuhuynh" id="hoten" class="form-control"
                                        placeholder="Nhập họ tên" />
                                </div>
                            </div>
                            <div class="mb-3 align-items-center justify-content-center row">
                                <label class="col-3">Giới tính<span class="text-danger">*</span></label>
                                <div class="col-6">
                                    <input type="radio" value="0" name="gioitinh" id="nam" checked>Nam
                                    <input type="radio" value="1" name="gioitinh" id="nu">Nữ
                                    <input type="radio" value="2" name="gioitinh" id="khac">Khác
                                </div>
                            </div>
                            <div class="mb-3 align-items-center justify-content-center row">
                                <label class="col-3">Ngày Sinh<span class="text-danger">*</span></label>
                                <div class="col-6">
                                    <input type="date" name="ngaysinh" id="ngaysinh" class="form-control">
                                </div>
                            </div>
                            <div class="mb-3 align-items-center justify-content-center row">
                                <label class="col-3">Địa Chỉ<span
                                        class="text-danger">*</span></label>
                                <div class="col-6">
                                    <textarea class="form-control" name="diachi" id="diachi" cols="30" rows="5"
                                        placeholder="Nhập vào địa chỉ"></textarea>
                                </div>
                            </div>
                            <div class="mb-3 align-items-center justify-content-center row">
                                <label class="col-3">Số Điện Thoại<span
                                        class="text-danger">*</span></label>
                                <div class="col-6">
                                    <input class="form-control" type="text" name="sdt" id="sdt"
                                        placeholder="Nhập vào số điện thoại" />
                                </div>
                            </div>
                            <div class="mb-3 align-items-center justify-content-center row">
                                <label class="col-3">Mật Khẩu<span
                                        class="text-danger">*</span></label>
                                <div class="col-6">
                                    <input class="form-control" type="password" name="matkhau" id="matkhau"
                                        placeholder="Nhập vào mật khẩu" />
                                </div>
                            </div>
                            <div class="modal-footer mt-5 me-5">
                                <div class="flex-wrap border-0 pt-6 pb-0">
                                    <div class="d-flex">
                                        <a href="{{ route('phuhuynhManage.index') }}" @include('layouts.button._button_back')
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
@endsection
