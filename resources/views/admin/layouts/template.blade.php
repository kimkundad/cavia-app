<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title> @yield('title')</title>
  <!-- plugins:css -->
  @include('admin.layouts.inc-style')
  @yield('stylesheet')

</head>

<body>
  <div class="container-scroller">
    
    <!-- partial:partials/_horizontal-navbar.html -->
    @include('admin.layouts.inc-header')

    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <div class="main-panel">
        <div class="content-wrapper">


          @yield('content')


        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        @include('admin.layouts.inc-footer')
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
   
   
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  @include('admin.layouts.inc-script')
  @yield('scripts')
</body>

</html>
