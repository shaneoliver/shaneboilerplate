<?php 

namespace ShaneOliver;

/** ------------------------------------------------------
 *	 ADMIN INTERFACE
 *
 * 	 Filters and actions that affect the admin interface
 *	------------------------------------------------------ */

class Admin
{

	protected $settings;

	function __construct()
	{
		if(! is_admin()) {
			return;
		}

        $this->settings = Config::get('settings');

		add_action('wp_dashboard_setup', [$this, 'remove_dashboard_widgets']);
		add_filter('admin_footer_text', [$this, 'modify_admin_footer']);
		add_action('login_head', [$this, 'custom_login_logo']);
		add_action('admin_init', [$this, 'remove_editor_from_templates']);
		add_action('admin_init', [$this, 'add_page_excerpt_support']);
		add_action('admin_menu', [$this, 'override_comments'], 999);
		add_filter('post_mime_types', [$this, 'modify_post_mime_types']);
		add_filter( 'login_headerurl', [$this, 'custom_login_logo_url']);
		add_filter( 'login_headertext', [$this, 'custom_login_title']);
	}

	/**
 	 * hide dashboard clutter
 	*/
	public function remove_dashboard_widgets()
	{
		global $wp_meta_boxes;
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	}

	/**
	 * add developer credit to footer of admin pages
	 */
	public function modify_admin_footer () {
	 	echo sprintf('%s <a href="%s">%s</a>. ', $this->settings['credit']['text'], $this->settings['credit']['link'], $this->settings['credit']['name']);
	 	echo 'Powered by <a href="http://WordPress.org">WordPress</a>.';
	}

	/**
	 * add custom logo in place of wordpress logo on login screen
	 */
	public function custom_login_logo() {
	  echo '<style type="text/css">
	    .login h1 a { background-size:auto; width:100%; height:150px; background-position:center center; background-image:url('.get_bloginfo('template_directory').'/public/images/logos/admin-logo.svg) !important; }
	    </style>';
	}

	function custom_login_logo_url($url) {
		return get_site_url();
	}

	function custom_login_title() { 
		return get_option( 'blogname' ); 
	}

	/**
	 * add excerpt box to pages
	 */
	public function add_page_excerpt_support(){
	   add_post_type_support( 'page', 'excerpt' );
	}

	/**
	 * disable all default comment options
	 */
	public function override_comments() {
		update_option('default_pingback_flag',  0);
		update_option('default_ping_status', 	0);
		update_option('default_comment_status', 0);
	}

	/**
	 * add PDF filter to media manager
	 */
	public function modify_post_mime_types( $post_mime_types ) {
		// select the mime type, here: 'application/pdf'
		// then we define an array with the label values
		$post_mime_types['application/pdf'] = array( __( 'PDFs' ), __( 'Manage PDFs' ), _n_noop( 'PDF <span class="count">(%s)</span>', 'PDFs <span class="count">(%s)</span>' ) );

		// then we return the $post_mime_types variable
		return $post_mime_types;
	}

	public function remove_editor_from_templates() 
	{
		$post_id = $_GET['post'] ?? 0;
		$slug = basename(get_page_template_slug($post_id));

		if(in_array($slug, $this->settings['remove_editor_on_templates'])) {
			remove_post_type_support('page', 'editor');
		}		
	}
}
