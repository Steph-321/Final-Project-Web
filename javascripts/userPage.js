document.addEventListener("DOMContentLoaded", () => {
  const links = document.querySelectorAll(".sidebar ul li a");
  const sections = document.querySelectorAll(".section");

  links.forEach(link => {
    link.addEventListener("click", e => {
      e.preventDefault();

      const parentLi = link.parentElement;
      const targetSectionId = parentLi.getAttribute("data-section");

      document.querySelectorAll(".sidebar ul li").forEach(li => li.classList.remove("active"));
      parentLi.classList.add("active");

      sections.forEach(section => section.classList.remove("active"));

      const targetSection = document.getElementById(targetSectionId);
      if (targetSection) {
        targetSection.classList.add("active");
      }
    });
  });
});

const logoutBtn = document.getElementById("logoutBtn");

if (logoutBtn) {
  logoutBtn.addEventListener("click", async () => {
    try {
      const response = await fetch("../php/logout.php", {
        method: "GET",
        credentials: "same-origin"
      });

      if (response.ok) {
        window.location.href = "../index.html";
      } else {
        alert("Logout failed. Please try again.");
      }
    } catch (error) {
      console.error("Logout error:", error);
      alert("An error occurred during logout.");
    }
  });
}
