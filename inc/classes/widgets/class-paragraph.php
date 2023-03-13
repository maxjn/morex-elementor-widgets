<?php

namespace MOREX_PLUGIN\Inc\Widgets;

use Elementor\Widget_Base;

// Prevent Direct Access
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Morex Paragraph Widget
 *
 * @package Morex Widget Plugin
 */

class Paragraph extends Widget_Base
{


    public function get_name()
    {
        return 'morex-paragraph';
    }

    public function get_title()
    {
        return __('Morex Paragraph', 'morex-elementor-widgets');
    }

    public function get_icon()
    {
        return ' morex-widget eicon-text';
    }

    public function get_categories()
    {
        return ['morex'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        TEXTAREA($this, 'txt_paragraph', ' متن عنوان فرعی', '', true);

        TEXT_ALIGNMENT($this, 'text_alignment', '.morex-paragraph');

        $this->end_controls_section();
    }

    // front end.
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $text_paragraph = $settings['txt_paragraph'];



        $html = <<<EOD
        <p class="morex-paragraph text-[#636363] text-[17px] leading-[28px]  w-full dark:text-slate-200">
        $text_paragraph</p>
EOD;

        echo $html;
    }
}
