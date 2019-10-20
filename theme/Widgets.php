<?php 

namespace ShaneOliver;

class Widgets
{
    /**
     * Register sidebars
     */
    public function register()
    {
        $settings = Config::get('settings');

        $defaults = [
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ];

        foreach($settings['sidebars'] as $region) {
            foreach($region as $sidebar) {
                register_sidebar($sidebar + $defaults);
            }
        }
    }

    /**
     * Remove unwanted default widgets
     */
    public function unregister()
    {
        unregister_widget('WP_Widget_Pages');
        unregister_widget('WP_Widget_Calendar');
        unregister_widget('WP_Widget_Links');
        unregister_widget('WP_Widget_Meta');
        unregister_widget('WP_Widget_Search');
        unregister_widget('WP_Widget_Categories');
        unregister_widget('WP_Widget_Recent_Posts');
        unregister_widget('WP_Widget_Recent_Comments');
        unregister_widget('WP_Widget_RSS');
        unregister_widget('WP_Widget_Tag_Cloud');
        unregister_widget('WP_Widget_Media_Audio');
        unregister_widget('WP_Widget_Media_Gallery');
        // unregister_widget('WP_Widget_Archives');
        // unregister_widget('WP_Widget_Text');
        // unregister_widget('WP_Widget_Media_Image');
        // unregister_widget('WP_Widget_Media_Video');
        // unregister_widget('WP_Widget_Custom_HTML');
        // unregister_widget('WP_Nav_Menu_Widget');
    }
}
