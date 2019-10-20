<?php

$text_domain = wp_get_theme()->get('TextDomain');

return [
	'version' => '1.0.0',
	'php_version' => '7.1',
	'text_domain' => $text_domain,
	'content_width' => 1200,
	'menus' => [
		'primary' => ['label' => 'Primary', 'args' => ['depth' => -1]],
		'secondary' => ['label' => 'Secondary', 'args' => []],
		'quick_links' => ['label' => 'Quick Links', 'args' => []],
		'footer' => ['label' => 'Footer', 'args' => []],
	],
	'sidebars' => [
		'footer' => [
			[
				'name' => __('Footer Column 1', $text_domain),
				'id' => 'sidebar-footer-1',
				'description' => __('Add widgets here to appear in your footer.', $text_domain),
				'classes' => 'col-12 col-lg-6',
			],
			[
				'name' => __('Footer Column 2', $text_domain),
				'id' => 'sidebar-footer-2',
				'description' => __('Add widgets here to appear in your footer.', $text_domain),
				'classes' => 'col-12 col-md-6 col-lg-3',
			],
			[
				'name' => __('Footer Column 3', $text_domain),
				'id' => 'sidebar-footer-3',
				'description' => __('Add widgets here to appear in your footer.', $text_domain),
				'classes' => 'col-12 col-md-6 col-lg-3',
			],
		]
	],
	'images' => [
		['name' => 'hero', 'width' => 1200, 'height' => 900, 'crop' => true],
		// Force crop on WordPress default image sizes
		['name' => 'large', 'width' => get_option('large_size_w'), 'height' => get_option('large_size_h'), 'crop' => true],
		['name' => 'medium', 'width' => get_option('medium_size_w'), 'height' => get_option('medium_size_h'), 'crop' => true],
	],
	'custom_logo' => [
		'height' => 9999,
		'width' => 9999,
		'flex-width' => true, 
		'flex-height' => true,
		'header-text' => ['site-title', 'site-description'],
	],
	'remove_editor_on_templates' => [],
	'copyright' => sprintf('&copy; %s %s. All rights reserved', date('Y'), get_bloginfo('name')),
	'credit' => [
		'text' => 'Website by',
		'name' => 'Shane Oliver',
		'link' => 'https://www.shaneoliver.com.au',
		'logo' => get_theme_file_uri('/public/images/logos/footer-logo.svg'),
	],
];