<?php 

namespace ShaneOliver;

use Timber\Menu;
use Timber\Timber;

class TimberSetup
{
    protected $settings;

    function __construct()
    {
        $this->settings = Config::get('settings');

        new Timber();
        Timber::$dirname = ['resources/views', 'views'];
        
        add_filter('get_twig', [$this, 'add_to_twig']);
        add_filter('timber_context', [$this, 'add_to_context']);
    }

    public function add_to_twig($twig)
    {   
        return $twig;
    }

    public function add_to_context($context)
    {
        // Register the navigation menus
        foreach ($this->settings['menus'] as $key => $value) {
            if(has_nav_menu($key)) {
                $context['menus'][$key] = new Menu($key, $value['args']);
            }
        }

        foreach ($this->settings['sidebars'] as $region) {
            foreach ($region as $sidebar) {
                if(is_active_sidebar($sidebar['id'])) {
                    $key = str_replace('-', '_', $sidebar['id']);
                    $context[$key] = Timber::get_widgets($sidebar['id']);
                }
            }
        }

        $context['settings'] = $this->settings;
        $context['text_domain'] = $this->settings['text_domain'];
        $context['breadcrumb'] = $this->breadcrumb();

        return $context;
    }

    public function breadcrumb($options = array())
    {
        global $post;
        global $wp_query;

        $posts_page_title = get_the_title( get_option('page_for_posts', true) );
        // parameters
        $defaults = array(
            'wrapper_before'=> '<nav aria-label="breadcrumb" role="navigation"><ol class="breadcrumb">',
            'wrapper_after' => '</ol></nav>',
            'delimiter'     => '',
            'home'          => '<span class="far fa-home"></span>', // text for the 'Home' link
            'before'        => '<li class="breadcrumb-item active" aria-current="page">', // tag before the current crumb
            'after'         => '</li>', // tag after the current crumb
        );
        $args = array_merge($defaults,$options);

        // locals
        $wrapper_before = $args['wrapper_before'];
        $wrapper_after  = $args['wrapper_after'];
        $delimiter      = $args['delimiter'];
        $home           = $args['home'];
        $before         = $args['before'];
        $after          = $args['after'];
        $homeLink       = get_bloginfo('url');
        $isFront        = is_front_page() || is_404();
        $output         = "";

        // the root is always home
        $output .= $wrapper_before;
        $output .=  '<li class="breadcrumb-item"><a class="homelink" href="' . $homeLink . '">' . $home . '</a></li>';

        // sometimes there is more
        if ( !$isFront ) $output .=  $delimiter;

        // home page
        if ( $isFront ) {
            /* nothing further */
        } elseif ( is_single() && !is_attachment() ) {

            // custom post types
            if ( get_post_type() != 'post' ) {
                $post_type = get_post_type_object(get_post_type());
                $slug      = $post_type->rewrite;
                $output .=  '<li class="breadcrumb-item"><a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->name . '</a></li>' . $delimiter;
                $output .=  $before . get_the_title() . $after;
            // standard posts
            } else {
                $output .=  '<li class="breadcrumb-item"><a href="' . get_permalink( get_option('page_for_posts' ) ) . '">' . $posts_page_title . '</a></li>';
                $output .=  $delimiter;
                $output .=  $before . get_the_title() . $after;
            }

        // attachment
        } elseif ( is_attachment() ) {
            $parent = get_post($post->post_parent);
            $cat      = get_the_category($parent->ID);
            if (!empty($cat)) {
                $output .=  get_category_parents($cat[0], TRUE, $delimiter);
            }
            $output .=  '<li class="breadcrumb-item"><a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a></li>';
            $output .=  $delimiter;
            $output .=  $before . get_the_title() . $after;

        // top level pages
        } elseif ( is_page() && !$post->post_parent ) {
            $output .=  $before . get_the_title() . $after;

        // child pages
        } elseif ( is_page() && $post->post_parent ) {
            $parent_id   = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page          = get_page($parent_id);
                $breadcrumbs[] = '<li class="breadcrumb-item"><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
                $parent_id     = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            foreach ($breadcrumbs as $crumb) $output .=  $crumb . $delimiter;
            $output .=  $before . get_the_title() . $after;

        // just the search page
        } elseif ( is_search() ) {
            $output .=  $before . 'Search results for: ' . get_search_query() . ' ';

        // posts page
        } elseif ( is_home() ) {
            $output .=  $before . $posts_page_title;

        // category or tag archvie
        } elseif( is_archive( ) ) {
            // named category / tag / taxonomy
            if($wp_query->queried_object) {
                $output .= $before . $wp_query->queried_object->name . $after;
            } else if($wp_query->is_date){
                $output .= $before . 'Date Archive' . $after;
            }
        }

        if(is_404()) {
            $output .=  $before . '404 Error' . $after;
        }

        // pagination
        $pages = $wp_query->max_num_pages;
        if ( $pages > 1 ) {
            $page = max(get_query_var('paged'), 1);
            $output .=  ' <span class="page-num"> (page ' . $page . ' of ' . $pages . ')</span>' . $after;
        }

        $output .=  $wrapper_after;

        return $output;
    }
}