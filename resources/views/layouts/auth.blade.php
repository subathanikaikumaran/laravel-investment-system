<!DOCTYPE html>
<html lang="en">

<head>
  <title>Investment System</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <meta name="keywords" content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
  <meta name="author" content="Codedthemes" />
  <!-- Favicon icon -->

  <!-- Google font-->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
  <!-- Required Fremwork -->
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/css/bootstrap/css/bootstrap.min.css')}}">
  <!-- waves.css -->
  <link rel="stylesheet" href="{{ asset('plugins/pages/waves/css/waves.min.css')}}" type="text/css" media="all">
  <!-- themify-icons line icon -->
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/icon/themify-icons/themify-icons.css')}}">
  <!-- ico font -->
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/icon/icofont/css/icofont.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/icon/font-awesome/css/font-awesome.min.css')}}">
  <!-- Style.css -->
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/css/style.css') }}">

  <!-- Notification.css -->
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/pages/notification/notification.css') }}">
  <script>
    window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]);  ?>
  </script>
</head>

<body themebg-pattern="theme1">
  <!-- Pre-loader start -->
  <div class="theme-loader">
    <div class="loader-track">
      <div class="preloader-wrapper">
        <div class="spinner-layer spinner-blue">
          <div class="circle-clipper left">
            <div class="circle"></div>
          </div>
          <div class="gap-patch">
            <div class="circle"></div>
          </div>
          <div class="circle-clipper right">
            <div class="circle"></div>
          </div>
        </div>
        <div class="spinner-layer spinner-red">
          <div class="circle-clipper left">
            <div class="circle"></div>
          </div>
          <div class="gap-patch">
            <div class="circle"></div>
          </div>
          <div class="circle-clipper right">
            <div class="circle"></div>
          </div>
        </div>

        <div class="spinner-layer spinner-yellow">
          <div class="circle-clipper left">
            <div class="circle"></div>
          </div>
          <div class="gap-patch">
            <div class="circle"></div>
          </div>
          <div class="circle-clipper right">
            <div class="circle"></div>
          </div>
        </div>

        <div class="spinner-layer spinner-green">
          <div class="circle-clipper left">
            <div class="circle"></div>
          </div>
          <div class="gap-patch">
            <div class="circle"></div>
          </div>
          <div class="circle-clipper right">
            <div class="circle"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Pre-loader end -->

  <section class="login-block">
    <!-- Container-fluid starts -->
    <div class="container">
      <div class="row">
        <div class="col-sm-12">

          <div class="text-center">
           <a href="http://0.0.0.0:3001/public"> 
             <img src="{{ asset('plugins/images/sys/logo2.png') }} " alt="logo.png">
           </a>
          </div>
          <div class="auth-box card">
            @yield('content')
          </div>
        </div>
        <!-- end of col-sm-12 -->
      </div>
      <!-- end of row -->
    </div>
    <!-- end of container-fluid -->
  </section>
  <!-- Required Jquery -->
  <script type="text/javascript" src="{{ asset('plugins/js/jquery/jquery.min.js')}} "></script>
  <script type="text/javascript" src="{{ asset('plugins/js/jquery-ui/jquery-ui.min.js')}} "></script>
  <script type="text/javascript" src="{{ asset('plugins/js/popper.js/popper.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('plugins/js/bootstrap/js/bootstrap.min.js ')}}"></script>
  <!-- waves js -->
  <script src="{{ asset('plugins/pages/waves/js/waves.min.js')}}"></script>
  <!-- jquery slimscroll js -->
  <script type="text/javascript" src="{{ asset('plugins/js/jquery-slimscroll/jquery.slimscroll.js')}}"></script>

  <!-- slimscroll js -->
  <script src="{{ asset('plugins/js/jquery.mCustomScrollbar.concat.min.js')}} "></script>

  <!-- menu js -->
  <script src="{{ asset('plugins/js/pcoded.min.js')}}"></script>
  <script src="{{ asset('plugins/js/vertical/vertical-layout.min.js')}} "></script>

  <script type="text/javascript" src="{{ asset('plugins/js/script.js')}} "></script>


  <script>
    $(function() {
      $(".notifi-message").fadeTo(20000, 0);
    });
  </script>


</body>

</html>