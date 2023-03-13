<?php

namespace MOREX_PLUGIN\Inc\Widgets;

use Elementor\Widget_Base;

// Prevent Direct Access
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Have the widget code for the Custom Elementor Morex Heading.
 *
 * @package Morex Widget Plugin
 */

class Heading extends Widget_Base
{


    public function get_name()
    {
        return 'morex-heading';
    }

    public function get_title()
    {
        return __('Morex Heading', 'morex-elementor-widgets');
    }

    public function get_icon()
    {
        return ' morex-widget eicon-editor-h1';
    }

    public function get_categories()
    {
        return ['morex'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        TXT_FIELD($this, 'txt_subtitle', ' متن عنوان فرعی', 'عنوان فرعی', true);
        TXT_FIELD($this, 'txt_title', 'متن عنوان اصلی', 'عنوان اصلی', true);

        HTML_TAG($this, 'html_tag', 'تگ عنوان', 'h2');

        TEXT_ALIGNMENT($this, 'text_alignment', '.morex-heading');

        $this->end_controls_section();
    }

    // front end.
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $text_subtitle = $settings['txt_subtitle'];
        $text_title  = $settings['txt_title'];

        $tt = $settings['html_tag'];

        $font_size = '48';
        switch ($tt) {
            case 'h1':
                $font_size = '50';
                break;
            case 'h2':
                $font_size = '48';
                break;
            case 'h3':
                $font_size = '40';
                break;
            case 'h4':
            case 'h5':
            case 'h6':
                $font_size = '28';
                break;
            case 'strong':
            case 'div':
            case 'p':
            case 'span':
                $font_size = '25';
                break;
        }

        $html = <<<EOD
<span class="morex-heading block text-accent1 text-[20px] lg:text-[24px] font-medium mb-[10px] lg:mb-[5px]">$text_subtitle</span>
                <$tt class=" morex-heading text:[28px] lg:text-[{$font_size}px] font-bold font-heebo leading-[36x] lg:leading-[58px] text-[#000248] dark:text-white">
                $text_title</$tt>
EOD;

        echo $html;
    }
}