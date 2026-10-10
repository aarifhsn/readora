=== Readora ===
Contributors: arifhassan
Tags: blog, news, one-column, two-columns, right-sidebar, custom-background, custom-header, custom-logo, custom-menu, featured-images, full-width-template, threaded-comments, translation-ready, accessibility-ready, block-styles, wide-blocks, editor-style, sticky-post
Requires at least: 6.0
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A modern, editorial WordPress theme for blogs, publications, and magazines.

== Description ==

Readora is a clean, editorial theme that works equally well as a personal
blog and as a small magazine or publication. It focuses on typography,
spacing and reading comfort rather than decoration: no gradients, no
card shadows, no unnecessary animation.

Features:

* Modern editorial homepage: a lead story, a responsive post grid, and an
  optional sidebar with tabbed Recent / Popular / Comments widgets
* Three homepage layouts (3-column grid, 2-column grid, list view),
  switchable in the Customizer
* Distraction-free single-post reading column, with an optional sidebar
* Dark mode with a manual toggle, remembered per visitor, and OS-preference
  detection before first toggle
* Self-hosted fonts (Inter, Playfair Display, JetBrains Mono) — no
  external font requests
* Built-in newsletter block (bring your own embed code, or use the
  built-in WordPress-native signup form)
* Accessible: skip link, visible focus states, ARIA-labelled tabs and
  navigation, keyboard-operable dropdown menus
* Full comment threading, custom comment walker, threaded replies
* Schema.org Article markup and Open Graph / Twitter Card meta tags
  (automatically skipped if an SEO plugin is active)
* Translation-ready, Gutenberg-ready, block-editor styles matched to the
  front end

== Installation ==

1. In your WordPress admin, go to Appearance > Themes > Add New > Upload
   Theme, and upload the readora.zip file. Alternatively, unzip it and
   upload the `readora` folder to `/wp-content/themes/` via FTP/SFTP.
2. Activate the theme through the 'Themes' screen.
3. Go to Appearance > Menus and assign a menu to the "Primary Menu" and,
   optionally, "Footer Menu" locations.
4. Go to Appearance > Customize > Theme Options to set an accent color,
   choose a homepage layout, configure the newsletter block, and add
   social links.
5. (Optional) Go to Appearance > Widgets to add widgets to the "Main
   Sidebar" and "Footer" widget areas.

== Frequently Asked Questions ==

= Does this theme support Gutenberg / the block editor? =

Yes. The block editor is styled to match the front end, and the theme
declares support for wide/full alignment, custom color palette and
responsive embeds.

= Does this theme require any plugins? =

No. Every feature (newsletter signup, breadcrumbs, reading time,
schema markup) is built into the theme itself.

= How do I show a sidebar on single posts or pages? =

By default, single posts and pages use a centered, sidebar-free reading
column for the best reading experience. Two checkboxes under
Appearance > Customize > Theme Options > Layout turn the sidebar back on
for single posts and for static pages independently.

== Changelog ==

= 1.0.0 =
* Initial public release.

== Credits ==

This theme is an original design and code base by Arif Hassan, and
bundles the following third-party resources:

* Inter typeface, weights 400/500/600/700, by The Inter Project Authors
  (https://github.com/rsms/inter) — licensed under the SIL Open Font
  License, 1.1 (https://openfontlicense.org). Distributed as static
  woff2 files under assets/fonts/, packaged via the Fontsource project
  (https://fontsource.org, MIT-licensed packaging).
* Playfair Display typeface, weight 700, by Claus Eggers Sørensen —
  licensed under the SIL Open Font License, 1.1
  (https://openfontlicense.org). Distributed as a static woff2 file
  under assets/fonts/, packaged via the Fontsource project.
* JetBrains Mono typeface, weight 400, by JetBrains s.r.o. — licensed
  under the SIL Open Font License, 1.1 (https://openfontlicense.org).
  Distributed as a static woff2 file under assets/fonts/, packaged via
  the Fontsource project.
* Full OFL 1.1 license text and copyright notices for each of the three
  typefaces are included as assets/fonts/LICENSE-inter.txt,
  assets/fonts/LICENSE-playfair-display.txt, and
  assets/fonts/LICENSE-jetbrains-mono.txt.
* Interface icons are custom-drawn inline SVGs (search, sun/moon, menu,
  social, share, back-to-top), original to this theme, released under
  the theme's GPLv2-or-later license.
* Tailwind CSS (https://tailwindcss.com), MIT-licensed, is used as a
  build-time utility layer; the compiled, minified output is committed
  to assets/css/tailwind.output.css so the theme has no runtime
  dependency on Node or Tailwind.

Readora, like all WordPress themes, is licensed under the GPL
(https://www.gnu.org/licenses/gpl-2.0.html), or any later version.
Readora is distributed in the hope that it will be useful, but WITHOUT
ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
FITNESS FOR A PARTICULAR PURPOSE.
