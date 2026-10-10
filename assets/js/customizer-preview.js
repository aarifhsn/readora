/**
 * Readora — Customizer Live Preview (postMessage)
 *
 * This file runs ONLY inside the Customizer preview iframe.
 * It listens for wp.customize() changes and updates the live
 * preview without a full page reload.
 *
 * For this to work, the corresponding setting must have:
 *   'transport' => 'postMessage'
 * in customizer.php. Settings with 'transport' => 'refresh'
 * do NOT use this file — they reload the preview on change.
 *
 * @package Readora
 * @since   1.0.0
 */

(function ($) {
  "use strict";

  var api = wp.customize;

  /* ----------------------------------------------------------
	   ACCENT COLOR
	   Updates the CSS custom property --color-primary live.
	   No page reload needed.
	---------------------------------------------------------- */
  api("readora_accent_color", function (value) {
    value.bind(function (newColor) {
      if (!newColor) return;

      var styleEl = document.getElementById("readora-preview-accent");
      if (!styleEl) {
        styleEl = document.createElement("style");
        styleEl.id = "readora-preview-accent";
        document.head.appendChild(styleEl);
      }

      styleEl.textContent = [
        ":root {",
        "  --color-primary: " + newColor + ";",
        "  --color-primary-dark: " + newColor + ";",
        "  --color-primary-light: " + newColor + ";",
        "  --color-accent-text: " + newColor + ";",
        "}",
      ].join("\n");
    });
  });

  /* ----------------------------------------------------------
	   BODY FONT SIZE
	   Updates html { font-size } live.
	---------------------------------------------------------- */
  api("readora_body_font_size", function (value) {
    value.bind(function (newSize) {
      newSize = parseInt(newSize, 10);
      if (isNaN(newSize) || newSize < 14 || newSize > 20) return;

      var styleEl = document.getElementById("readora-preview-fontsize");
      if (!styleEl) {
        styleEl = document.createElement("style");
        styleEl.id = "readora-preview-fontsize";
        document.head.appendChild(styleEl);
      }

      styleEl.textContent = "html { font-size: " + newSize + "px; }";
    });
  });

  /* Show live value next to the font size range slider in the Customizer panel */
  (function waitForSlider() {
    var slider = document.querySelector(
      '#customize-control-readora_body_font_size input[type="range"]',
    );
    if (!slider) {
      setTimeout(waitForSlider, 500);
      return;
    }

    var badge = document.createElement("span");
    badge.style.cssText =
      "margin-left:8px;font-weight:600;font-size:13px;color:#1e1e1e;";
    badge.textContent = slider.value + "px";
    slider.parentNode.insertBefore(badge, slider.nextSibling);

    slider.addEventListener("input", function () {
      badge.textContent = slider.value + "px";
    });
  })();

  /* ----------------------------------------------------------
	   SITE TITLE (blogname)
	---------------------------------------------------------- */
  api("blogname", function (value) {
    value.bind(function (newName) {
      $(".tm-brand__text").text(newName);
    });
  });

  /* ----------------------------------------------------------
	   SITE DESCRIPTION (blogdescription)
	---------------------------------------------------------- */
  api("blogdescription", function (value) {
    value.bind(function (newDesc) {
      $(".site-description").text(newDesc);
    });
  });

  /* ----------------------------------------------------------
	   HEADER TEXT COLOR — core WordPress setting.
	---------------------------------------------------------- */
  api("header_textcolor", function (value) {
    value.bind(function (newColor) {
      var styleEl = document.getElementById("readora-preview-headertext");
      if (!styleEl) {
        styleEl = document.createElement("style");
        styleEl.id = "readora-preview-headertext";
        document.head.appendChild(styleEl);
      }

      if (newColor === "blank") {
        styleEl.textContent = [
          ".tm-brand__text,",
          ".tm-brand__link,",
          ".site-description {",
          "  clip: rect(1px,1px,1px,1px);",
          "  position: absolute;",
          "}",
        ].join("\n");
      } else {
        styleEl.textContent = [
          ".tm-brand__text,",
          ".tm-brand__link,",
          ".tm-brand__text span,",
          ".site-description {",
          "  color: #" + newColor + ";",
          "}",
        ].join("\n");
      }
    });
  });
})(jQuery);
