<?php

namespace ShaneOliver;

use Timber\Theme;
use Timber\Timber;

class Customizer
{
    protected $customize;

    protected $text_domain;

    public function __construct($text_domain = null)
    {
        $this->theme = new Theme;
        $this->text_domain = $text_domain ?? wp_get_theme()->get('TextDomain');
        $this->theme_mods = Config::get('theme_mods');
    }

    /**
     * Register the customizer controls
     */
    public function register($wp_customize)
    {
        $this->customize = $wp_customize;

        $types = ['text', 'checkbox', 'radio', 'select', 'textarea', 'dropdown-pages', 'email', 'url', 'number', 'hidden', 'date'];

        foreach ($this->theme_mods as $setting) {
            $this->customize->add_section($setting['section_id'], [
                'title'      => __($setting['section_title'], $this->text_domain),
                'priority'   => $setting['priority'],
            ]);

            foreach ($setting['controls'] as $control) {
                $this->customize->add_setting($control['id'], [
                    'default'   => $control['default'],
                    'transport' => $control['transport'],
                ]);

                if(in_array($control['type'], $types)) {
                    $this->customize->add_control($control['id'], [
                        'label'      => __($control['label'], $this->text_domain),
                        'section'    => $setting['section_id'],
                        'settings'   => $control['id'],
                        'type'       => $control['type'],
                        'choices' => $control['choices']
                    ]);
                } else {
                    $this->customize->add_control(new $control['type']($this->customize, $control['id'], [
                        'label'      => __($control['label'], $this->text_domain),
                        'section'    => $setting['section_id'],
                        'settings'   => $control['id'],
                    ]));
                }
            }
        }
    }

    /**
     * Register the styles and render the twig template
     */
    public function registerStyles()
    {
        $vars = [];

        foreach($this->theme_mods as $section) {
            foreach($section['controls'] as $control) {
                $vars[$control['id']] = $this->theme->theme_mod($control['id'], $control['default']);
            }
        }

        Timber::render('customizer.html.twig', $vars);
    }
}
