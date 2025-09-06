@extends('layouts.canbo.layoutcanbo')
@section('styles')
    <style>
        .form-input-diem {
            border-radius: 0.25rem;
        }
    </style>
@endsection
@section('content')
    <div class="card pt-2 mt-2">
        <div class="card-header flex-wrap border-0 pt-6 pb-6">
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
            {{-- Thong tin hoc sinh --}}
            <div>
                <b>{{ $data->hotenhocsinh }} |
                    {{ $data->tenlop }} |
                    {{ $data->tennienkhoa }}
                </b>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('canboManage.luudanhgia') }}" method="post">
                @csrf
                @method('post')
                <div class="row">
                    <div class="col-xl-2"></div>
                    <div class="col-xl-8">
                        <div class="my-5">
                            <div class="form-group row align-items-center mb-4">
                                <label class="col-md-3 col-form-label text-right font-weight-bold">
                                    Mã học sinh
                                </label>
                                <div class="col-md-8">
                                    <div class="form-row">
                                        <div class="col">
                                            {{ $data->mahocsinh }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="mahocsinh" value="{{ $data->mahocsinh }}">
                            <input type="hidden" name="manienkhoa" value="{{ $data->nienkhoa }}">
                            <input type="hidden" name="malop" value="{{ $data->malop }}">
                            <div class="form-group row align-items-center mb-4">
                                <label class="col-md-3 col-form-label text-right font-weight-bold">
                                    Niên khoá
                                </label>
                                <div class="col-md-8">
                                    <div class="form-row">
                                        <div class="col">
                                            {{ $data->tennienkhoa }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row align-items-center mb-4">
                                <label class="col-md-3 col-form-label text-right font-weight-bold">
                                    Số ngày nghỉ
                                </label>
                                <div class="col-md-8">
                                    <div class="form-row">
                                        <div class="col">
                                            <input class="form-control"  type="number" name="tongnghi" id="tongnghi" placeholder="Nhập tổng số ngày nghỉ">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row align-items-center mb-4">
                                <label class="col-md-3 col-form-label text-right font-weight-bold">
                                    Được lên lớp
                                </label>
                                <div class="col-md-8">
                                    <div class="form-row">
                                        <div class="col">
                                            <select class="form-control"  name="duoclenlop" id="duoclenlop">
                                                <option value="">[Trống]</option>
                                                <option value="0">Được lên lớp</option>
                                                <option value="1">Không được lên lớp</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row align-items-center mb-4">
                                <label class="col-md-3 col-form-label text-right font-weight-bold">
                                    Chứng chỉ nghề phổ thông
                                </label>
                                <div class="col-md-8">
                                    <div class="form-row">
                                        <div class="col">
                                            <input class="form-control" type="text" name="ccnpt" id="ccnpt" placeholder="Nhập nghề phôt thông">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row align-items-center mb-4">
                                <label class="col-md-3 col-form-label text-right font-weight-bold">
                                    Xếp loại chứng chỉ nghề phổ thông
                                </label>
                                <div class="col-md-8">
                                    <div class="form-row">
                                        <div class="col">
                                            <input class="form-control" type="text" name="xeploiacc" id="xeploaicc" placeholder="Nhập xếp loại chứng chỉ">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row align-items-center mb-4">
                                <label class="col-md-3 col-form-label text-right font-weight-bold">
                                    Giải thưởng
                                </label>
                                <div class="col-md-8">
                                    <div class="form-row">
                                        <div class="col">
                                            <input type="text" class="form-control" name="giaithuong" id="giaithunog" placeholder="Nhập giải thưởng">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row align-items-center mb-4">
                                <label class="col-md-3 col-form-label text-right font-weight-bold">
                                    Nhận xét
                                </label>
                                <div class="col-md-8">
                                    <div class="form-row">
                                        <div class="col">
                                            <textarea class="form-control" rows="4" name="nhanxet" id="nhanxet"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row align-items-center mb-4">
                                <label class="col-md-3 col-form-label text-right font-weight-bold">
                                    Hạnh kiểm học kỳ 1
                                </label>
                                <div class="col-md-8">
                                    <div class="form-row">
                                        <div class="col">
                                            <select class="form-control" name="hk_hk1" id="hk_hk1">
                                                <option value="1">Tốt</option>
                                                <option value="2">Khá</option>
                                                <option value="3">Trung Bình</option>
                                                <option value="4">Yếu</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row align-items-center mb-4">
                                <label class="col-md-3 col-form-label text-right font-weight-bold">
                                    Hạnh kiểm học kỳ 2
                                </label>
                                <div class="col-md-8">
                                    <div class="form-row">
                                        <div class="col">
                                            <select class="form-control" name="hk_hk2" id="hk_hk2">
                                                <option value="1">Tốt</option>
                                                <option value="2">Khá</option>
                                                <option value="3">Trung Bình</option>
                                                <option value="4">Yếu</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Footer --}}
                            <div class="modal-footer mt-5 me-5">
                                <div class="flex-wrap border-0 pt-6 pb-0">
                                    <div class="d-flex">
                                        {{-- <a href="{{ route('loaidiemManage.indexLoaiDiem') }}" @include('layouts.button._button_back')
                                        </a> --}}
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
