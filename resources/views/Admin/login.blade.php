@extends('layouts.layoutauth')
@section('title', 'Login')
@section('loginbox')
@if (Session::has('success_message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success: </strong> {{ Session::get('success_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
    </div>
@endif
<div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="{{ url('/') }}" class="h1"><img src="{{ URL::asset('asset/img/favicon.ico') }}" class="img-fluid rounded" style="width: 60%; height: 100%"></a>
    </div>
    <form action="/login" method="POST">
    <div class="card-body">
        @if (Session::has('message'))
        <div class="alert alert-danger">
            <b>Error:</b> {{ Session::get('message') }}
        </div>
        @endif
      <p class="login-box-msg">Masukkan data diri anda</p>
        @csrf
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="E-mail" name="email" id="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        @error('username')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" id="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
           <p class="mt-3 mb-0">
            <a>Belum Punya Akun?</a><a href="/register" class="text-center"> Register Di sini</a>
          </p>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.card-body -->
  </div>
@endsection
