<nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow custom-navbar">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-white" href="/">Tokoku</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <!-- Hanya tampil jika admin login -->
                @auth
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : 'text-white' }}" href="/">Dashboard</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('kategori') || request()->is('produk') ? 'active' : 'text-white' }}" 
                        href="#" id="dataDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Data
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item {{ request()->is('kategori') ? 'dropdown-active' : '' }}" href="/kategori">Kategori</a></li>
                        <li><a class="dropdown-item {{ request()->is('produk') ? 'dropdown-active' : '' }}" href="/produk">Produk</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('transaksi') ? 'active' : 'text-white' }}" href="/transaksi">Transaksi</a>
                </li>
                @endauth

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('katalog') ? 'active' : 'text-white' }}" href="/katalog">Katalog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('keranjang') ? 'active' : 'text-white' }}" href="/keranjang">Keranjang</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                @auth
                <!-- Jika admin login -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="/profile">Profil</a></li>
                        <li><a class="dropdown-item" href="/settings">Pengaturan</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
                @else
                <!-- Jika belum login -->
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('admin.login') }}">Login</a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<style>
    /* Warna Hijau Tokopedia */
    .custom-navbar {
        background-color: #00AA5B;
        transition: all 0.3s ease-in-out;
    }

    /* Efek Transparan saat di Atas */
    .custom-navbar.transparent {
        background: rgba(0, 170, 91, 0.85);
        backdrop-filter: blur(5px);
    }

    /* Hover Efek untuk Dropdown */
    .dropdown-menu {
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .dropdown-item:hover {
        background-color: #008a4e;
        color: white;
    }

    /* Animasi saat scroll */
    .scrolled {
        background-color: #008a4e !important;
    }

    /* Warna untuk Menu Utama yang Sedang Aktif */
    .nav-link.active {
        font-weight: bold;
        color: #FFD700 !important; /* Kuning */
    }

    /* Warna untuk Item Dropdown yang Sedang Aktif */
    .dropdown-item.dropdown-active {
        font-weight: bold;
        color: #00AA5B !important; /* Hijau */
    }

    /* Link nonaktif tetap putih */
    .nav-link.text-white {
        color: white !important;
    }
</style>

<script>
    // Navbar Transparan Efek Scroll
    window.addEventListener("scroll", function () {
        var navbar = document.querySelector(".custom-navbar");
        if (window.scrollY > 50) {
            navbar.classList.add("scrolled");
        } else {
            navbar.classList.remove("scrolled");
        }
    });
</script>
