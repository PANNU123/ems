<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in (v2)</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
{{--      <a href="index2.html" class="h1"><b>Screen </b> Lock</a>--}}
        <img src="{{asset('assets/dist/img/ems.png')}}" alt="DHL Logo" class="" style="height: 100px;width: 280px;">
    </div>
    <div class="card-body">
        <p class="login-box-msg">{{Auth::user()->email}}</p>
      <form action="{{ route('backend.unlock') }}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
      <div class="social-auth-links text-center mt-2 mb-3">
        <button type="submit" class="btn btn-block btn-primary">Unlock</button>
      </div>
    </form>
    </div>
  </div>
</div>
</body>
</html>
