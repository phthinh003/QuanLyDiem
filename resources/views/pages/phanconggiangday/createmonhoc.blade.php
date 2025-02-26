@extends('layouts.admin.layout')
@section('content')
    <div class="card pt-2 mt-2">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            Phân công giảng dạy
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
            <form method="post" action="{{ route('monhocManage.storeMonHoc') }}" class="form" name="formCreateMonHoc"
                id="formcreatemonhoc">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-xl-2"></div>
                    <div class="col-xl-8">
                        <div class="my-5">
                            <div class="mb-3 align-items-center justify-content-center row">
                                <label class="col-3">Lớp<span
                                        class="text-danger">*</span></label>
                                <div class="col-6">
                                    <select class="form-select" name="malop" id="malop">
                                        @foreach($datalop as $item =>$lop)
                                        <option {{ old('malop') == $lop->malop ? 'selected' : '' }} value="{{ $lop->malop }}">{{$lop->malop}} : {{ $lop->tenlop }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 align-items-center justify-content-center row">
                                <label class="col-3">Cán bộ giảng dạy<span
                                        class="text-danger">*</span></label>
                                <div class="col-6">
                                    <select class="form-select" name="macanbo" id="macanbo">
                                        @foreach($datacanbo as $item =>$canbo)
                                        <option {{ old('macanbo') == $canbo->macanbo ? 'selected' : '' }} value="{{ $canbo->macanbo }}">{{$canbo->macanbo}} : {{ $canbo->hoten }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 align-items-center justify-content-center row">
                                <label class="col-3">Môn<span
                                        class="text-danger">*</span></label>
                                <div class="col-6">
                                    <select class="form-select" name="mamon" id="mamon">
                                        @foreach($datamon as $item =>$mon)
                                        <option {{ old('mamon') == $mon->mamon ? 'selected' : '' }} value="{{ $mon->mamon }}">{{$mon->mamon}} : {{ $mon->tenmon }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="modal-footer mt-5 me-5">
                                <div class="flex-wrap border-0 pt-6 pb-0">
                                    <div class="d-flex">
                                        <a href="{{ route('monhocManage.indexMonHoc') }}" @include('layouts.button._button_back')
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
