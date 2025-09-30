<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$username = $_SESSION['username'] ?? '';
?>

<?php require_once(__DIR__ . "/../components/landingPage/head.php"); ?>
<?php require_once(__DIR__ . "/../components/landingPage/navbar.php"); ?>

<div class="container py-5 mb-5">
    <div class="row g-4">
        <div class="col-12 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="ratio ratio-4x3">
                    <img 
                        src="uploads/<?= htmlspecialchars($product['img'] ?: 'default.jpg') ?>" 
                        class="w-100 h-100 object-fit-cover rounded-3"
                        alt="<?= htmlspecialchars($product['nama_barang']) ?>">
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="card border-0 h-100">
                <div class="card-body d-flex flex-column">
                    <h3 class="fw-bold mb-3">
                        <i class="bi bi-box-seam text-success me-2"></i>
                        <?= htmlspecialchars($product['nama_barang']) ?>
                    </h3>

                    <p class="text-muted mb-3">
                        <i class="bi bi-cash-stack me-1 text-success"></i>
                        Stok: <?= htmlspecialchars($product['stok']) ?> |
                        <i class="bi bi-tag me-1 text-success"></i>
                        <span class="fw-semibold text-success"><?= htmlspecialchars($product['satuan']) ?></span>
                    </p>

                    <h4 class="fw-bold text-success mb-4">
                        <i class="bi bi-currency-dollar me-2"></i>
                        Rp <?= number_format($product['harga'], 0, ',', '.') ?>
                    </h4>

                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <?php if ($username): ?>
                            <form method="POST" action="index.php?controller=detailtransaksi&action=checkout" class="flex-grow-1">
                                <input type="hidden" name="kode_barang" value="<?= $product['kode_barang']; ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-bag me-1"></i> Beli
                                </button>
                            </form>
                            <a href="index.php?controller=cart&action=add&id=<?= $product['kode_barang'] ?>" class="btn btn-outline-success flex-grow-1">
                                <i class="bi bi-cart-plus me-1"></i> Tambah Keranjang
                            </a>
                        <?php else: ?>
                            <a href="index.php?controller=auth&action=showLogin" class="btn btn-success flex-grow-1">
                                <i class="bi bi-bag me-1"></i> Beli
                            </a>
                            <a href="index.php?controller=auth&action=showLogin" class="btn btn-outline-success flex-grow-1">
                                <i class="bi bi-cart-plus me-1"></i> Tambah Keranjang
                            </a>
                        <?php endif; ?>
                    </div>

                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-info-circle text-success me-2"></i> Detail Produk
                    </h5>
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item px-0">
                            <i class="bi bi-grid-fill text-success me-2"></i>
                            <strong>Kategori:</strong> <?= htmlspecialchars($product['nama_kategori'] ?? '-') ?>
                        </li>
                        <li class="list-group-item px-0">
                            <i class="bi bi-tag-fill text-success me-2"></i>
                            <strong>Satuan:</strong> <?= htmlspecialchars($product['satuan']) ?>
                        </li>
                        <li class="list-group-item px-0">
                            <i class="bi bi-building text-success me-2"></i>
                            <strong>Gudang:</strong> <?= htmlspecialchars($product['kode_gudang']) ?>
                        </li>
                    </ul>

                    <p class="text-secondary mb-0">
                        <i class="bi bi-file-text me-2 text-success"></i>
                        <?= nl2br(htmlspecialchars($product['deskripsi'])) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once(__DIR__ . "/../components/landingPage/footer.php"); ?>
