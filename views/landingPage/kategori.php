<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CheapMarketDeal - My Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/profil.css">
</head>

<body>
    <nav class="navbar shadow-sm bg-body-tertiary border-bottom sticky-top z-3 border">
        <div class="container d-flex justify-content-between align-items-center px-2 px-md-3 px-lg-5 position-relative">

            <!-- Tombol Arrow Kembali (ganti hamburger) - tampil di semua ukuran -->
            <a class="btn d-block position-relative z-1" href="index.php?controller=beranda&action=index" aria-label="Back">
                <i class="bi bi-arrow-left fs-4" style="color: #28a745;"></i>
            </a>

            <!-- Teks Skafarm di Tengah -->
            <div class="position-absolute start-50 translate-middle-x text-center">
                <a class="navbar-brand fw-bold fs-3 mb-0" href="index.php?controller=beranda&action=index" style="color: #28a745;">Skafarm</a>
            </div>

        </div>
    </nav>


    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <!-- Sidebar -->
            <!-- Sidebar -->
            <div class="col-md-3 mb-3">

                <!-- Sidebar for desktop (md up) -->
                <div class="sidebar d-none d-md-block">
                    <div class="nav flex-column">
                        <a class="nav-link active" href="#"><i class="bi bi-bag"></i> Carts</a>
                        <a class="nav-link" href="#"><i class="fas fa-box"></i> History Orders</a>
                        <a class="nav-link" href="#"><i class="fas fa-heart"></i> Wishlist</a>
                        <a class="nav-link" href="#"><i class="fas fa-heart"></i> Blog</a>
                        <a class="nav-link logout-link" href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>

                <!-- Sidebar as dropdown (visible only on small devices) -->
                <div class="d-md-none">
                    <button class="btn btn-outline-success w-100 mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#mobileSidebar" aria-expanded="false" aria-controls="mobileSidebar">
                        ☰ Menu
                    </button>

                    <div class="collapse" id="mobileSidebar">
                        <div class="card card-body p-2">
                            <a class="nav-link active" href="#"><i class="bi bi-bag"></i> Carts</a>
                            <a class="nav-link" href="#"><i style="color: #6c757d;" class="fas fa-box"></i> History Orders</a>
                            <a class="nav-link" href="#"><i style="color: #6c757d;" class="fas fa-heart"></i> Wishlist</a>
                            <a class="nav-link" href="#"><i style="color: #6c757d;" class="fas fa-heart"></i> Blog</a>
                            <a class="nav-link logout-link" href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
                    </div>
                </div>

            </div>


            <!-- Main Content Area -->
            <div class="col-md-9">
                <div class="main-content">

                    <!-- Search Order -->
                    <div class="search-order px-3 px-md-4 py-3">
                        <div class="position-relative">
                            <i class="fas fa-search position-absolute" style="left: 15px; top: 50%; transform: translateY(-50%); color: #6c757d;"></i>
                            <input type="text" class="form-control ps-5" placeholder="Tracking No / Order ID / Item name">
                        </div>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content pb-5 mb-5 px-2 px-md-4" id="orderTabContent">
                        <!-- All Orders Tab -->
                        <div class="tab-pane fade show active" id="all-orders" role="tabpanel">

                            <!-- Order Card -->
                            <div class="order-card p-3 p-md-4 rounded-3 shadow-sm bg-white mb-4">

                                <!-- Header -->
                                <div class="d-flex justify-content-between flex-wrap mb-3">
                                    <span class="order-status shipped">History</span>
                                    <div class="order-actions">
                                    </div>
                                </div>

                                <!-- Order Body -->
                                <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">

                                    <!-- Gambar Produk -->
                                    <div class="order-items text-center">
                                        <img
                                            src="https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=150&h=150&fit=crop"
                                            alt="Kelapa"
                                            class="rounded-3 img-fluid"
                                            style="max-width: 100px;">
                                    </div>

                                    <!-- Detail Produk -->
                                    <div class="order-details w-100 d-flex flex-md-row flex-column justify-content-between align-items-start gap-2">

                                        <!-- Info Produk -->
                                        <div>
                                            <h6 class="mb-1 fw-bold">Kelapa Muda</h6>
                                            <p class="mb-1 text-success fw-semibold">Rp 10.000.000</p>
                                            <p class="mb-2 text-muted" style="font-size: 0.9rem;">
                                                <strong>Kategori:</strong> Buah
                                            </p>
                                        </div>

                                        <!-- Kuantitas -->
                                        <div>
                                            <div class="input-group input-group-sm" style="max-width: 100px;">
                                                <button class="btn btn-outline-success btn-decrease" type="button">-</button>
                                                <input type="text" class="form-control text-center quantity-input" value="1" readonly>
                                                <button class="btn btn-outline-success btn-increase" type="button">+</button>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                            </div>
                            <div class="order-card p-3 p-md-4 rounded-3 shadow-sm bg-white mb-4">

                                <!-- Header -->
                                <div class="d-flex justify-content-between flex-wrap mb-3">
                                    <span class="order-status shipped">History</span>
                                    <div class="order-actions">
                                    </div>
                                </div>

                                <!-- Order Body -->
                                <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">

                                    <!-- Gambar Produk -->
                                    <div class="order-items text-center">
                                        <img
                                            src="https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=150&h=150&fit=crop"
                                            alt="Kelapa"
                                            class="rounded-3 img-fluid"
                                            style="max-width: 100px;">
                                    </div>

                                    <!-- Detail Produk -->
                                    <div class="order-details w-100 d-flex flex-md-row flex-column justify-content-between align-items-start gap-2">

                                        <!-- Info Produk -->
                                        <div>
                                            <h6 class="mb-1 fw-bold">Kelapa Muda</h6>
                                            <p class="mb-1 text-success fw-semibold">Rp 10.000.000</p>
                                            <p class="mb-2 text-muted" style="font-size: 0.9rem;">
                                                <strong>Kategori:</strong> Buah
                                            </p>
                                        </div>

                                        <!-- Kuantitas -->
                                        <div>
                                            <div class="input-group input-group-sm" style="max-width: 100px;">
                                                <button class="btn btn-outline-success btn-decrease" type="button">-</button>
                                                <input type="text" class="form-control text-center quantity-input" value="1" readonly>
                                                <button class="btn btn-outline-success btn-increase" type="button">+</button>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                            </div>
                            <div class="order-card p-3 p-md-4 rounded-3 shadow-sm bg-white mb-4">

                                <!-- Header -->
                                <div class="d-flex justify-content-between flex-wrap mb-3">
                                    <span class="order-status shipped">History</span>
                                    <div class="order-actions">
                                    </div>
                                </div>

                                <!-- Order Body -->
                                <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">

                                    <!-- Gambar Produk -->
                                    <div class="order-items text-center">
                                        <img
                                            src="https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=150&h=150&fit=crop"
                                            alt="Kelapa"
                                            class="rounded-3 img-fluid"
                                            style="max-width: 100px;">
                                    </div>

                                    <!-- Detail Produk -->
                                    <div class="order-details w-100 d-flex flex-md-row flex-column justify-content-between align-items-start gap-2">

                                        <!-- Info Produk -->
                                        <div>
                                            <h6 class="mb-1 fw-bold">Kelapa Muda</h6>
                                            <p class="mb-1 text-success fw-semibold">Rp 10.000.000</p>
                                            <p class="mb-2 text-muted" style="font-size: 0.9rem;">
                                                <strong>Kategori:</strong> Buah
                                            </p>
                                        </div>

                                        <!-- Kuantitas -->
                                        <div>
                                            <div class="input-group input-group-sm" style="max-width: 100px;">
                                                <button class="btn btn-outline-success btn-decrease" type="button">-</button>
                                                <input type="text" class="form-control text-center quantity-input" value="1" readonly>
                                                <button class="btn btn-outline-success btn-increase" type="button">+</button>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>



                </div>
            </div>


            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script src="assets/profil.js"></script>

</body>

</html>