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
        </div>
        <div class="card-body">
            <form action="{{ route('diemManage.update') }}" method="post">
                @csrf
                @method('post')
                {{-- hidden: mot so du lieu dung de truy van --}}
                <input type="hidden" name="mahocsinh" value="{{ $datahocsinh->mahocsinh }}" />
                <input type="hidden" name="mamonhoc" value="{{ $monhoc->mamonhoc }}" />
                <input type="hidden" name="hocki" value="{{ $hocki }}" />

                <div class="row">
                    <div class="col-xl-2"></div>
                    <div class="col-xl-8">
                        <div class="my-5">
                            @foreach ($diem as $i => $value)
                                <div class="row mb-3 align-items-center justify-content-center">
                                    <label class="col-3">{{ $value['tenloaidiem'] }}</label>
                                    <div class="col-6">
                                        @foreach ($value['diem'] as $key => $value2)
                                            <input class="form-input-diem" name="{{ $key }}" type="number"
                                                min="0" max="10" step="0.01" value="{{ $value2 }}" />
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
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
