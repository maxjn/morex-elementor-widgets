<?php

namespace MOREX_PLUGIN\Inc\Widgets;

use Elementor\Widget_Base;

use Elementor\Icons_Manager;
// Prevent Direct Access
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Brands Elementor Widget
 * @package Morex Widget Plugin
 */

class Brands extends Widget_Base
{


    public function get_name()
    {
        return 'morex-brands';
    }

    public function get_title()
    {
        return __('Morex Brands', 'morex-elementor-widgets');
    }

    public function get_icon()
    {
        return ' morex-widget  eicon-gallery-grid';
    }

    public function get_categories()
    {
        return ['morex'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        SWITCH_FIELD($this, 'bottom-line', 'نمایش خط زیرین');

        $brand = new \Elementor\Repeater();
        SWITCH_FIELD($brand, 'aside-line', 'نمایش خط کناری');

        IMAGE($brand, 'image-top-light', 'تصویر بالا (روشن)');
        IMAGE($brand, 'image-top-dark', 'تصویر بالا (تیره) ');
        IMAGE($brand, 'image-bottom-light', 'تصویر پایین (روشن) ');
        IMAGE($brand, 'image-bottom-dark', 'تصویر پایین (تیره) ');
        $this->add_control(
            'brands',
            [
                'label' => 'برند',
                'type' =>  \Elementor\Controls_Manager::REPEATER,
                'fields' => $brand->get_controls(),
                'title_field' => 'لوگو برند ',
            ]
        );

        $this->end_controls_section();
    }

    // front end.
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $bottom_line = $settings['bottom-line'];
        $brands = $settings['brands'];

        if (!empty($brands)) {
?>
<div class="relative">
    <?php if ($bottom_line) { ?>
    <div class="w-full absolute h-[1px] bg-[#DDDDDD] top-[50%] translate-y-[-50%] ltr:left-0 rtl:right-0 2xs:hidden">
    </div>
    <?php } ?>
    <div class="flex flex-wrap">
        <?php
                    $counter = 0;
                    foreach ($brands as $logo) {
                        $counter++;
                    ?>
        <div
            class="max-w-[25%] 2xs:max-w-[50%] w-full <?= ($logo['aside-line']) ? 'ltr:border-r-[1px] rtl:border-l-[1px]' : ''; ?> border-[#DDDDDD] dark:border-dark_accent1 client__logo--padding">
            <?php
                            $light_logo_top = false;
                            $dark_logo_top = false;

                            if (!empty($logo['image-top-light'])) {
                                $light_logo_top = true;
                                set_error_handler(function () {
                                }, E_WARNING);
                                try {
                                    $light_url_top = esc_url(wp_get_attachment_image_src($logo['image-top-light']['id'])[0]);
                                } catch (\Throwable $e) {
                                    $light_url_top = '';
                                }
                                //restore the previous error handler
                                restore_error_handler();
                            }
                            if (!empty($logo['image-top-dark'])) {
                                $dark_logo_top = true;
                                set_error_handler(function () {
                                }, E_WARNING);
                                try {
                                    $dark_url_top = esc_url(wp_get_attachment_image_src($logo['image-top-dark']['id'])[0]);
                                } catch (\Throwable $e) {
                                    $dark_url_top  = '';
                                }
                                //restore the previous error handler
                                restore_error_handler();
                            }
                            if ($light_logo_top || $dark_logo_top) {
                                echo '<div
                            class="w-full client__logo--padding--inner 2xs:border-b-[1px] 2xs:border-[#DDDDDD] dark:2xs:border-dark_accent1">';

                                if (!empty(trim($dark_url_top)) && !empty(trim($light_url_top))) {
                                    echo '<img class="mx-auto opacity-[0.7] hover:opacity-[1] transition duration-300 dark:hidden"
                                src="' . $light_url_top . '" alt="' . esc_attr__('Logo', 'morex-elementor-widgets') . '">';
                                    echo '<img class="mx-auto grayscale hover:grayscale-0 transition duration-300 dark:block hidden"
                                src="' . $dark_url_top . '" alt="' . esc_attr__('Logo', 'morex-elementor-widgets') . '">';
                                } else {
                                    echo '<img src="' . ($light_logo_top ? $light_url_top : $dark_url_top) . '" alt="' . esc_attr__('Logo', 'morex-elementor-widgets') . '">';
                                }

                                echo '</div>';
                            }

                            $light_logo_bottom = false;
                            $dark_logo_bottom = false;

                            if (!empty($logo['image-bottom-light'])) {
                                $light_logo_bottom = true;

                                set_error_handler(function () {
                                }, E_WARNING);
                                try {
                                    $light_url_bottom = esc_url(wp_get_attachment_image_src($logo['image-bottom-light']['id'])[0]);
                                } catch (\Throwable $e) {
                                    $light_url_bottom  = '';
                                }
                                //restore the previous error handler
                                restore_error_handler();
                            }
                            if (!empty($logo['image-bottom-light'])) {
                                $dark_logo_bottom = true;
                                set_error_handler(function () {
                                }, E_WARNING);
                                try {
                                    $dark_url_bottom = esc_url(wp_get_attachment_image_src($logo['image-bottom-dark']['id'])[0]);
                                } catch (\Throwable $e) {
                                    $dark_url_bottom  = '';
                                }
                                //restore the previous error handler
                                restore_error_handler();
                            }
                            if ($light_logo_bottom || $dark_logo_bottom) {
                                echo '<div
                            class="w-full client__logo--padding--inner 2xs:border-b-[1px] 2xs:border-[#DDDDDD] dark:2xs:border-dark_accent1">';

                                if (!empty(trim($light_url_bottom)) && !empty(trim($dark_url_bottom))) {
                                    echo '<img class="mx-auto opacity-[0.7] hover:opacity-[1] transition duration-300 dark:hidden"
                                src="' . $light_url_bottom . '" alt="' . esc_attr__('Logo', 'morex-elementor-widgets') . '">';
                                    echo '<img class="mx-auto grayscale hover:grayscale-0 transition duration-300 dark:block hidden"
                                src="' . $dark_url_bottom . '" alt="' . esc_attr__('Logo', 'morex-elementor-widgets') . '">';
                                } else {
                                    echo '<img src="' . ($light_logo_bottom ? $light_url_bottom : $dark_url_bottom) . '" alt="' . esc_attr__('Logo', 'morex') . '">';
                                }

                                echo '</div>';
                            }
                            ?>



        </div>
        <?php } ?>
    </div>
</div>
<?php

        }
    }
}
