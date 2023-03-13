<?php

namespace MOREX_PLUGIN\Inc\Widgets;

use Elementor\Widget_Base;

use Elementor\Icons_Manager;
// Prevent Direct Access
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Morex Button Widget
 * @package Morex Widget Plugin
 */

class Service extends Widget_Base
{


    public function get_name()
    {
        return 'morex-service';
    }

    public function get_title()
    {
        return __('Morex Service Box', 'morex-elementor-widgets');
    }

    public function get_icon()
    {
        return ' morex-widget fas fa-tools';
    }

    public function get_categories()
    {
        return ['morex'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        TXT_FIELD($this, 'txt_title', ' عنوان خدمت', '', true);

        TEXTAREA($this, 'txt_description', ' توضیحات خدمت', '', true);

        TXT_FIELD($this, 'btn_title', ' عنوان دکمه', '', true);
        URL_FIELD($this, 'btn_url', ' لینک دکمه');

        ICONS_FIELD($this, 'service_icon', 'آیکون');
        $color = [
            '48CDA0' => 'سبز',
            'ED5F38'  => 'نارنجی',
            '007EFF' => 'آبی',
            'E6BC13'  => 'زرد',
            'ED38D1' => 'صورتی',
            'A348CD'  => 'بنفش'
        ];
        SELECT_FIELD($this, 'box_color', 'رنگ باکس', $color, 'ED5F38');

        $this->end_controls_section();
    }

    // front end.
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $text_title = $settings['txt_title'];
        $text_dsecription = $settings['txt_description'];
        $btn_title = $settings['btn_title'];
        $btn_url = $settings['btn_url']['url'];
        $box_color = $settings['box_color'];


?>
        <div class="shadow-[0_0_50px_0_rgba(196,206,213,0.2)] hover:shadow-[0_0_150px_0_rgba(196,206,213,0.7)]  dark:shadow-[0_0_20px_0_rgba(0,0,0,0.1)] dark:hover:shadow-[0_0_50px_0_rgba(0,0,0,0.2)] hover:translate-y-[-10px] transition duration-500">
            <div class="overflow-hidden px-[30px] xl:px-[40px] lg:pt-[50px] md:pt-[40px] pb-[40px] ">
                <span class="bg-[#<?= $box_color ?>] text-white w-[70px] h-[70px] lg:w-[93px] lg:h-[93px] flex items-center justify-center rounded-full service-shape before:bg-[#<?= $box_color ?>] before:opacity-[0.26]">
                    <?php
                    if (!empty($settings['service_icon'])) {

                        $migration_allowed = Icons_Manager::is_migration_allowed();
                        $migrated          = isset($settings['__fa4_migrated']['service_icon']);
                        $is_new            = !isset($settings['icon']) && $migration_allowed;
                        if (!empty($settings['icon']) || (!empty($settings['service_icon']['value']) && $is_new)) {

                            if ($is_new || $migrated) {
                                Icons_Manager::render_icon($settings['service_icon'], ['aria-hidden' => 'true', 'class' => 'text-[50px]']);
                            } else { ?>
                                <i class="<?php echo esc_attr($settings['icon']); ?> text-[50px]" aria-hidden="true"></i>
                    <?php }
                        }
                    }
                    ?>
                </span>
                <h3 class="text-primary dark:text-white text-[20px] xl:text-[25px] font-bold font-heebo mt-[20px] mb-[15px]">
                    <?= $text_title ?></h3>
                <p class="text-[17px] text-[#636363] dark:text-slate-200"><?= $text_dsecription ?></p>
                <a href="<?= $btn_url ?>" class="link-button text-[#<?= $box_color ?>] before:bg-[#<?= $box_color ?>] mt-[15px] hover:text-[#333] dark:hover:text-white"><?= $btn_title ?></a>
            </div>
        </div>
<?php
    }
}
