<!DOCTYPE html>
<html lang="en">
@include('admin.includes.head')
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    @include('admin.includes.preloader')
    @include('admin.includes.navbar')
    @include('admin.includes.sidebar')
    <div class="content-wrapper">
        @yield('content')
    </div>
    @include('admin.includes.footer')
</div>
@include('admin.includes.script')
</body>
</html>
