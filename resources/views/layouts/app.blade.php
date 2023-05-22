<!DOCTYPE html>
<html lang="en">

<head>
    <title>Investment System </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="keywords" content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
    <meta name="author" content="Codedthemes" />

    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
    <!-- waves.css -->
    <link rel="stylesheet" href="{{ asset('plugins/pages/waves/css/waves.min.css')}}" type="text/css" media="all">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/css/bootstrap/css/bootstrap.min.css')}}">
    <!-- waves.css -->
    <link rel="stylesheet" href="{{ asset('plugins/pages/waves/css/waves.min.css')}}" type="text/css" media="all">
    <!-- themify icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/icon/themify-icons/themify-icons.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/icon/icofont/css/icofont.css')}}">
    <!-- font-awesome-n -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/css/font-awesome-n.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/css/font-awesome.min.css')}}">
    <!-- scrollbar.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/css/jquery.mCustomScrollbar.css')}}">
    <link href="{{ asset('plugins/other/datatables/autoFill.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{ asset('plugins/other/datatables/buttons.dataTables.css')}}" rel="stylesheet">
    <link href="{{ asset('plugins/other/datatables/jquery.dataTables.css')}}" rel="stylesheet">
    <link href="{{ asset('plugins/other/jquery-ui-datepicker/jquery-ui.css')}}" rel="stylesheet" />
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/css/style.css')}}">
    <script>
        window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]);  ?>
    </script>
    @stack('moreCss')
</head>

<body>
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
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">
                    <div class="navbar-logo">
                        <a class="mobile-menu waves-effect waves-light" id="mobile-collapse" href="#!">
                            <i class="ti-menu"></i>
                        </a>
                        <div class="mobile-search waves-effect waves-light">
                            <div class="header-search">
                                <div class="main-search morphsearch-search">
                                    <div class="input-group">
                                        <span class="input-group-prepend search-close"><i class="ti-close input-group-text"></i></span>
                                        <input type="text" class="form-control" placeholder="Enter Keyword">
                                        <span class="input-group-append search-btn"><i class="ti-search input-group-text"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="http://0.0.0.0:3001/public">
                            <img class="img-fluid" src="{{ asset('plugins/images/sys/logo.png')}}" alt="Theme-Logo" />
                        </a>
                        <a class="mobile-options waves-effect waves-light">
                            <i class="ti-more"></i>
                        </a>
                    </div>
                    <div class="navbar-container container-fluid">
                        <ul class="nav-left">
                            <li>
                                <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                            </li>
                            <li>
                                <a  onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
                                    <i class="ti-fullscreen"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav-right">
                            <li class="user-profile header-notification">

                                <a  class="waves-effect waves-light">
                                <?php
                                    if (Auth::user()->is_admin == 2) {
                                        $gender = Auth::user()->gender;
                                        if ($gender == 1) { // female?>
                                            <img src="{{ asset('plugins/images/fm.jpg')}}" class="img-radius" alt="User-Profile-Image">
                                        <?php } else if ($gender == 2) { //male ?>
                                            <img src="{{ asset('plugins/images/male.jpg')}}" class="img-radius" alt="User-Profile-Image">
                                        <?php  } else { ?>
                                            <img src="{{ asset('plugins/images/male.jpg')}}" class="img-radius" alt="User-Profile-Image">
                                        <?php  } ?>
                                    <?php  } else { ?>
                                        <img src="{{ asset('plugins/images/male.jpg')}}" class="img-radius" alt="User-Profile-Image">
                                    <?php  }
                                    ?>
                                   
                                    <span>
                                        <?php $login = "Admin";
                                        if (Auth::user()->first_name) {
                                            $login = Auth::user()->first_name;
                                        }
                                        echo $login;
                                        ?>
                                    </span>
                                    <i class="ti-angle-down"></i>
                                </a>
                                <ul class="show-notification profile-notification">
                                    <li class="waves-effect waves-light">
                                        <a href="{{ url('logout') }}">
                                            <i class="ti-layout-sidebar-left"></i> Logout
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                </div>
            </nav>

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    @include('layouts.sidebar')
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
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


    <script src="{{ asset('plugins/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('plugins/js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('plugins/other/jquery-ui-datepicker/jquery-ui.js') }}"></script>
    <script src="{{ asset('plugins/other/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/other/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('plugins/other/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugins/other/datatables/dataTables.autoFill.js') }}"></script>
    <script src="{{ asset('plugins/other/datatables/dataTables.buttons.js') }}"></script>


    <script>
        var today = "<?php echo date('m/d/Y') ?>";
        $('#mdob').datepicker({
            uiLibrary: 'bootstrap4',
            dateFormat: 'yy-mm-dd', //1986-11-25
            maxDate: 0
        });

        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        $(document).ready(function() {
            $('[data-toggle="popover"]').popover({
                html: true,
                content: function() {
                    return $('#primary-popover-content').html();
                }
            });
        });
    </script>

    <script>
        $(function() {
            $(".notifi-message").fadeTo(20000, 0);
        });
    </script>
    @stack('moreJs')
    @include('layouts.alert')
</body>

</html>