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

class Info2 extends Widget_Base
{


    public function get_name()
    {
        return 'morex-info2';
    }

    public function get_title()
    {
        return __('Morex Info2', 'morex-elementor-widgets');
    }

    public function get_icon()
    {
        return ' morex-widget eicon-editor-list-ul';
    }

    public function get_categories()
    {
        return ['morex'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        TXT_FIELD($this, 'txt_title', ' متن عنوان اصلی', 'تلفن', true);
        TEXTAREA($this, 'txt_info', 'متن اطلاعات', '09211112233', true);
        ICONS_FIELD($this, 'selected_icon', 'آیکون');

        $this->end_controls_section();
    }

    // front end.
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $text_title = $settings['txt_title'];
        $text_info  = $settings['txt_info'];

?>
        <div class="flex items-center  ">
            <div class=" w-[50px] h-[50px] lg:w-[70px] lg:h-[70px] bg-accent1 text-white flex items-center rounded-full justify-center text-[40px]">
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
            <div class="ltr:pl-6 rtl:pr-6">
                <h3 class="text-[28px] md:text-[22px] font-heebo font-bold text-primary dark:text-white">
                    <?= $text_title ?> </h3>
                <span class="text-primary  dark:text-slate-200 text-[22px] md:text-[18px] mt-5">
                    <?= $text_info ?>
                </span>
            </div>
        </div>
<?php
    }
}
