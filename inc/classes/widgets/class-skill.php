<?php

namespace MOREX_PLUGIN\Inc\Widgets;

use Elementor\Widget_Base;
use Elementor\Icons_Manager;


// Prevent Direct Access
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Have the widget code for the Custom Elementor Morex Heading.
 *
 * @package Morex Widget Plugin
 */

class Skill extends Widget_Base
{


    public function get_name()
    {
        return 'morex-skill';
    }

    public function get_title()
    {
        return __('Morex Skill Bar', 'morex-elementor-widgets');
    }

    public function get_icon()
    {
        return ' morex-widget eicon-skill-bar';
    }

    public function get_categories()
    {
        return ['morex'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        TXT_FIELD($this, 'txt_title', ' متن عنوان اصلی', 'PHP', true);
        NUMBER_FIELD($this, 'number', ' میزان پیشرفت', 60, 100, 5);

        $this->end_controls_section();
    }

    // front end.
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $text_title = $settings['txt_title'];
        $number  = $settings['number'];

?>
<div class="relative mb-7">
    <div class="flex justify-between mb-1">
        <span class="text-lg font-medium text-primary dark:text-white"><?= $text_title ?></span>
        <span
            class="text-xs font-medium text-white bg-accent1 dark:text-white absolute py-1.5 px-1.5 bottom-6 rounded-sm before:absolute before:content-[''] before:bg-accent1 before:w-5 before:h-5 before:clip-polygon before:top-4 ltr:before:left-2 rtl:before:right-2 before:-z-10 ltr:left-[calc(<?= $number ?>%_-_<?= $number == 100 ? '30px' : '20px'; ?>)] rtl:right-[calc(<?= $number ?>%_-_<?= $number == 100 ? '30px' : '20px'; ?>)]"><?= $number ?>%</span>
    </div>
    <div class="w-full bg-gray-200 rounded-full h-[10px] dark:bg-gray-700 flex items-center">
        <div class="bg-accent1 h-[6px] rounded-full mx-[2px]" style="width: <?= $number ?>%">
        </div>
    </div>
</div>
<?php
    }
}
