<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>| Admin Board of StepViet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="Coderthemes" name="author">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">

    <!-- Plugin CSS -->
    <link href="{{ asset('libs/jquery-vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css">

    <!-- App CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet" type="text/css">


</head>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <div class="navbar-custom">
            <ul class="list-unstyled topnav-menu float-right mb-0">

                <li class="d-none d-sm-block">
                    <form class="app-search">
                        <div class="app-search-box">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search...">
                                <div class="input-group-append">
                                    <button class="btn" type="submit">
                                        <i class="fe-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </li>

                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle waves-light waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="fe-bell noti-icon"></i>
                        <span class="badge badge-danger rounded-circle noti-icon-badge">0</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                        <!-- item-->
                        <div class="dropdown-item noti-title">
                            <h5 class="m-0 text-white">
                                <span class="float-right">
                                    <a href="" class="text-white">
                                        <small>Clear All</small>
                                    </a>
                                </span>Notification
                            </h5>
                        </div>



                    </div>
                </li>

                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="{{ asset('images/users/user-1.jpg') }}" alt="user-image" class="rounded-circle">
                        <span class="pro-user-name ml-1">
                            Marcia J. <i class="mdi mdi-chevron-down"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <!-- item-->
                        <div class="dropdown-item noti-title">
                            <h5 class="m-0 text-white">
                                Welcome !
                            </h5>
                        </div>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="fe-user"></i>
                            <span>My Account</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="fe-settings"></i>
                            <span>Settings</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="fe-lock"></i>
                            <span>Lock Screen</span>
                        </a>

                        <div class="dropdown-divider"></div>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="fe-log-out"></i>
                            <span>Logout</span>
                        </a>

                    </div>
                </li>

                <li class="dropdown notification-list">
                    <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect waves-light">
                        <i class="fe-settings noti-icon"></i>
                    </a>
                </li>


            </ul>

            <div class="logo-box">
                <a href="index.html" class="logo text-center">
                    <span class="logo-lg">
                        <img src="{{ asset('images/logo-light.png') }}" alt="" height="24">
                        <!-- <span class="logo-lg-text-light">Upvex</span> -->
                    </span>
                    <span class="logo-sm">
                        <!-- <span class="logo-sm-text-dark">X</span> -->
                        <img src="{{ asset('images/logo-sm.png') }}" alt="" height="28">
                    </span>
                </a>
            </div>

            <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                <li>
                    <button class="button-menu-mobile waves-effect waves-light">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </li>
            </ul>
        </div>


        <div class="left-side-menu">

            <div class="slimscroll-menu">

                <!--- Sidemenu -->
                <div id="sidebar-menu">

                    <ul class="metismenu" id="side-menu">

                        <li class="menu-title">Navigation</li>

                        <li>
                            <a href="{{ route('admin') }}">
                                <i class="la la-dashboard"></i>
                                <span> Dashboard </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('users') }}">
                                <i class="icon-people"></i>
                                <span> Người dùng </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('products') }}">
                                <i class="icon-heart"></i>
                                <span> Sản phẩm </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('categories') }}">
                                <i class="la la-diamond"></i>
                                <span> Danh mục </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('brands') }}">
                                <i class="fe-zap"></i>
                                <span> Thương hiệu </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('email-inbox.htm') }}">
                                <i class="icon-basket-loaded"></i>
                                <span> Đơn hàng </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('email-inbox.htm') }}">
                                <i class="fe-tag"></i>
                                <span> Khuyến mãi </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('email-inbox.htm') }}">
                                <i class="icon-speech"></i>
                                <span> Bình luận </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('email-inbox.htm') }}">
                                <i class="icon-star"></i>
                                <span> Đánh giá </span>
                            </a>
                        </li>
                    </ul>

                </div>
                <!-- End Sidebar -->

                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>

        <header>
            <h1>@yield('title')</h1>
        </header>
        <div class="content-page">
            @yield('content')
        </div>

    </div>
    <!-- END wrapper -->

    <!-- Right Sidebar -->
    <div class="right-bar">
        <div class="rightbar-title">
            <a href="javascript:void(0);" class="right-bar-toggle float-right">
                <i class="mdi mdi-close"></i>
            </a>
            <h5 class="m-0 text-white">Settings</h5>
        </div>
        <div class="slimscroll-menu">
            <!-- User box -->
            <div class="user-box">
                <div class="user-img">
                    <img src="{{ asset('images/users/user-1.jpg') }}" alt="user-img" title="Mat Helme" class="rounded-circle img-fluid">
                    <a href="javascript:void(0);" class="user-edit"><i class="mdi mdi-pencil"></i></a>
                </div>

                <h5><a href="javascript: void(0);">Marcia J. Melia</a> </h5>
                <p class="text-muted mb-0"><small>Product Owner</small></p>
            </div>

            <!-- Settings -->
            <hr class="mt-0">
            <div class="row">
                <div class="col-6 text-center">
                    <h4 class="mb-1 mt-0">8,504</h4>
                    <p class="m-0">Balance</p>
                </div>
                <div class="col-6 text-center">
                    <h4 class="mb-1 mt-0">8,504</h4>
                    <p class="m-0">Balance</p>
                </div>
            </div>
            <hr class="mb-0">

            <div class="p-3">
                <div class="custom-control custom-switch mb-2">
                    <input type="checkbox" class="custom-control-input" id="customSwitch1" checked="">
                    <label class="custom-control-label" for="customSwitch1">Notifications</label>
                </div>
                <div class="custom-control custom-switch mb-2">
                    <input type="checkbox" class="custom-control-input" id="customSwitch2">
                    <label class="custom-control-label" for="customSwitch2">API Access</label>
                </div>
                <div class="custom-control custom-switch mb-2">
                    <input type="checkbox" class="custom-control-input" id="customSwitch3" checked="">
                    <label class="custom-control-label" for="customSwitch3">Auto Updates</label>
                </div>
                <div class="custom-control custom-switch mb-2">
                    <input type="checkbox" class="custom-control-input" id="customSwitch4" checked="">
                    <label class="custom-control-label" for="customSwitch4">Online Status</label>
                </div>
            </div>

            <!-- Timeline -->
            <hr class="mt-0">
            <h5 class="pl-3 pr-3">Messages <span class="float-right badge badge-pill badge-danger">0</span></h5>
            <hr class="mb-0">
            <div class="p-3">
                <div class="inbox-widget">
                    <div class="inbox-item">
                        <div class="inbox-item-img">
                            <img src="{{ asset('images/users/user-2.jpg') }}" class="rounded-circle" alt="">
                        </div>
                        <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Tomaslau</a></p>
                        <p class="inbox-item-text">I've finished it! See you so...</p>
                    </div>
                    <div class="inbox-item">
                        <div class="inbox-item-img">
                            <img src="{{ asset('images/users/user-6.jpg') }}" class="rounded-circle" alt="">
                        </div>
                        <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Adhamdannaway</a></p>
                        <p class="inbox-item-text">This theme is awesome!</p>
                    </div>
                </div> <!-- end inbox-widget -->

            </div> <!-- end .p-3-->

        </div> <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- Vendor js -->
    <script src="{{ asset('js/vendor.min.js') }}"></script>

    <!-- Third Party js-->
    <script src="{{ asset('libs/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('libs/jquery-vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('libs/jquery-vectormap/jquery-jvectormap-us-merc-en.js') }}"></script>

    <!-- Dashboard init -->
    <script src="{{ asset('js/pages/dashboard-1.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('js/app.min.js') }}"></script>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>