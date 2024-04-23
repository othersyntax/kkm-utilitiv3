<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name') }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('/template/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('/template/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/template/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/template/dist/css/customstyle.css') }}">
  <link rel="shortcut icon" href="{{ asset('/template/dist/img/favicon.ico') }}">
</head>
<body class="hold-transition login-page" style="
background-image: url('{{ asset('/template/dist/img/klsenja.png') }}');
background-size:100%;
"> 
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      {{-- <a href="" class="h1">e<b class="text-purple">SMPT</b></a>
      <p class="login-box-msg text-purple">Sistem Maklumat Pemantauan Tanah</p> --}}
      <img src="{{ asset('/template/dist/img/mainlogo.png') }}" alt="" width="200px" height="90px">
    </div>
    <div class="card-body">
        <p class="login-box-msg text-purple"></p>
      {{-- <form action="{{ route('semak-pengguna') }}" method="post"> --}}
      <form method="POST" action="{{ route('login') }}">
        @if (Session::has('berjaya'))
          <div class="alert alert-success">{{ Session::get('berjaya')}}</div>
        @endif
        @if (Session::has('gagal'))
            <div class="alert alert-danger">{{ Session::get('gagal')}}</div>
        @endif
        @csrf
        <div class="form-group">
          <div class="input-group">
            <input type="text" class="form-control" name="email" placeholder="E-Mel" value="{{ old('email') }}" >          
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <span class="text-danger">@error('email') {{ $message }}  </span> @enderror </span>
        </div>      
        <div class="form-group">
          <div class="input-group">
            <input type="password" class="form-control" name="password" placeholder="Katalaluan" >          
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <span class="text-danger">@error('password') {{ $message }}  </span> @enderror </span>
        </div>
        <div class="row mt-2">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Simpan log masuk
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Log Masuk</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="forgot-password.html">Lupa katalaluan</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('/template/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/template/dist/js/adminlte.min.js') }}"></script>
</body>
</html>
