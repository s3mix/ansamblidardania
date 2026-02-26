import "./bootstrap";

/* =========================
   Mobile nav (single source of truth)
========================= */
const navToggle = document.getElementById("navToggle");
const navMenu = document.getElementById("navMenu");

function closeNav() {
  if (!navMenu || !navToggle) return;
  navMenu.classList.remove("is-open");
  navToggle.setAttribute("aria-expanded", "false");
}

function openNav() {
  if (!navMenu || !navToggle) return;
  navMenu.classList.add("is-open");
  navToggle.setAttribute("aria-expanded", "true");
}

if (navToggle && navMenu) {
  navToggle.addEventListener("click", (e) => {
    e.stopPropagation();
    const isOpen = navMenu.classList.contains("is-open");
    if (isOpen) closeNav();
    else openNav();
  });

  // close when clicking any link inside menu
  navMenu.addEventListener("click", (e) => {
    const a = e.target.closest("a");
    if (!a) return;
    closeNav();
  });

  // close when clicking outside
  document.addEventListener("click", (e) => {
    if (navMenu.contains(e.target) || navToggle.contains(e.target)) return;
    closeNav();
  });

  // close on ESC
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeNav();
  });
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
   Modal system (stacked modals)
========================= */
(() => {
  const body = document.body;

  const getOpenModals = () =>
    Array.from(document.querySelectorAll(".modal.is-open"));

  const lockScrollIfNeeded = () => {
    if (getOpenModals().length > 0) body.classList.add("no-scroll");
    else body.classList.remove("no-scroll");
  };

  const openModal = (id) => {
    const modal = document.getElementById(id);
    if (!modal) return;

    modal.classList.add("is-open");
    modal.setAttribute("aria-hidden", "false");
    document.body.appendChild(modal); // bring to front
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

  // open gallery modals
  document.addEventListener("click", (e) => {
    const btn = e.target.closest("[data-open]");
    if (!btn) return;

    e.preventDefault();
    const id = btn.getAttribute("data-open");
    if (id) openModal(id);
  });

  // close modals (backdrop or close button)
  document.addEventListener("click", (e) => {
    const closeEl = e.target.closest("[data-close]");
    if (!closeEl) return;
    const modal = closeEl.closest(".modal");
    closeModal(modal);
  });

  // ESC closes topmost modal only
  document.addEventListener("keydown", (e) => {
    if (e.key !== "Escape") return;
    const open = getOpenModals();
    const top = open[open.length - 1];
    closeModal(top);
  });

  // Lightbox open (do NOT close gallery)
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

  // Clicking the actual lightbox image should NOT close it
  const lightboxImg = document.getElementById("lightboxImg");
  if (lightboxImg) {
    lightboxImg.addEventListener("click", (e) => e.stopPropagation());
  }
})();

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.waBtn').forEach((btn) => {
    btn.addEventListener('click', () => {

      const form = btn.closest('form');
      if (!form) return;

      if (!form.checkValidity()) {
        form.reportValidity();
        return;
      }

      const get = (name) =>
        form.querySelector(`[name="${name}"]`)?.value?.trim() || '';

      const name = get('name');
      const phone = get('phone');
      const eventType = get('event_type');
      const pkg = get('package');
      const date = get('event_date');
      const start = get('start_time');
      const citySel = get('city_select');
      const city = citySel === '__other__' ? get('city_other') : citySel;
      const venue = get('venue');
      const notes = get('notes');

      const businessNumber = '355684422266';

      const msg =
`Pershendetje un dua te rezervoj Ansambli Dardania.
Emri: ${name}
Numri tel: ${phone}
Lloji i Eventit: ${eventType}
Paketa: ${pkg}
Data: ${date}${start ? ` (${start})` : ''}
Qyteti: ${city}
Venue: ${venue || '-'}
Shenimet: ${notes || '-'}`;

      const url = `https://wa.me/${businessNumber}?text=${encodeURIComponent(msg)}`;
      window.open(url, '_blank');
    });
  });
});

  // toggle "Other city" input
  const citySelect = document.getElementById('citySelect');
  const cityOtherWrap = document.getElementById('cityOtherWrap');
  const cityOther = document.getElementById('cityOther');

  function syncCityOther() {
    const isOther = citySelect?.value === '__other__';
    if (!cityOtherWrap) return;

    cityOtherWrap.style.display = isOther ? '' : 'none';
    if (cityOther) cityOther.required = !!isOther;
  }
  citySelect?.addEventListener('change', syncCityOther);
  syncCityOther();

  