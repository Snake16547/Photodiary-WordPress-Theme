document.addEventListener("DOMContentLoaded", function () {
  const toggle = document.getElementById("darkmode-toggle");
  const menuToggle = document.getElementById("menu-toggle-btn");
  const navigation = document.getElementById("site-navigation");
  const navClose = document.getElementById("nav-close");

  // Close menu function
  function closeMenu() {
    if (navigation && menuToggle) {
      navigation.classList.remove("open");
      menuToggle.classList.remove("active");
      menuToggle.setAttribute("aria-expanded", "false");
      navigation.setAttribute("aria-hidden", "true");
    }
  }

  // Dark mode toggle
  if (toggle) {
    // Prevent the toggle from creating additional elements
    toggle.addEventListener("click", function(e) {
      e.stopPropagation();
    });
    
    toggle.addEventListener("change", () => {
      if (toggle.checked) {
        document.body.classList.add("dark-mode");
        localStorage.setItem("photodiary-darkmode", "on");
      } else {
        document.body.classList.remove("dark-mode");
        localStorage.setItem("photodiary-darkmode", "off");
      }
      
      // Close menu after toggling dark mode to prevent visual conflicts
      setTimeout(() => {
        closeMenu();
      }, 300);
    });

    // Load saved preference
    if (localStorage.getItem("photodiary-darkmode") === "on") {
      document.body.classList.add("dark-mode");
      toggle.checked = true;
    }
  }

  // Mobile menu toggle
  if (menuToggle && navigation) {
    menuToggle.addEventListener("click", (e) => {
      e.preventDefault();
      navigation.classList.add("open");
      menuToggle.classList.add("active");
      menuToggle.setAttribute("aria-expanded", "true");
      navigation.setAttribute("aria-hidden", "false");
    });
  }

  // Close button
  if (navClose) {
    navClose.addEventListener("click", (e) => {
      e.preventDefault();
      closeMenu();
    });
  }

  // Close menu when clicking outside
  if (navigation) {
    navigation.addEventListener("click", (e) => {
      if (e.target === navigation) {
        closeMenu();
      }
    });
  }

  // Close menu on escape key
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && navigation && navigation.classList.contains("open")) {
      closeMenu();
    }
  });

  // Archive year toggle functionality
  document.addEventListener('click', function(e) {
    if (e.target.classList.contains('year-button')) {
      const year = e.target.dataset.year;
      const monthsDiv = document.getElementById('months-' + year);
      if (monthsDiv) {
        monthsDiv.classList.toggle('open');
      }
    }
  });
});