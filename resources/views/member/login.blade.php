@extends('layouts.shop')
@section('title')
MaMa好閒
@endsection

@section('title_href')
<a class="navbar-brand" href="{{ url('/') }}">
    MaMa好閒
</a>
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">會員登入</div>

                <div class="card-body">
                    <form method="POST" action="/member/auth/login">
                        @csrf

                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">手機號碼</label>

                            <div class="col-md-6">
                                <input id="phone" type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete autofocus>

                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">密碼</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>



                        <div class="row mb-0">
                            <div class="col col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    登入
                                </button>
                                

                            </div>
                            <div class="col col-md-3 offset-md-4">
                                <a href="/member/register/step1">註冊會員</a>

                            </div>
                            <div class="col col-md-3 offset-md-4">

                                <a href="/member/forget">忘記密碼</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection