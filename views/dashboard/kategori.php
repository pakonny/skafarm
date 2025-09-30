<?php require_once(__DIR__ . "/../components/dashboard/head.php"); ?>
<?php require_once(__DIR__ . "/../components/dashboard/sidebar.php"); ?>
<div class="main-content" id="mainContent">
  <?php require_once(__DIR__ . "/../components/dashboard/header.php"); ?>

  <div class="table-section pt-5">
    <div class="table-card">
      <div class="table-header">
        <h5><i class="bi bi-tags-fill me-2"></i>Kategori Produk</h5>
        <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#categoryModal">
          <i class="bi bi-plus me-2"></i>Tambah Kategori
        </button>
      </div>

      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Kode</th>
              <th>Gambar</th>
              <th>Nama Kategori</th>
              <th>Jumlah Produk</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($data && mysqli_num_rows($data) > 0): ?>
              <?php while ($row = mysqli_fetch_assoc($data)): ?>
                <tr>
                  <td><?= $row['kode_kategori'] ?></td>
                  <td>
                    <?php if (!empty($row['img'])): ?>
                      <img src="uploads/<?= $row['img'] ?>" alt="kategori" style="max-width:60px; border:1px solid #ddd; border-radius:4px;">
                    <?php endif; ?>
                  </td>
                  <td><?= $row['nama_kategori'] ?></td>
                  <td><?= $row['total_produk'] ?> produk</td>
                  <td>
                    <button class="action-btn btn-edit"
                      data-bs-toggle="modal"
                      data-bs-target="#categoryModal"
                      data-id="<?= $row['kode_kategori'] ?>"
                      data-nama="<?= $row['nama_kategori'] ?>">
                      <i class="bi bi-pencil-square"></i>
                    </button>
                    <button class="action-btn btn-delete"
                      data-bs-toggle="modal"
                      data-bs-target="#confirmModal"
                      data-id="<?= $row['kode_kategori'] ?>"
                      data-img="<?= $row['img'] ?>">
                      <i class="bi bi-trash"></i>
                    </button>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center">Belum ada data kategori</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="categoryModal" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <form method="POST" action="index.php?controller=kategori&action=store" id="categoryForm" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">
            <i class="bi bi-tags-fill me-2"></i>
            <span id="categoryModalTitle">Tambah Kategori Baru</span>
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="kode_kategori" id="kode_kategori">
          <div class="form-group mb-3">
            <label class="form-label">Nama Kategori</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-tag-fill"></i></span>
              <input type="text" class="form-control" name="nama_kategori" id="nama_kategori" required>
            </div>
          </div>
          <div class="form-group mb-3">
            <label class="form-label">Upload Gambar Kategori</label>
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
        <div class="alert-icon warning">
          <i class="bi bi-exclamation-triangle-fill"></i>
        </div>
        <div class="alert-content">
          <div class="alert-title" id="confirmTitle">Konfirmasi Hapus</div>
          <div class="alert-message" id="confirmMessage">
            Apakah Anda yakin ingin menghapus item ini? Tindakan ini tidak dapat dibatalkan.
          </div>
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

    // --- Delete ---
    document.querySelectorAll(".btn-delete").forEach(btn => {
      btn.addEventListener("click", function() {
        deleteId = this.getAttribute("data-id");
      });
    });

    document.getElementById("confirmDeleteBtn").addEventListener("click", function() {
      if (deleteId) {
        window.location.href = "index.php?controller=kategori&action=delete&id=" + deleteId;
      }
    });

    // --- Edit ---
    document.querySelectorAll(".btn-edit").forEach(btn => {
      btn.addEventListener("click", function() {
        const id = this.getAttribute("data-id");
        const nama = this.getAttribute("data-nama");
        const imgFile = this.getAttribute("data-img");

        document.getElementById("kode_kategori").value = id;
        document.getElementById("nama_kategori").value = nama;

        if (imgFile) {
          document.getElementById("preview").src = "uploads/" + imgFile;
          document.getElementById("uploadBox").style.display = "none";
          document.getElementById("previewBox").style.display = "block";
        } else {
          resetImage();
        }

        document.getElementById("categoryForm").action = "index.php?controller=kategori&action=update";
        document.getElementById("categoryModalTitle").textContent = "Edit Kategori";
      });
    });

    // --- Tambah Baru ---
    document.querySelector("[data-bs-target='#categoryModal']").addEventListener("click", function() {
      document.getElementById("categoryForm").action = "index.php?controller=kategori&action=store";
      document.getElementById("categoryForm").reset();
      resetImage();
      document.getElementById("categoryModalTitle").textContent = "Tambah Kategori Baru";
    });

    // --- Event Change untuk input file ---
    document.getElementById("img").addEventListener("change", previewImage);
  });
</script>