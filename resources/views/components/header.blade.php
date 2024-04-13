<!DOCTYPE html>
<html>

<head>

    <title>Stock Management System</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-theme.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- jQuery -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <!-- jQuery UI -->
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}">
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

</head>

<body>


    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- <a class="navbar-brand" href="#">Brand</a> -->
                <a class="navbar-brand" href="#" style="padding:0px;">
                    <img src="{{ asset('logo.png') }}" alt="">
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <ul class="nav navbar-nav navbar-right">

                    <li id="navDashboard"><a href="{{ url('/') }}"><i class="glyphicon glyphicon-list-alt"></i> Dashboard</a></li>
                    @if(session()->has('user') && session('user.role')=='admin')
                    <li id="navBrand"><a href="{{ url('/brand') }}"><i class="glyphicon glyphicon-btc"></i> Brand</a></li>
                    @endif
                    @if(session()->has('user') && session('user.role')=='admin')
                    <li id="navCategories"><a href="{{ url('/categories') }}"> <i class="glyphicon glyphicon-th-list"></i> Category</a></li>
                    @endif
                    @if(session()->has('user') && (session('user.role')=='staff' || session('user.role') == 'admin'))
                    <li id="navProduct"><a href="{{ url('/product') }}"> <i class="glyphicon glyphicon-ruble"></i> Product </a></li>
                    @endif

                    <li class="dropdown" id="navOrder">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="glyphicon glyphicon-shopping-cart"></i> Orders <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @if(session()->has('user') && (session('user.role')=='staff' || session('user.role') == 'admin'))
                            <li id="topNavAddOrder"><a href="{{ url('/orders?o=add') }}"> <i class="glyphicon glyphicon-plus"></i> Add Orders</a></li>
                            @endif
                            @if(session()->has('user') && session('user.role')=='admin')
                            <li id="topNavManageOrder"><a href="{{ url('/orders?o=manord') }}"> <i class="glyphicon glyphicon-edit"></i> Manage Orders</a></li>
                            @endif
                        </ul>
                    </li>

                    @if(session()->has('user') && session('user.role')=='auditor')
                    <li id="navReport"><a href="{{ url('/report') }}"> <i class="glyphicon glyphicon-check"></i> Report </a></li>
                    @endif
                    @if(session()->has('user') && session('user.role')=='admin')
                    <li id="importbrand"><a href="{{ url('/importbrand') }}"> <i class="glyphicon glyphicon-check"></i> Import Brand </a></li>
                    @endif
                    <li class="dropdown" id="navSetting">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="glyphicon glyphicon-user"></i> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li id="topNavSetting"><a href="{{ url('/setting') }}"> <i class="glyphicon glyphicon-wrench"></i> Setting</a></li>
                            @if(session()->has('user') && session('user.role')=='admin')
                            <li id="topNavUser"><a href="{{ url('/user') }}"> <i class="glyphicon glyphicon-wrench"></i> Add User</a></li>
                            @endif
                            <li id="topNavLogout"><a href="{{ url('/logout') }}"> <i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
                        </ul>
                    </li>

                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <div class="container">