import "./bootstrap";

/* =========================
   Mobile nav
========================= */
const navToggle = document.getElementById("navToggle");
const navMenu = document.getElementById("navMenu");

if (navToggle && navMenu) {
  navToggle.addEventListener("click", () => {
    const open = navMenu.classList.toggle("is-open");
    navToggle.setAttribute("aria-expanded", String(open));
  });

  navMenu.querySelectorAll("a").forEach((a) => {
    a.addEventListener("click", () => {
      navMenu.classList.remove("is-open");
      navToggle.setAttribute("aria-expanded", "false");
    });
  });
}

/* =========================
   Footer year
========================= */
const year = document.getElementById("year");
if (year) year.textContent = String(new Date().getFullYear());

/* =========================
   WhatsApp links (footer + FAB)
========================= */
const waMeta = document.querySelector('meta[name="wa-number"]')?.content;
const waLink = document.getElementById("waLink");
const fab = document.getElementById("fabWhatsApp");

if (waMeta) {
  const url = `https://wa.me/${waMeta}?text=${encodeURIComponent(
    "Hi! I want to book Ansambli Dardania."
  )}`;
  if (waLink) waLink.href = url;
  if (fab) fab.href = url;
}

/* =========================
   City "Other" toggle (works for both forms)
========================= */
function wireCityOther() {
  document.querySelectorAll("#citySelect").forEach((select) => {
    const form = select.closest("form");
    const wrap = form?.querySelector("#cityOtherWrap");
    const other = form?.querySelector("#cityOther");

    const sync = () => {
      const isOther = select.value === "__other__";
      if (wrap) wrap.style.display = isOther ? "block" : "none";
      if (other) other.required = isOther;
      if (!isOther && other) other.value = "";
    };

    select.addEventListener("change", sync);
    sync();
  });
}
wireCityOther();

/* =========================
   Package quick select buttons
========================= */
document.querySelectorAll("[data-pick-package]").forEach((btn) => {
  btn.addEventListener("click", () => {
    const pkg = btn.getAttribute("data-pick-package");
    const select = document.getElementById("packageSelect");
    if (select && pkg) select.value = pkg;
    document.getElementById("book")?.scrollIntoView({ behavior: "smooth" });
  });
});

/* =========================
   Modal system (supports stacked modals)
   - Gallery stays open behind Lightbox
   - ESC closes topmost modal only
========================= */
(() => {
  const body = document.body;

  const getOpenModals = () => Array.from(document.querySelectorAll(".modal.is-open"));

  const lockScrollIfNeeded = () => {
    if (getOpenModals().length > 0) body.classList.add("no-scroll");
    else body.classList.remove("no-scroll");
  };

  const openModal = (id) => {
    const modal = document.getElementById(id);
    if (!modal) return;

    modal.classList.add("is-open");
    modal.setAttribute("aria-hidden", "false");

    // Bring to front by moving it to end of body (top of stacking order)
    document.body.appendChild(modal);

    lockScrollIfNeeded();
  };

  const closeModal = (modal) => {
    if (!modal) return;

    modal.classList.remove("is-open");
    modal.setAttribute("aria-hidden", "true");

    // Stop YouTube playback inside closed modal
    modal.querySelectorAll("iframe").forEach((iframe) => {
      const src = iframe.src;
      iframe.src = src;
    });

    // Clear lightbox image when closed
    if (modal.id === "lightbox") {
      const img = document.getElementById("lightboxImg");
      if (img) img.src = "";
    }

    lockScrollIfNeeded();
  };

  /* Open gallery modals */
  document.addEventListener("click", (e) => {
    const btn = e.target.closest("[data-open]");
    if (!btn) return;

    e.preventDefault();
    const id = btn.getAttribute("data-open");
    if (id) openModal(id);
  });

  /* Close modals on backdrop + X (anything with data-close) */
  document.addEventListener("click", (e) => {
    const closeEl = e.target.closest("[data-close]");
    if (!closeEl) return;

    const modal = closeEl.closest(".modal");
    closeModal(modal);
  });

  /* ESC closes topmost open modal only */
  document.addEventListener("keydown", (e) => {
    if (e.key !== "Escape") return;
    const open = getOpenModals();
    const top = open[open.length - 1];
    closeModal(top);
  });

  /* Lightbox (single image fullscreen)
     IMPORTANT:
     - Do NOT close gallery
     - Just open lightbox on top
  */
  document.addEventListener("click", (e) => {
    const trigger = e.target.closest("[data-lightbox]");
    if (!trigger) return;

    e.preventDefault();
    e.stopPropagation();

    const src = trigger.getAttribute("data-lightbox");
    const lightboxImg = document.getElementById("lightboxImg");
    if (!src || !lightboxImg) return;

    lightboxImg.src = src;
    openModal("lightbox");
  });

  /* Clicking the actual lightbox image should NOT close it */
  const lightboxImg = document.getElementById("lightboxImg");
  if (lightboxImg) {
    lightboxImg.addEventListener("click", (e) => e.stopPropagation());
  }
})();



// MOBILE NAV ONLY
document.addEventListener("DOMContentLoaded", () => {
  const btn = document.getElementById("mnavBtn");
  const menu = document.getElementById("mnavMenu");
  if (!btn || !menu) return;

  const close = () => {
    menu.classList.remove("is-open");
    btn.setAttribute("aria-expanded", "false");
    menu.setAttribute("aria-hidden", "true");
  };

  btn.addEventListener("click", (e) => {
    e.stopPropagation();
    const open = menu.classList.toggle("is-open");
    btn.setAttribute("aria-expanded", open ? "true" : "false");
    menu.setAttribute("aria-hidden", open ? "false" : "true");
  });

  menu.addEventListener("click", (e) => {
    if (e.target.closest("a")) close();
  });

  document.addEventListener("click", (e) => {
    if (menu.contains(e.target) || btn.contains(e.target)) return;
    close();
  });
});   



