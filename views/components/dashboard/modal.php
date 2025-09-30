<div class="modal fade custom-alert-modal" id="alertModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="alert-icon" id="alertIcon">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="alert-content">
                    <div class="alert-title" id="alertTitle">Berhasil!</div>
                    <div class="alert-message" id="alertMessage">Operasi berhasil dilakukan.</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="alertOkBtn">OK</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');

        if (status) {
            const alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
            const alertIcon = document.getElementById('alertIcon');
            const alertTitle = document.getElementById('alertTitle');
            const alertMessage = document.getElementById('alertMessage');

            if (status === 'success') {
                alertIcon.innerHTML = '<i class="bi bi-check-circle-fill text-success"></i>';
                alertTitle.textContent = 'Berhasil!';
                alertMessage.textContent = 'Operasi berhasil dilakukan.';
            } else if (status === 'error') {
                alertIcon.innerHTML = '<i class="bi bi-x-circle-fill text-danger"></i>';
                alertTitle.textContent = 'Gagal!';
                alertMessage.textContent = 'Terjadi kesalahan, coba lagi.';
            }

            alertModal.show();
        }
    });
</script>