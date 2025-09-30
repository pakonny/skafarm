const sidebar = document.getElementById("sidebar");
const mainContent = document.getElementById("mainContent");
const toggleBtn = document.getElementById("toggleSidebar");

toggleBtn.addEventListener("click", function () {
  if (window.innerWidth <= 768) {
    sidebar.classList.toggle("show");
  } else {
    sidebar.classList.toggle("collapsed");
    mainContent.classList.toggle("expanded");
  }
});

document.addEventListener("click", function (e) {
  if (window.innerWidth <= 768) {
    if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
      sidebar.classList.remove("show");
    }
  }
});

window.addEventListener("resize", function () {
  if (window.innerWidth > 768) {
    sidebar.classList.remove("show");
  } else {
    sidebar.classList.remove("collapsed");
    mainContent.classList.remove("expanded");
  }
});

let deleteCallback = null;

function confirmDelete(message, callback) {
  document.getElementById("confirmMessage").textContent = message;
  deleteCallback = callback;
  const modal = new bootstrap.Modal(document.getElementById("confirmModal"));
  modal.show();
}

function showAlert(type, title, message) {
  const alertIcon = document.getElementById("alertIcon");
  const alertTitle = document.getElementById("alertTitle");
  const alertMessage = document.getElementById("alertMessage");
  const alertOkBtn = document.getElementById("alertOkBtn");

  alertIcon.className = `alert-icon ${type}`;
  alertIcon.innerHTML =
    type === "success"
      ? '<i class="fas fa-check-circle"></i>'
      : '<i class="fas fa-times-circle"></i>';

  alertTitle.textContent = title;
  alertMessage.textContent = message;
  alertOkBtn.className = `btn btn-${type === "success" ? "success" : "danger"}`;

  const modal = new bootstrap.Modal(document.getElementById("alertModal"));
  modal.show();
}

document
  .getElementById("confirmDeleteBtn")
  .addEventListener("click", function () {
    if (deleteCallback) {
      deleteCallback();
      deleteCallback = null;
    }
    bootstrap.Modal.getInstance(document.getElementById("confirmModal")).hide();
  });

document
  .getElementById("productImage")
  ?.addEventListener("change", function (e) {
    const file = e.target.files[0];
    if (file) {
      const fileUpload = document.querySelector(".file-upload");
      if (fileUpload) {
        fileUpload.innerHTML = `
          <i class="fas fa-check-circle" style="color: #22c55e; font-size: 48px; margin-bottom: 16px;"></i>
          <h6 style="color: #22c55e;">File berhasil dipilih</h6>
          <p class="text-muted">${file.name}</p>
        `;
      }
    }
  });

function toggleProfileDropdown() {
  const dropdown = document.getElementById("profileDropdown");
  dropdown.classList.toggle("show");
}

function logout() {
  if (confirm("Apakah Anda yakin ingin logout?")) {
    showAlert("success", "Logout", "Logout berhasil!");
  }
}

document.addEventListener("click", function (e) {
  const dropdown = document.getElementById("profileDropdown");
  const profileBtn = document.querySelector(".profile-btn");
  if (
    dropdown &&
    profileBtn &&
    !profileBtn.contains(e.target) &&
    !dropdown.contains(e.target)
  ) {
    dropdown.classList.remove("show");
  }
});
