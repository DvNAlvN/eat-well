<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Admin')</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navigation.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    @yield('css')
</head>

<body class="d-flex flex-column min-vh-100">

    {{-- ===== NAVIGATION BAR ===== --}}
    <nav class="navbar navbar-expand-md custNavigation">
        <div class="h-100 w-100 invisible position-absolute bg-black opacity-50 z-3 nav-visibility"></div>
        <div class="container-fluid">
            <a class="navbar-brand me-auto" href="/admin-dashboard">
                <img src="/asset/navigation/eatwellLogo.png" alt="logo" style="width: 6vh;">
            </a>

            <div class="dropdown-wrapper">
                <select id="languageSelector" style="text-align: center; margin-left: 30px">
                    <option value="en">EN</option>
                    <option value="id">ID</option>
                </select>
            </div>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <img class="offcanvas-title" id="offcanvasNavbarLabel" src="/asset/navigation/eatwellLogo.png"
                        alt="logo" style="width: 10vh;">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav pe-3">
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 navigationcustlink {{ Request::is('admin-dashboard') ? 'active' : '' }}"
                                href="/admin-dashboard">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 navigationcustlink {{ Request::is('view-all-orders') ? 'active' : '' }}"
                                href="/view-all-orders">Transactions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 navigationcustlink {{ Request::is('categories.show') ? 'active' : '' }}"
                                href="{{route('categories.show')}}">Packages Category</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 navigationcustlink {{ Request::is('view-all-packages-cuisine') ? 'active' : '' }}"
                                href="/view-all-packages-cuisine">Packages Cuisine</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 navigationcustlink {{ Request::is('view-all-vendors') ? 'active' : '' }}"
                                href="/view-all-vendors">Vendors</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 navigationcustlink {{ Request::is('view-all-users') ? 'active' : '' }}"
                                href="/view-all-users">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-lg-2 navigationcustlink {{ Request::is('view-all-logs') ? 'active' : '' }}"
                                href="/view-all-logs">Logs</a>
                        </li>
                    </ul>
                </div>
            </div>

            @auth
                {{-- <div style="padding: 0.5rem 1rem; border-radius: 0.25rem; margin-right: 2vw">
                    <a class="login-button p-0" href="profile">
                        <button type="button" class="login_button">
                            <i class="bi bi-gear-fill"></i> Profile
                        </button>
                    </a>
                </div> --}}
                <a href="/manage-profile">
                    <div class="imgstyle m-2" style="border-radius:100%; width:50px; height:50px margin-right:20px">
                        <img class="img-fluid" src="{{ asset('asset/catering/homepage/breakfastPreview.jpg') }}"
                            alt="Card image " width="120px" style="border-radius: 100%">
                    </div>
                </a>
            @else
                <div style="padding: 0.5rem 1rem; border-radius: 0.25rem; margin-right: 2vw">
                    <a class="login-button p-0" href="login">
                        <button type="button" class="login_button">Log In</button>
                    </a>
                </div>
            @endauth

            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        </div>
    </nav>

    {{-- ===== PAGE CONTENT ===== --}}
    <main class="flex-grow-1">
        @yield('content')
    </main>

    {{-- ===== FOOTER ===== --}}
    {{-- <footer class="bg-dark text-white py-0 mt-auto">
        <div class="container text-center footer-page d-flex flex-column align-items-center py-4"
            style="margin-top: 10px">

            <!-- Logo + Title -->
            <div class="mb-2 text-center justify-content-center">
                <h5 class="mt-2 fw-semibold mb-0">EAT WELL</h5>
                <img src="{{ asset('asset/navigation/eatwellLogo.png') }}" alt="logo" style="width: 7vh;">
            </div>

            <!-- Navigation Links -->
            <div class="footer-links d-flex justify-content-center mb-3">
                <a href="/home" class="text-white text-decoration-none">Home</a>
                <a href="/about-us" class="text-white text-decoration-none">About Us</a>
                <a href="/contact" class="text-white text-decoration-none">Contact</a>
            </div>

            <!-- Sosial Media -->
            <div class="d-flex justify-content-center gap-4 mb-2">
                <a href="#" class="text-white fs-4"><img src="{{ asset('asset/footer/1.png') }}" width="30px"></a>
                <a href="#" class="text-white fs-4"><img src="{{ asset('asset/footer/2.png') }}" width="30px"></a>
                <a href="#" class="text-white fs-4"><img src="{{ asset('asset/footer/3.png') }}" width="30px"></a>
            </div>

            <!-- Copyright -->
            <p class="text-white-50 mb-1 text-center">&copy; {{ date('Y') }} Eat Well. All rights reserved.</p>

            <!-- Address -->
            <p class="text-white-50 small text-center mb-0">
                Jl. Pakuan No.3, Sumur Batu, Kec. Babakan Madang, Kabupaten Bogor, Jawa Barat 16810
            </p>
        </div>
    </footer> --}}

    {{-- Scripts --}}
    @yield('scripts')
    <script src="{{ asset('js/navigation.js') }}"></script>

</body>

</html>
