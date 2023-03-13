<?php

namespace MOREX_PLUGIN\Inc\Widgets;

use Elementor\Widget_Base;

// Prevent Direct Access
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Morex Button Widget
 * @package Morex Widget Plugin
 */

class Button extends Widget_Base
{


    public function get_name()
    {
        return 'morex-button';
    }

    public function get_title()
    {
        return __('Morex Button', 'morex-elementor-widgets');
    }

    public function get_icon()
    {
        return ' morex-widget eicon-button';
    }

    public function get_categories()
    {
        return ['morex'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        TXT_FIELD($this, 'txt_button', ' متن دکمه', '', true);
        URL_FIELD($this, 'url_button', ' لینک دکمه');

        $style = [
            'solid'         => 'تو پر',
            'outline'      => 'تو خالی'
        ];
        SELECT_FIELD($this, 'btn_style', 'استایل دکمه', $style, 'solid');

        $this->end_controls_section();
    }

    // front end.
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $text_button = $settings['txt_button'];
        $url_button = $settings['url_button'];
        $btn_style = $settings['btn_style'];


        $html = <<<EOD
        <a href="{$url_button['url']}" class="btn $btn_style-btn text-accent1 shrink-0">$text_button</a>
EOD;

        echo $html;
    }
}