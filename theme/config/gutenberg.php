<?php 

$text_domain = wp_get_theme()->get('TextDomain');

return [
    'font_sizes' => [
        [
            'name'      => __('Small', $text_domain),
            'shortName' => __('S', $text_domain),
            'size'      => 12,
            'slug'      => 'small',
        ],
        [
            'name'      => __('Normal', $text_domain),
            'shortName' => __('N', $text_domain),
            'size'      => 16,
            'slug'      => 'normal',
        ],
        [
            'name'      => __('Large', $text_domain),
            'shortName' => __('L', $text_domain),
            'size'      => 20,
            'slug'      => 'large',
        ],
    ],

    'colors' => [
        [
            'name'  => __('Primary', $text_domain),
            'slug'  => 'primary',
            'color' => '#333333',
        ],
        [
            'name'  => __('Secondary', $text_domain),
            'slug'  => 'secondary',
            'color' => '#ff4422',
        ],
    ],
];