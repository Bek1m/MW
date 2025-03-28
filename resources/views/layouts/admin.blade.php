<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin - {{ config('app.name', 'Mosque Website') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="admin-app">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-3 col-lg-2 bg-dark text-white p-0 min-vh-100">
                    <div class="d-flex flex-column flex-shrink-0 p-3 bg-dark">
                        <a href="{{ route('home') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                            <span class="fs-4">Admin</span>
                        </a>
                        <hr>
                        <ul class="nav nav-pills flex-column mb-auto">
                            <li class="nav-item">
                                <a href="{{ route('admin.dashboard') }}" class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                    <i class="bi bi-speedometer2 me-2"></i>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('posts.index') }}" class="nav-link text-white">
                                    <i class="bi bi-file-earmark-text me-2"></i>
                                    Postimet
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.pending-posts') }}" class="nav-link text-white {{ request()->routeIs('admin.pending-posts') ? 'active' : '' }}">
                                    <i class="bi bi-hourglass-split me-2"></i>
                                    Postimet në pritje
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.users') }}" class="nav-link text-white {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                                    <i class="bi bi-people me-2"></i>
                                    Përdoruesit
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.categories') }}" class="nav-link text-white {{ request()->routeIs('admin.categories') ? 'active' : '' }}">
                                    <i class="bi bi-tags me-2"></i>
                                    Kategoritë
                                </a>
                            </li>
                        </ul>
                        <hr>
                        @auth
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-2"></i>
                                <strong>{{ Auth::user()->name }}</strong>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                                <li><a class="dropdown-item" href="{{ route('home') }}">Kthehu</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" 
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Dil
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                        @else
                        <div class="text-center">
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Kyçu
                            </a>
                        </div>
                        @endauth
                    </div>
                </div>

                <!-- Main content -->
                <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">@yield('title', 'Admin')</h1>
                    </div>
                    
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>
</html>