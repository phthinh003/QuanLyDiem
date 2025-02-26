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
            <form method="post" action="{{ route('monManage.updateMon') }}" class="form" name="formEditMon"
                id="formeditmon">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-xl-2"></div>
                    <div class="col-xl-8">
                        <div class="my-5">
                            <input type="hidden" name="mamon" id="mamon" value="{{ $info->mamon }}">
                            <div class="row mb-3 align-items-center justify-content-center">
                                <label class="col-3">Tên Môn
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-6">
                                    <input type="text" name="tenmon" id="tenmon" class="form-control"
                                        placeholder="Nhập tên môn" value="{{ $info->tenmon }}" />
                                </div>
                            </div>

                            <div class="modal-footer mt-5 me-5">
                                <div class="d-flex flex-wrap border-0 pt-6 pb-0">
                                    <div class="d-flex">
                                        <a href="{{ route('monManage.indexMon') }}" @include('layouts.button._button_back')
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
