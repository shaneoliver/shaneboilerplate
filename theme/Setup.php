<?php 

namespace ShaneOliver;

use Whoops\Run as Whoops;
use Carbon_Fields\Carbon_Fields;
use Whoops\Handler\PrettyPageHandler;

class Setup  
{
    protected $settings;

    protected $gutenberg; 

    public function __construct()
    {
        $this->settings = Config::get('settings');
        $this->gutenberg = Config::get('gutenberg');

        /**
         * Check PHP version
         */
        if (version_compare(PHP_VERSION, $this->settings['php_version'], '<=') ) {
            wp_die(sprintf('Whoops! PHP %s or greater is required. You are currently using %s', $this->settings['php_version'], PHP_VERSION));
        };

        /**
         * Register Whoops error handling library
         */
        if(defined('WP_DEBUG') && WP_DEBUG && ! is_admin()) {
            $whoops = new Whoops;
            $whoops->pushHandler(new PrettyPageHandler);
            $whoops->register();
        }
    }

    /**
     * Initialise theme setup
     */
    public function init()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Twenty Nineteen, use a find and replace
         * to change $this->settings['text_domain'] to the name of your theme in all the template files.
         */
        load_theme_textdomain( $this->settings['text_domain'], get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size( $this->settings['content_width'], 9999 );
        $GLOBALS['content_width'] = $this->settings['content_width'];

        foreach($this->settings['images'] as $image) {
            add_image_size($image['name'], $image['width'], $image['height'], $image['crop']);
        }

        /**
         * Register navigation menus
         * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
         */
        $menusToRegister = [];
        foreach ($this->settings['menus'] as $key => $value) {
            $menusToRegister[$key] = __($value['label'], $this->settings['text_domain']);
        }
        register_nav_menus($menusToRegister);

        /**
         * Enable HTML5 markup support
         * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
         */
        add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);
        
        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support('custom-logo', $this->settings['custom_logo']);

        // Add theme support for selective refresh for widgets.
        add_theme_support( 'customize-selective-refresh-widgets' );

        // Add support for Block Styles.
        add_theme_support( 'wp-block-styles' );

        // Add support for full and wide align images.
        add_theme_support( 'align-wide' );

        // Add support for editor styles.
        add_theme_support( 'editor-styles' );

        // Enqueue editor styles.
        add_editor_style( 'style-editor.css' );

        // Add custom editor font sizes.
        add_theme_support('editor-font-sizes', $this->gutenberg['font_sizes']);

        // Editor color palette.
        add_theme_support('editor-color-palette', $this->gutenberg['colors']);
        
        // Disabled the color picker
        add_theme_support('disable-custom-colors');

        // Add support for responsive embedded content.
        add_theme_support('responsive-embeds');

        Carbon_Fields::boot();
    }
}
