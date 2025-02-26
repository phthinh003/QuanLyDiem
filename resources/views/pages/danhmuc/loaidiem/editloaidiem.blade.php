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
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('loaidiemManage.updateLoaiDiem') }}" class="form" name="formEditLoaiDiem"
                id="formeditloaidiem">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-xl-2"></div>
                    <div class="col-xl-8">
                        <div class="my-5">
                            <input type="hidden" name="maloaidiem" id="maloaidiem" value="{{ $info->maloaidiem }}">
                            <div class="row mb-3 align-items-center justify-content-center">
                                <label class="col-3">Loại điểm
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-6">
                                    <input type="text" name="tenloaidiem" id="tenloaidiem" class="form-control"
                                        placeholder="Nhập tên môn" value="{{ $info->tenloaidiem }}"/>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-center justify-content-center">
                                <label class="col-3">Hệ số<span
                                    class="text-danger">*</span></label>
                            <div class="col-6">
                                <select class="form-select" name="heso" id="heso">
                                    <option value="1" {{ $info->heso==1 ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ $info->heso==2 ? 'selected' : '' }}>2</option>
                                    <option value="3" {{ $info->heso==3 ? 'selected' : '' }}>3</option>
                                </select>
                            </div>
                            </div>
                            <div class="row mb-3 align-items-center justify-content-center">
                                <label class="col-3">Số lượng
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-6">
                                    <input type="number" name="soluong" id="soluong" class="form-control"
                                        placeholder="Nhập số lượng" value="{{ $info->soluong }}" />
                                </div>
                            </div>


                            <div class="modal-footer mt-5 me-5">
                                <div class="d-flex flex-wrap border-0 pt-6 pb-0">
                                    <div class="d-flex">
                                        <a href="{{ route('loaidiemManage.indexLoaiDiem') }}" @include('layouts.button._button_back')
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
