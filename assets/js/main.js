/**
 * Readora — Main JavaScript
 *
 * Pure vanilla JS. Zero jQuery. Zero external dependencies.
 *
 * Handles:
 *  - Dark mode toggle with localStorage + OS preference
 *  - Sticky header: hide on scroll-down, reveal on scroll-up
 *  - Mobile nav: accessible drawer
 *  - Search overlay
 *  - Sidebar tabs: full ARIA + keyboard
 *  - Reading progress bar
 *  - Back-to-top button
 *  - Copy link button
 *  - Fade-in animations (IntersectionObserver)
 *  - Responsive video embeds
 *  - Newsletter form feedback
 *  - Dropdown keyboard navigation
 *
 * @package Readora
 * @version 1.0.0
 */

(function () {
  "use strict";

  /* ============================================================
	   UTILS
	   ============================================================ */

  var $ = function (s, c) {
    return (c || document).querySelector(s);
  };
  var $$ = function (s, c) {
    return (c || document).querySelectorAll(s);
  };

  function raf(fn) {
    var pending = false;
    return function () {
      if (!pending) {
        pending = true;
        requestAnimationFrame(function () {
          fn();
          pending = false;
        });
      }
    };
  }

  function store(key, val) {
    try {
      return val === undefined
        ? localStorage.getItem(key)
        : (localStorage.setItem(key, val), val);
    } catch (e) {
      return null;
    }
  }

  /* ============================================================
	   01. DARK MODE
	   Priority: localStorage → OS preference → light (default)
	   Adds/removes .dark-mode and .light-mode on <html>.
	   CSS rules in style.css swap .icon-sun / .icon-moon.
	   ============================================================ */

  var DARK_KEY = "readora_dark";
  var darkBtn = $("#dark-mode-toggle");
  var html = document.documentElement;
  var osDark = window.matchMedia("(prefers-color-scheme: dark)");

  function applyDark(on) {
    html.classList.toggle("dark-mode", !!on);
    html.classList.toggle("light-mode", !on);
    if (darkBtn) darkBtn.setAttribute("aria-pressed", on ? "true" : "false");
  }

  applyDark(
    store(DARK_KEY) !== null ? store(DARK_KEY) === "true" : osDark.matches,
  );

  if (darkBtn) {
    darkBtn.addEventListener("click", function () {
      var on = !html.classList.contains("dark-mode");
      applyDark(on);
      store(DARK_KEY, String(on));
    });
  }

  osDark.addEventListener("change", function (e) {
    if (store(DARK_KEY) === null) applyDark(e.matches);
  });

  /* ============================================================
	   02. STICKY HEADER
	   Adds .is-scrolled (box-shadow) after 60px.
	   Adds .is-hidden (translateY(-100%)) on fast scroll-down.
	   Removes .is-hidden on any scroll-up.
	   ============================================================ */

  var header = $("#site-header");
  var lastScroll = 0;

  if (header) {
    window.addEventListener(
      "scroll",
      raf(function () {
        var y = window.scrollY;
        header.classList.toggle("is-scrolled", y > 60);
        if (y > 250) {
          header.classList.toggle("is-hidden", y > lastScroll + 5);
        } else {
          header.classList.remove("is-hidden");
        }
        lastScroll = Math.max(0, y);
      }),
      { passive: true },
    );
  }

  /* ============================================================
	   03. MOBILE NAV DRAWER
	   ============================================================ */

  var menuBtn = $("#menu-toggle");
  var mobileNav = $("#mobile-nav");

  function navOpen() {
    mobileNav.removeAttribute("hidden");
    requestAnimationFrame(function () {
      mobileNav.classList.add("is-open");
    });
    menuBtn.classList.add("is-active");
    menuBtn.setAttribute("aria-expanded", "true");
    document.body.style.overflow = "hidden";
  }

  function navClose(refocus) {
    mobileNav.classList.remove("is-open");
    menuBtn.classList.remove("is-active");
    menuBtn.setAttribute("aria-expanded", "false");
    document.body.style.overflow = "";
    mobileNav.addEventListener("transitionend", function once() {
      mobileNav.setAttribute("hidden", "");
      mobileNav.removeEventListener("transitionend", once);
    });
    if (refocus) menuBtn.focus();
  }

  if (menuBtn && mobileNav) {
    menuBtn.addEventListener("click", function () {
      mobileNav.classList.contains("is-open") ? navClose(false) : navOpen();
    });
    document.addEventListener("keydown", function (e) {
      if (
        e.key === "Escape" &&
        mobileNav &&
        mobileNav.classList.contains("is-open")
      )
        navClose(true);
    });
    mobileNav.addEventListener("click", function (e) {
      if (e.target.tagName === "A") navClose(false);
    });
  }

  /* ============================================================
	   04. SEARCH OVERLAY
	   Base CSS rule is display:none. Opening the overlay just
	   toggles the .is-open class (display:flex via CSS).
	   ============================================================ */

  var searchBtn = $("#search-toggle");
  var searchOverlay = $("#search-overlay");
  var searchClose = $("#search-overlay-close");
  var searchInput = $("#search-overlay .search-field");

  function searchOpen() {
    if (!searchOverlay) return;
    searchOverlay.classList.add("is-open");
    if (searchInput) {
      searchInput.value = "";
      searchInput.focus();
    }
    if (searchBtn) searchBtn.setAttribute("aria-expanded", "true");
    document.body.style.overflow = "hidden";
  }

  function searchCloseF(refocus) {
    if (!searchOverlay) return;
    searchOverlay.classList.remove("is-open");
    if (searchBtn) searchBtn.setAttribute("aria-expanded", "false");
    document.body.style.overflow = "";
    if (refocus && searchBtn) searchBtn.focus();
  }

  if (searchBtn) searchBtn.addEventListener("click", searchOpen);
  if (searchClose)
    searchClose.addEventListener("click", function () {
      searchCloseF(true);
    });
  if (searchOverlay) {
    searchOverlay.addEventListener("click", function (e) {
      if (e.target === searchOverlay) searchCloseF(true);
    });
  }
  document.addEventListener("keydown", function (e) {
    if (
      e.key === "Escape" &&
      searchOverlay &&
      searchOverlay.classList.contains("is-open")
    ) {
      searchCloseF(true);
    }
  });

  /* ============================================================
	   05. DROPDOWN KEYBOARD NAV — all levels
	   ============================================================ */

  function initDropdownKbd(navEl) {
    if (!navEl) return;
    $$(".menu-item-has-children", navEl).forEach(function (item) {
      var sub = item.querySelector(":scope > .sub-menu");
      var trigger = item.querySelector(":scope > a");
      if (!sub || !trigger) return;

      trigger.setAttribute("aria-haspopup", "true");
      trigger.setAttribute("aria-expanded", "false");

      function openSub() {
        trigger.setAttribute("aria-expanded", "true");
      }
      function closeSub() {
        trigger.setAttribute("aria-expanded", "false");
      }

      trigger.addEventListener("keydown", function (e) {
        var href = trigger.getAttribute("href");
        if (e.key === " " || (e.key === "Enter" && (!href || href === "#"))) {
          e.preventDefault();
          trigger.getAttribute("aria-expanded") === "true"
            ? closeSub()
            : openSub();
          if (trigger.getAttribute("aria-expanded") === "true") {
            var first = sub.querySelector("a");
            if (first) first.focus();
          }
        }
        if (e.key === "Escape") {
          closeSub();
          trigger.focus();
        }
      });

      item.addEventListener("focusout", function () {
        setTimeout(function () {
          if (!item.contains(document.activeElement)) closeSub();
        }, 0);
      });
    });
  }

  initDropdownKbd($("#primary-nav"));
  initDropdownKbd($("#mobile-nav"));

  /* ============================================================
	   06. SIDEBAR TABS — ARIA compliant, keyboard accessible
	   ============================================================ */

  $$(".sidebar-tabs").forEach(function (container) {
    var tabs = Array.from($$('[role="tab"]', container));
    var panels = Array.from($$('[role="tabpanel"]', container));

    function activate(tab) {
      tabs.forEach(function (t) {
        var on = t === tab;
        t.setAttribute("aria-selected", String(on));
        t.classList.toggle("is-active", on);
        t.tabIndex = on ? 0 : -1;
      });
      panels.forEach(function (p) {
        var on = p.id === tab.getAttribute("aria-controls");
        p.classList.toggle("hidden", !on);
        p.classList.toggle("is-active", on);
      });
    }

    tabs.forEach(function (tab, i) {
      tab.tabIndex = i === 0 ? 0 : -1;
      tab.addEventListener("click", function () {
        activate(tab);
      });
      tab.addEventListener("keydown", function (e) {
        var len = tabs.length,
          next = null;
        if (e.key === "ArrowRight" || e.key === "ArrowDown")
          next = tabs[(i + 1) % len];
        else if (e.key === "ArrowLeft" || e.key === "ArrowUp")
          next = tabs[(i - 1 + len) % len];
        else if (e.key === "Home") next = tabs[0];
        else if (e.key === "End") next = tabs[len - 1];
        if (next) {
          e.preventDefault();
          activate(next);
          next.focus();
        }
      });
    });
  });

  /* ============================================================
	   07. READING PROGRESS BAR
	   ============================================================ */

  var progressBar = $("#reading-progress");
  var entryContent = $(".entry-content");

  if (progressBar && entryContent) {
    window.addEventListener(
      "scroll",
      raf(function () {
        var top = entryContent.getBoundingClientRect().top + window.scrollY;
        var pct = Math.min(
          100,
          Math.max(
            0,
            ((window.scrollY - top) / entryContent.offsetHeight) * 100,
          ),
        );
        progressBar.style.width = pct + "%";
        progressBar.setAttribute("aria-valuenow", Math.round(pct));
      }),
      { passive: true },
    );
  }

  /* ============================================================
	   08. BACK TO TOP
	   ============================================================ */

  var backBtn = $("#back-to-top");

  if (backBtn) {
    window.addEventListener(
      "scroll",
      raf(function () {
        var show = window.scrollY > 400;
        if (show) {
          backBtn.removeAttribute("hidden");
          requestAnimationFrame(function () {
            backBtn.classList.add("is-visible");
          });
        } else {
          backBtn.classList.remove("is-visible");
          backBtn.addEventListener("transitionend", function once() {
            if (!backBtn.classList.contains("is-visible"))
              backBtn.setAttribute("hidden", "");
            backBtn.removeEventListener("transitionend", once);
          });
        }
      }),
      { passive: true },
    );

    backBtn.addEventListener("click", function () {
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  }

  /* ============================================================
	   09. COPY LINK BUTTON
	   ============================================================ */

  $$(".js-copy-link").forEach(function (btn) {
    btn.addEventListener("click", function () {
      var url = btn.dataset.url || window.location.href;
      var orig = btn.innerHTML;
      function done() {
        btn.textContent = "✓ Copied!";
        btn.disabled = true;
        setTimeout(function () {
          btn.innerHTML = orig;
          btn.disabled = false;
        }, 2000);
      }
      if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard
          .writeText(url)
          .then(done)
          .catch(function () {
            fbCopy(url, done);
          });
      } else {
        fbCopy(url, done);
      }
    });
  });

  function fbCopy(text, cb) {
    var ta = document.createElement("textarea");
    ta.value = text;
    ta.style.cssText = "position:fixed;opacity:0;";
    document.body.appendChild(ta);
    ta.focus();
    ta.select();
    try {
      document.execCommand("copy");
      cb();
    } catch (e) {}
    document.body.removeChild(ta);
  }

  /* ============================================================
	   10. SCROLL FADE-IN ANIMATIONS
	   ============================================================ */

  if (
    !window.matchMedia("(prefers-reduced-motion: reduce)").matches &&
    "IntersectionObserver" in window
  ) {
    var io = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (e) {
          if (e.isIntersecting) {
            e.target.classList.add("is-visible");
            io.unobserve(e.target);
          }
        });
      },
      { threshold: 0.08, rootMargin: "0px 0px -32px 0px" },
    );

    $$(".widget, .newsletter-block").forEach(function (el) {
      el.classList.add("fade-in");
      io.observe(el);
    });
  }

  /* ============================================================
	   11. RESPONSIVE VIDEO EMBEDS
	   ============================================================ */

  $$(".entry-content iframe").forEach(function (iframe) {
    var src = iframe.getAttribute("src") || "";
    if (!/youtube|vimeo|dailymotion|youtu\.be/.test(src)) return;
    if (iframe.parentNode.classList.contains("tm-video-wrap")) return;
    var wrap = document.createElement("div");
    wrap.className = "tm-video-wrap";
    iframe.parentNode.insertBefore(wrap, iframe);
    wrap.appendChild(iframe);
  });

  /* ============================================================
	   DONE
	   ============================================================ */
  html.classList.add("js-ready");
})();

// Newsletter built-in form AJAX submission
document.addEventListener("submit", function (e) {
  const form = e.target.closest(".readora-newsletter-form");
  if (!form) return;
  e.preventDefault();

  const email = form.querySelector('[name="email"]').value;
  const nonce = form.querySelector('[name="newsletter_nonce"]').value;
  const btn = form.querySelector('[type="submit"]');
  const original = btn.textContent;

  btn.disabled = true;
  btn.textContent = "...";

  fetch(ReadoraData.ajaxUrl, {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams({
      action: "readora_newsletter_subscribe",
      newsletter_nonce: nonce,
      email: email,
    }),
  })
    .then((r) => r.json())
    .then((data) => {
      btn.textContent = data.data.message;
      if (data.success) form.reset();
      setTimeout(() => {
        btn.disabled = false;
        btn.textContent = original;
      }, 3000);
    })
    .catch(() => {
      btn.disabled = false;
      btn.textContent = original;
    });
});
