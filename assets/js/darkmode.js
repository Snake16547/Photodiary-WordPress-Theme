document.addEventListener("DOMContentLoaded", function () {
  const toggle = document.getElementById("darkmode-toggle");
  const menuToggle = document.getElementById("menu-toggle-btn");
  const navigation = document.getElementById("site-navigation");
  const navClose = document.getElementById("nav-close");

  if (!navigation || typeof navigation.showModal !== "function" || !menuToggle || !navClose) {
    return;
  }

  menuToggle.hidden = false;
  menuToggle.addEventListener("click", () => {
    navigation.showModal();
    menuToggle.setAttribute("aria-expanded", "true");
  });

  navClose.addEventListener("click", () => navigation.close());
  navigation.addEventListener("close", () => {
    menuToggle.setAttribute("aria-expanded", "false");
    menuToggle.focus();
  });

  navigation.addEventListener("keydown", (event) => {
    if (event.key !== "Tab") {
      return;
    }

    const controls = Array.from(navigation.querySelectorAll("button, input, summary, details[open] a[href]"))
      .filter((element) => !element.disabled && element.getClientRects().length);
    const first = controls[0];
    const last = controls[controls.length - 1];

    if (event.shiftKey && document.activeElement === first) {
      event.preventDefault();
      last.focus();
    } else if (!event.shiftKey && document.activeElement === last) {
      event.preventDefault();
      first.focus();
    }
  });

  if (toggle) {
    try {
      toggle.checked = localStorage.getItem("photodiary-darkmode") === "on";
      document.body.classList.toggle("dark-mode", toggle.checked);
    } catch (error) {
      // The toggle still works when browser storage is unavailable.
    }

    toggle.addEventListener("change", () => {
      document.body.classList.toggle("dark-mode", toggle.checked);
      try {
        localStorage.setItem("photodiary-darkmode", toggle.checked ? "on" : "off");
      } catch (error) {
        // Apply the preference for this page even if it cannot be saved.
      }
    });
  }
});
