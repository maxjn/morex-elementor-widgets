<?php

namespace MOREX_PLUGIN\Inc\Widgets;

use Elementor\Widget_Base;
use Elementor\Icons_Manager;
// Prevent Direct Access
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Social Network Buttons
 *
 * @package Morex Widget Plugin
 */

class Socials extends Widget_Base
{


    public function get_name()
    {
        return 'morex-socials';
    }

    public function get_title()
    {
        return __('Morex Socials', 'morex-elementor-widgets');
    }

    public function get_icon()
    {
        return ' morex-widget eicon-social-icons';
    }

    public function get_categories()
    {
        return ['morex'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        $social = new \Elementor\Repeater();
        URL_FIELD($social, 'link', 'لینک');
        ICONS_FIELD($social, 'selected_icon', 'آیکون');
        $this->add_control(
            'socials',
            [
                'label'       => 'دکمه',
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $social->get_controls(),
                'title_field' => '{{{ elementor.helpers.renderIcon( this, selected_icon, {}, "i", "panel" ) }}}',
            ]
        );

        $this->end_controls_section();
    }

    // front end.
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $socials  = $settings['socials'];

        if (!empty($socials)) {
?>
            <div class="flex items-center">

                <?php
                $i = 0;
                foreach ($socials as $social) {
                    $this->add_link_attributes('link' . $i, $social['link']);
                ?>

                    <a <?php $this->print_render_attribute_string('link' . $i); ?> class="w-[30px] h-[30px] flex items-center justify-center text-accent1 border border-accent1 transition duration-300 hover:bg-accent1 hover:text-white rounded-full <?= $i == 0 ? '' : ' ltr:ml-[10px] rtl:mr-[10px]'; ?>">
                        <?php
                        if (!empty($social['selected_icon'])) {

                            $migration_allowed = Icons_Manager::is_migration_allowed();
                            $migrated          = isset($social['__fa4_migrated']['selected_icon']);
                            $is_new            = !isset($social['icon']) && $migration_allowed;
                            if (!empty($social['icon']) || (!empty($social['selected_icon']['value']) && $is_new)) {

                                if ($is_new || $migrated) {
                                    Icons_Manager::render_icon($social['selected_icon'], ['aria-hidden' => 'true']);
                                } else { ?>
                                    <i class="<?php echo esc_attr($social['icon']); ?>" aria-hidden="true"></i>
                        <?php }
                            }
                        }
                        ?>
                    </a>

                <?php $i++;
                } ?>
            </div>
<?php

        }
    }
}
