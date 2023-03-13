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

class Counter2 extends Widget_Base
{


    public function get_name()
    {
        return 'morex-counter-second';
    }

    public function get_title()
    {
        return __('Morex Counter2', 'morex-elementor-widgets');
    }

    public function get_icon()
    {
        return ' morex-widget eicon-number-field';
    }

    public function get_categories()
    {
        return ['morex'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        TXT_FIELD($this, 'txt_number', ' متن شمارنده ', '+27', true);
        TXT_FIELD($this, 'txt_title', 'متن عنوان ', 'سال تجربه کاری', true);


        TEXT_ALIGNMENT($this, 'text_alignment', '.elementor-widget-container');

        $this->end_controls_section();
    }

    // front end.
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $txt_number = $settings['txt_number'];
        $txt_title  = $settings['txt_title'];


?>
        <h4 class="font-heebo text-[50px] lg:text-[80px] font-bold leading-[1] text-white title-stroke">
            <?= $txt_number ?></h4>
        <span class="font-bold sm:text-[20px] only-md:text-[24px] lg:text-[30px] font-heebo text-primary dark:text-white"><?= $txt_title ?></span>

<?php
    }
}
