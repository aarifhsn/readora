<?php
/**
 * Readora Theme Functions and Definitions
 *
 * @package Readora
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
	exit;
}

// ============================================================
// THEME CONSTANTS
// ============================================================

define('READORA_VERSION', '1.0.0');
define('READORA_DIR', get_template_directory());
define('READORA_URI', get_template_directory_uri());
define('READORA_INC', READORA_DIR . '/inc/');

// Load feature files
$readora_includes = array(
	'/inc/setup.php',          // Theme setup, image sizes, nav menus
	'/inc/enqueue.php',        // Scripts and styles
	'/inc/fonts.php',          // Self-hosted fonts
	'/inc/widgets.php',        // Sidebar registration
	'/inc/helpers.php',        // Breadcrumbs, reading time, pagination, post meta
	'/inc/walker.php',         // Comment walker
	'/inc/customizer.php',     // Customizer registration + sanitization
	'/inc/newsletter.php',     // Newsletter block output
	'/inc/ajax-handlers.php',  // AJAX subscription handler
	'/inc/admin-pages.php',    // Subscribers admin page
	'/inc/schema.php',         // Schema.org + OG meta tags
	'/inc/security.php',       // Login errors, generator tag removal
);
foreach ($readora_includes as $file) {
	$filepath = READORA_DIR . $file;
	if (file_exists($filepath)) {
		require_once $filepath;
	}
}
