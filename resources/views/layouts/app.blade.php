<!DOCTYPE html>
<html>
<head>
    <title>Pet Adoption Center</title>
    <link rel="stylesheet" href="/css/style.css">
    <!-- Bootstrap for Dropdown -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Login Button with Dropdown -->
    <div class="auth-corner">
        @auth
            <div class="dropdown" style="display: inline-block;">
                <button class="auth-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-user me-2"></i>{{ Auth::user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                    <li><a class="dropdown-item" href="{{ route('wishlist') }}"><i class="fas fa-heart me-2"></i>My Wishlist</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <a href="{{ route('login') }}" class="auth-btn">
                <i class="fas fa-paw me-2"></i>Sign In / Register
            </a>
        @endauth
    </div>

    <!-- Main Content -->
    <main style="padding-top: 80px;">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer style="
        background: #4CAF50;
        color: white;
        text-align: center;
        padding: 20px;
        margin-top: 50px;
    ">
        © 2024 Pet Adoption Center | Find your forever friend
    </footer>
</body>
</html>