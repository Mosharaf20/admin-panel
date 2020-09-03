<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 3 | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper" id="app">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="index3.html" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Contact</a>
            </li>
        </ul>

        <!-- SEARCH FORM -->
        <form class="form-inline ml-3">
            <div class="input-group input-group-sm">
                <input @keyup="searchContent" v-model="keyword" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-bell h4 mr-2"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="width: 300px">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <notification-component :notify="{{$count}}"></notification-component>

                   {{-- @foreach(auth()->user()->notifications as $notify)
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> {{$notify->data['message'] }}
                            <span class="float-right text-muted text-sm">{{$notify->created_at->format('h:i A')}}</span>
                        </a>
                    @endforeach--}}

                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link" style="line-height: 20px;">
            <img src="{{asset('images/admin/profile.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light d-block">
                {{Auth::user()->name}}
            </span>
            <span class="text-success h6">Admin</span>
        </a>


        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item has-treeview menu-open">
                        <router-link to="/dashboard" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </router-link>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>
                                Management
                                <i class="fas fa-angle-left right"></i>
                                <span class="badge badge-info right">6</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link  to="/users" class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Users</p>
                                </router-link >
                            </li>
                        </ul>
                    </li>

                    @can('isAdmin')
                        <li class="nav-item">
                            <router-link to="/developer" class="nav-link">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>Developer </p>
                            </router-link>
                        </li>
                   @endcan

                    <li class="nav-item">
                        <router-link to="/profiles" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Profile </p>
                        </router-link>
                    </li>


                    <li class="nav-item">
                        <router-link to="/test" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Gallery </p>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link to="/form" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>From </p>
                        </router-link>
                    </li>


                    <li class="nav-item">
                        <a href="{{route('admin.logout')}}" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <div class="content-wrapper">
        <router-view></router-view>

        <!-- set progressbar -->
        <vue-progress-bar></vue-progress-bar>
    </div>

    <footer class="main-footer">
        <strong>Copyright &copy; 2020 <a href="http://adminpanel.io">admin-panel.com</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.0.5
        </div>
    </footer>

    <aside class="control-sidebar control-sidebar-dark">

    </aside>

</div>

@auth()
    <script>
        window.user =@json(auth()->user());
    </script>
@endauth

<script src="{{ asset('js/app.js') }}" defer></script>

</body>
</html>
