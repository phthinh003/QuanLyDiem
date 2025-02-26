@extends('layouts.login.layout')

@section('styles')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection
@section('content')
    <img class="bg" src="{{ asset('images/bgSchool.jpg') }}" alt="">
    <div class="frame">
        <img class="logobg" src="{{ asset("images/logo1000.png") }}" alt="" width="500px" >
    </div>

    <div class="d-flex full">
        <div class="form-login">
            <div class="login text-center p-2">
                <form action="{{ route('xacthuc-login') }}" method="post">
                    @csrf

                    <div class="login-title">
                        <h3>Đăng nhập</h3>
                        <span>Nhập thông tin tài khoản đăng nhập</span>
                    </div>

                    <div class="mb-4">
                        <input type="text" class="form-control b-radius-20" id="username" name="username"
                            placeholder="Tài khoản" autocomplete="off"/>
                    </div>
                    <div class="mb-5">
                        <input type="password" class="form-control b-radius-20" id="password" name="password"
                            placeholder="Mật khẩu" />
                    </div>
                    <div>
                        <input class="btn btn-primary b-radius-20" type="submit" value="Đăng nhập" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
