document.addEventListener("DOMContentLoaded", function () {
  const tabs = document.querySelectorAll("#orderTabs .nav-link");

  tabs.forEach((tab) => {
    tab.addEventListener("click", function (e) {
      e.preventDefault();

      // Remove active class from all tabs
      tabs.forEach((t) => t.classList.remove("active"));

      // Add active class to clicked tab
      this.classList.add("active");

      // Hide all tab panes
      const tabPanes = document.querySelectorAll(".tab-pane");
      tabPanes.forEach((pane) => {
        pane.classList.remove("show", "active");
      });

      // Show target tab pane
      const targetId = this.getAttribute("data-bs-target");
      const targetPane = document.querySelector(targetId);
      if (targetPane) {
        targetPane.classList.add("show", "active");
      }
    });
  });
});

function openEditModal(id, judul, artikel, img) {
  document.getElementById("blogEditId").value = id;
  document.getElementById("blogEditTitle").value = judul;
  document.getElementById("blogEditContent").value = artikel;
  document.getElementById("blogEditOldImg").value = img;
}
document.addEventListener("DOMContentLoaded", () => {
  const wrapper = document.getElementById("categories-wrapper");
  const nextBtn = document.getElementById("next-btn");
  const prevBtn = document.getElementById("prev-btn");
  const scrollAmount = 300;

  nextBtn.addEventListener("click", () => {
    if (wrapper) {
      wrapper.scrollBy({
        left: scrollAmount,
        behavior: "smooth",
      });
    }
  });

  prevBtn.addEventListener("click", () => {
    if (wrapper) {
      wrapper.scrollBy({
        left: -scrollAmount,
        behavior: "smooth",
      });
    }
  });
});
