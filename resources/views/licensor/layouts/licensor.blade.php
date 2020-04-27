<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title> 
    Verify Purchase
  </title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  

  @section('css')
    <!-- CSS -->
    <link rel="stylesheet" href="/vendor/licensor/css/bootstrap.min.css">
    <link rel="stylesheet" href="/vendor/licensor/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/vendor/licensor/css/licensor.css">
  @show
  
  @section('js')
    <script src="/vendor/licensor/js/modernizr.js"></script>
    <script src="/vendor/licensor/js/wow.js"></script>
    <script type="text/javascript">
      wow = new WOW({
          animateClass: 'animated',
          offset: 100
      });
      wow.init();
    </script>
  @show

</head>
<body>

    <img src="/vendor/licensor/images/blurred.jpg" class="login-img wow fadeIn" alt="">

    <div class="center-vertical">
        <div class="center-content row">

            <div class="col-md-3 center-margin">
                <center>
                  <img src="/vendor/licensor/images/shield.png" class="wow fadeIn">
                  <h3 class="font-white wow fadeIn">License Check</h3>
                </center>
                <br>
                @yield('content')
            </div>

        </div>
    </div>
</body>
</html>
