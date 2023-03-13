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

class Button_Primary extends Widget_Base
{


    public function get_name()
    {
        return 'morex-button-primary';
    }

    public function get_title()
    {
        return __('Morex Primary Button', 'morex-elementor-widgets');
    }

    public function get_icon()
    {
        return ' morex-widget eicon-download-button';
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

        ICONS_FIELD($this, 'selected_icon', 'آیکون');
        $this->end_controls_section();
    }

    // front end.
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $text_button = $settings['txt_button'];
        $url_button = $settings['url_button'];

?>
<a href="<?= $url_button ?>">
    <button
        class="flex bg-accent1 lg:px-[15px] px-[12px] xl:py-[12px] py-[10px] rounded-[2rem] text-[16px] xl:text-[18px] font-medium text-white items-center transition duration-300 relative after:absolute :after:content-[''] after:bg-primary after:h-full after:w-full after:bottom-0 after:left-0 after:rounded-[2rem] after:trasition after:duration-300 after:opacity-0 hover:after:opacity-[1]">
        <span
            class="icon bg-[#EFEBEB] text-accent1 w-[34px] h-[34px] rounded-full flex items-center justify-center ltr:xl:mr-[15px] ltr:mr-[10px] rtl:xl:ml-[15px] rtl:ml-[10px] relative z-[8] flex-shrink-0">
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
        </span>
        <span class="ltr:xl:pr-[5px] ltr:lg:pr-[5px] rtl:xl:pl-[5px] rtl:lg:pl-[5px] relative z-[8] flex-shrink-0">
            <?= $text_button ?>
        </span>
    </button>
</a>
<?php

    }
}
