<?php require_once(__DIR__ . "/../components/dashboard/head.php"); ?>
<?php require_once(__DIR__ . "/../components/dashboard/sidebar.php"); ?>
<div class="main-content" id="mainContent">
  <?php require_once(__DIR__ . "/../components/dashboard/header.php"); ?>

  <div class="table-section pt-5">
    <div class="table-card">
      <div class="table-header d-flex justify-content-between align-items-center">
        <h5><i class="bi bi-flower3 me-2"></i>Daftar Produk</h5>
        <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#productModal">
          <i class="bi bi-plus me-2"></i>Tambah Produk
        </button>
      </div>

      <form method="GET" action="index.php" class="p-3 border rounded mb-3 bg-light">
        <input type="hidden" name="controller" value="produk">
        <input type="hidden" name="action" value="index">
        <div class="row g-2">
          <div class="col-md-3">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-search"></i></span>
              <input type="text" class="form-control" name="search" placeholder="Cari produk..."
                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            </div>
          </div>

          <div class="col-md-3">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-box"></i></span>
              <select name="satuan" class="form-control">
                <option value="">Semua Satuan</option>
                <option value="kg" <?= ($_GET['satuan'] ?? '') == 'kg' ? 'selected' : '' ?>>Kilogram</option>
                <option value="gram" <?= ($_GET['satuan'] ?? '') == 'gram' ? 'selected' : '' ?>>Gram</option>
                <option value="liter" <?= ($_GET['satuan'] ?? '') == 'liter' ? 'selected' : '' ?>>Liter</option>
                <option value="pcs" <?= ($_GET['satuan'] ?? '') == 'pcs' ? 'selected' : '' ?>>Pieces</option>
                <option value="pack" <?= ($_GET['satuan'] ?? '') == 'pack' ? 'selected' : '' ?>>Pack</option>
              </select>
            </div>
          </div>

          <div class="col-md-2">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-tags-fill"></i></span>
              <select name="kategori_id" class="form-control">
                <option value="">Semua Kategori</option>
                <?php foreach ($kategori as $kat): ?>
                  <option value="<?= $kat['kode_kategori'] ?>"
                    <?= ($_GET['kategori_id'] ?? '') == $kat['kode_kategori'] ? 'selected' : '' ?>>
                    <?= $kat['nama_kategori'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="col-md-2">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-building"></i></span>
              <select name="kode_gudang" class="form-control">
                <option value="">Semua Gudang</option>
                <?php foreach ($gudang as $gd): ?>
                  <option value="<?= $gd['kode_gudang'] ?>"
                    <?= ($_GET['kode_gudang'] ?? '') == $gd['kode_gudang'] ? 'selected' : '' ?>>
                    <?= $gd['nama_gudang'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="col-md-1">
            <button type="submit" class="btn btn-success w-100 form-control">
              <i class="bi bi-check-lg"></i>
            </button>
          </div>

          <div class="col-md-1">
            <a href="index.php?controller=produk&action=index" class="btn btn-secondary w-100 form-control">
              <i class="bi bi-arrow-repeat"></i>
            </a>
          </div>
        </div>
      </form>

      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Kode Produk</th>
              <th>Gambar</th>
              <th>Nama Produk</th>
              <th>Satuan</th>
              <th>Harga</th>
              <th>Stok</th>
              <th>Kategori</th>
              <th>Gudang</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($data && mysqli_num_rows($data) > 0): ?>
              <?php while ($row = mysqli_fetch_assoc($data)): ?>
                <tr>
                  <td><?= $row['kode_barang'] ?></td>
                  <td>
                    <?php if (!empty($row['img'])): ?>
                      <img src="uploads/<?= $row['img'] ?>" alt="Produk" style="max-width:60px; border:1px solid #ddd; border-radius:4px;">
                    <?php endif; ?>
                  </td>
                  <td><?= $row['nama_barang'] ?></td>
                  <td><?= $row['satuan'] ?></td>
                  <td><?= number_format($row['harga'], 0, ',', '.') ?></td>
                  <td><?= $row['stok'] ?></td>
                  <td><?= $row['nama_kategori'] ?></td>
                  <td><?= $row['nama_gudang'] ?></td>
                  <td>
                    <button class="action-btn btn-edit"
                      data-bs-toggle="modal"
                      data-bs-target="#productModal"
                      data-id="<?= $row['kode_barang'] ?>"
                      data-nama="<?= $row['nama_barang'] ?>"
                      data-satuan="<?= $row['satuan'] ?>"
                      data-harga="<?= $row['harga'] ?>"
                      data-stok="<?= $row['stok'] ?>"
                      data-kategori="<?= $row['kategori_id'] ?>"
                      data-gudang="<?= $row['kode_gudang'] ?>"
                      data-deskripsi="<?= $row['deskripsi'] ?>"
                      data-img="<?= $row['img'] ?>">
                      <i class="bi bi-pencil-square"></i>
                    </button>
                    <button class="action-btn btn-delete"
                      data-bs-toggle="modal"
                      data-bs-target="#confirmModal"
                      data-id="<?= $row['kode_barang'] ?>">
                      <i class="bi bi-trash"></i>
                    </button>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="9" class="text-center">Belum ada data produk</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="productModal" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST" action="index.php?controller=produk&action=store" id="productForm" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title"><i class="bi bi-flower3 me-2"></i><span id="productModalTitle">Tambah Produk Baru</span></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="kode_barang" id="kode_barang">

          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" class="form-control" name="nama_barang" id="nama_barang" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label class="form-label">Satuan</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-box"></i></span>
                  <select class="form-control" name="satuan" id="satuan" required>
                    <option value="">Pilih satuan...</option>
                    <option value="kg">Kilogram (kg)</option>
                    <option value="gram">Gram (g)</option>
                    <option value="liter">Liter (L)</option>
                    <option value="pcs">Pieces (pcs)</option>
                    <option value="pack">Pack</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="form-label">Harga</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-cash-stack"></i></span>
                  <input type="number" class="form-control" name="harga" id="harga" required>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="form-label">Stok</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
                  <input type="number" class="form-control" name="stok" id="stok" required>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="form-label">Kategori</label>
                <select class="form-control" name="kategori_id" id="kategori_id" required>
                  <option value="">Pilih kategori...</option>
                  <?php foreach ($kategori as $kat): ?>
                    <option value="<?= $kat['kode_kategori'] ?>"><?= $kat['nama_kategori'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group mb-3">
            <label class="form-label">Gudang</label>
            <select class="form-control" name="kode_gudang" id="kode_gudang" required>
              <option value="">Pilih gudang...</option>
              <?php foreach ($gudang as $gd): ?>
                <option value="<?= $gd['kode_gudang'] ?>"><?= $gd['nama_gudang'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group mb-3">
            <label class="form-label">Upload Gambar Produk</label>
            <div class="file-upload" id="uploadBox" onclick="document.getElementById('img').click()">
              <i class="bi bi-cloud-arrow-up"></i>
              <h6>Drag & Drop atau Klik untuk Upload</h6>
              <p class="text-muted">Format: JPG, PNG, maksimal 2MB</p>
              <input type="file" class="form-control" name="img" id="img" accept="image/*" style="display:none">
            </div>
            <div class="text-center" id="previewBox" style="display:none">
              <img id="preview" src="" alt="Preview" style="max-width:180px; border:1px solid #ddd; padding:4px; border-radius:6px;">
              <div class="mt-2">
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="resetImage()">Hapus Gambar</button>
              </div>
            </div>
          </div>

          <div class="form-group mb-3">
            <label class="form-label">Deskripsi Produk</label>
            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success"><i class="bi bi-save me-2"></i>Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade custom-alert-modal" id="confirmModal" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <div class="alert-icon warning"><i class="bi bi-exclamation-triangle-fill"></i></div>
        <div class="alert-content">
          <div class="alert-title">Konfirmasi Hapus</div>
          <div class="alert-message">Apakah Anda yakin ingin menghapus produk ini?</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
      </div>
    </div>
  </div>
</div>

<?php require_once(__DIR__ . "/../components/dashboard/modal.php"); ?>
<?php require_once(__DIR__ . "/../components/dashboard/footer.php"); ?>

<script>
  function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
      document.getElementById("preview").src = URL.createObjectURL(file);
      document.getElementById("uploadBox").style.display = "none";
      document.getElementById("previewBox").style.display = "block";
    }
  }

  function resetImage() {
    document.getElementById("img").value = "";
    document.getElementById("preview").src = "";
    document.getElementById("previewBox").style.display = "none";
    document.getElementById("uploadBox").style.display = "block";
  }

  document.addEventListener("DOMContentLoaded", function() {
    let deleteId = null;
    document.querySelectorAll(".btn-delete").forEach(btn => {
      btn.addEventListener("click", function() {
        deleteId = this.getAttribute("data-id");
      });
    });
    document.getElementById("confirmDeleteBtn").addEventListener("click", function() {
      if (deleteId) {
        window.location.href = "index.php?controller=produk&action=delete&id=" + deleteId;
      }
    });

    document.querySelectorAll(".btn-edit").forEach(btn => {
      btn.addEventListener("click", function() {
        document.getElementById("kode_barang").value = this.getAttribute("data-id");
        document.getElementById("nama_barang").value = this.getAttribute("data-nama");
        document.getElementById("satuan").value = this.getAttribute("data-satuan");
        document.getElementById("harga").value = this.getAttribute("data-harga");
        document.getElementById("stok").value = this.getAttribute("data-stok");
        document.getElementById("kategori_id").value = this.getAttribute("data-kategori");
        document.getElementById("kode_gudang").value = this.getAttribute("data-gudang");
        document.getElementById("deskripsi").value = this.getAttribute("data-deskripsi");

        const imgFile = this.getAttribute("data-img");
        if (imgFile) {
          document.getElementById("preview").src = "uploads/" + imgFile;
          document.getElementById("uploadBox").style.display = "none";
          document.getElementById("previewBox").style.display = "block";
        } else {
          resetImage();
        }

        document.getElementById("productForm").action = "index.php?controller=produk&action=update";
        document.getElementById("productModalTitle").textContent = "Edit Produk";
      });
    });

    document.querySelector("[data-bs-target='#productModal']").addEventListener("click", function() {
      document.getElementById("productForm").action = "index.php?controller=produk&action=store";
      document.getElementById("productForm").reset();
      resetImage();
      document.getElementById("productModalTitle").textContent = "Tambah Produk Baru";
    });

    document.getElementById("img").addEventListener("change", previewImage);
  });
</script>