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

class Counter extends Widget_Base
{


    public function get_name()
    {
        return 'morex-counter-first';
    }

    public function get_title()
    {
        return __('Morex Counter', 'morex-elementor-widgets');
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

        TXT_FIELD($this, 'txt_number', ' متن شمارنده ', '+1100 هزار', true);
        TXT_FIELD($this, 'txt_title', 'متن عنوان ', 'پروژه تکمیل شده ', true);


        ICONS_FIELD($this, 'selected_icon', 'آیکون');


        $this->end_controls_section();
    }

    // front end.
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $txt_number = $settings['txt_number'];
        $txt_title  = $settings['txt_title'];


?>
        <div class="flex items-center absolute bottom-0 right-0 bg-white dark:bg-dark_accent1 rounded-[50px] px-[15px] py-[15px] shadow-[0_0_50px_0_rgba(196,206,213,0.2)] dark:shadow-[0_0_50px_0_rgba(0,0,0,0.2)]">
            <div class="text-accent1 w-[45px] lg:text-[48px] text-[40px]">
                <?php
                if (!empty($settings['selected_icon'])) {

                    $migration_allowed = Icons_Manager::is_migration_allowed();
                    $migrated          = isset($settings['__fa4_migrated']['selected_icon']);
                    $is_new            = !isset($settings['icon']) && $migration_allowed;
                    if (!empty($settings['icon']) || (!empty($settings['selected_icon']['value']) && $is_new)) {

                        if ($is_new || $migrated) {
                            Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
                        } else { ?>
                            <i class="<?php echo esc_attr($settings['icon']); ?>" aria-hidden="true"></i>
                <?php }
                    }
                }
                ?>
            </div>
            <div class="pl-[10px] pr-[15px]">
                <span class="block text-[20px] lg:text-[26px] font-bold text-primary dark:text-white font-heebo leading-[1]"><?= $txt_number ?></span>
                <span class="block text-paragraph dark:text-slate-200 text-[17px]"><?= $txt_title ?></span>
            </div>
        </div>
<?php
    }
}
