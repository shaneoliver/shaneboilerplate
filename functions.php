<?php

use ShaneOliver\Admin;
use ShaneOliver\Setup;
use ShaneOliver\Blocks;
use ShaneOliver\Config;
use ShaneOliver\Fields;
use ShaneOliver\Widgets;
use ShaneOliver\PostTypes;
use ShaneOliver\Customizer;
use ShaneOliver\TimberSetup;

// Register Composer Autoload
if (file_exists( __DIR__ . '/vendor/autoload.php')) {
    require_once(__DIR__ . '/vendor/autoload.php');
}

// Bind configuration files to the config container
Config::bind('settings', require(__DIR__ . '/theme/config/settings.php'));
Config::bind('gutenberg', require(__DIR__ . '/theme/config/gutenberg.php'));
Config::bind('theme_mods', require(__DIR__ . '/theme/config/customizer.php'));

// Sets up theme defaults and registers support for various WordPress features.
add_action('after_setup_theme', [new Setup, 'init']);

// Register widget areas
add_action('widgets_init', [new Widgets, 'register']);
add_action('widgets_init', [new Widgets, 'unregister']);

// Enqueue scripts and styles.
add_action('wp_enqueue_scripts', function () {
	wp_enqueue_style('shaneoliver/app.css', get_theme_file_uri('/public/css/app.css'), false, null);
	wp_enqueue_style('shaneoliver/fontawesome-all.min.css', get_theme_file_uri('/public/css/fontawesome-all.min.css'), false, null);
    wp_enqueue_script('shaneoliver/app.js', get_theme_file_uri('/public/js/app.js'), ['jquery'], null, true);
});

// Modify the admin screens/functionality
new Admin;

// Set up Timber/Twig
new TimberSetup;

// Set up the WordPress customizer
add_action('customize_register', [new Customizer, 'register']);
add_action('wp_head', [new Customizer, 'registerStyles']);

// Register Carbon Fields blocks and fields
add_action('carbon_fields_register_fields', [new Blocks, 'register']);
add_action('carbon_fields_register_fields', [new Fields, 'register']);

// Register custom post types
add_action('init', [new PostTypes, 'register']);
add_action('after_switch_theme', [new PostTypes, 'rewrite_flush']);

// Merge image sizes from theme with WordPress defaults
add_filter('image_size_names_choose', function($sizes) {
	return array_merge($sizes, [
		'hero' => 'Hero',
	]);
});

// Add SVG to approved media library mime types
add_filter('upload_mimes', function ($mimes) {
	$mimes['svg'] = 'image/svg';
	return $mimes;
});