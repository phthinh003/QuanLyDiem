@extends('layouts.admin.layout')
@section('content')
    <div class="card pt-2 mt-2">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            Thêm mới thông tin lớp
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
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('lopManage.storeLop') }}" class="form" name="formCreateLop"
                id="formcreatelop">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-xl-2"></div>
                    <div class="col-xl-8">
                        <div class="my-5">
                            <div class="row mb-3 align-items-center justify-content-center">
                                <label class="col-3">Mã lớp
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-6">
                                    <input type="text" name="malop" id="malop" class="form-control" value="{{ old('malop') }}"
                                        placeholder="Nhập mã lớp" />
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center justify-content-center">
                                <label class="col-3">Tên lớp
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-6">
                                    <input type="text" name="tenlop" id="tenlop" class="form-control" value="{{ old('tenlop') }}"
                                        placeholder="Nhập tên lớp" />
                                </div>
                            </div>
                            <div class="mb-3 align-items-center justify-content-center row">
                                <label class="col-3">Niên khóa<span
                                        class="text-danger">*</span></label>
                                <div class="col-6">
                                    <select class="form-select" name="nienkhoa" id="nienkhoa">
                                        @foreach($datanienkhoa as $item =>$nienkhoa)
                                        <option {{ old('manienkhoa') == $nienkhoa->manienkhoa ? "selected" : "" }} value="{{ $nienkhoa->manienkhoa }}">{{ $nienkhoa->tennienkhoa }}</option>
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
                                        <option {{ old('chunhiem') == $canbo->macanbo ? "selected" : "" }} value="{{ $canbo->macanbo }}">{{$canbo->macanbo}} : {{ $canbo->hoten }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="modal-footer mt-5 me-5">
                                <div class="flex-wrap border-0 pt-6 pb-0">
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
@endsection
