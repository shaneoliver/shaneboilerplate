<?php 

return [
    [
        'section_title' => 'Header Styles',
        'section_id' => 'header_styles',
        'priority' => 30,
        'controls' => [
            [
                'id' => 'header_text_color',
                'label' => 'Header Color',
                'default' => '#000000',
                'transport' => 'refresh',
                'type' => 'WP_Customize_Color_Control',
            ],
            [
                'id' => 'header_bg_color',
                'label' => 'Header Background Color',
                'default' => '#000000',
                'transport' => 'refresh',
                'type' => 'WP_Customize_Color_Control',
            ],
            [
                'id' => 'utility_text_color',
                'label' => 'Utility Color',
                'default' => '#FFFFFF',
                'transport' => 'refresh',
                'type' => 'WP_Customize_Color_Control',
            ],
            [
                'id' => 'utility_bg_color',
                'label' => 'Utility Background Color',
                'default' => '#000000',
                'transport' => 'refresh',
                'type' => 'WP_Customize_Color_Control',
            ],
            [
                'id' => 'show_utility_section',
                'label' => 'Show Utility Section',
                'default' => false,
                'transport' => 'refresh',
                'type' => 'checkbox',
                'choices' => [],
            ],
            [
                'id' => 'utility_template',
                'label' => 'Utility Template',
                'default' => 'utility',
                'transport' => 'refresh',
                'type' => 'select',
                'choices' => [
                    'utility' => 'Default',
                    'utility-simple' => 'Simple',
                ]
            ],
            [
                'id' => 'navigation_template',
                'label' => 'Navigation Template',
                'default' => 'navigation-left',
                'transport' => 'refresh',
                'type' => 'select',
                'choices' => [
                    'navigation-right' => 'Right',
                    'navigation-left' => 'Left',
                ]
            ],
        ],
    ],
];