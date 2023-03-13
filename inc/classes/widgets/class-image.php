<?php

namespace MOREX_PLUGIN\Inc\Widgets;

use Elementor\Widget_Base;

// Prevent Direct Access
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Brands Elementor Widget
 * @package Morex Widget Plugin
 */

class Image extends Widget_Base
{


    public function get_name()
    {
        return 'morex-image';
    }

    public function get_title()
    {
        return __('Morex Image', 'morex-elementor-widgets');
    }

    public function get_icon()
    {
        return ' morex-widget   eicon-image';
    }

    public function get_categories()
    {
        return ['morex'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        IMAGE($this, 'image-light', 'تصویر اصلی (روشن)');
        IMAGE($this, 'image-dark', 'تصویر اصلی (تیره) ');
        IMAGE($this, 'floating-image-right', 'تصویر شناور راست ');
        IMAGE($this, 'floating-image-left', ' تصویر شناور چپ ');



        $this->end_controls_section();
    }

    // front end.
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $image_light = $settings['image-light'];
        $image_dark = $settings['image-dark'];
        $floating_image_right = $settings['floating-image-right'];
        $floating_image_left = $settings['floating-image-left'];
?>
        <!-- Image Container Start -->

        <div class="lg:max-w-full sm:max-w-full xs:max-w-full only-md:max-w-full flex justify-end">
            <?php
            $light_image = false;
            $dark_image = false;

            if (!empty($image_light)) {
                $light_image = true;
                set_error_handler(function () {
                }, E_WARNING);
                try {
                    $light_url = esc_url(wp_get_attachment_image_src($settings['image-light']['id'])[0]);
                } catch (\Throwable $e) {
                    $light_url = '';
                }
                //restore the previous error handler
                restore_error_handler();
            }
            if (!empty($image_dark)) {
                $dark_image = true;
                set_error_handler(function () {
                }, E_WARNING);
                try {
                    $dark_url = esc_url(wp_get_attachment_image_src($settings['image-dark']['id'])[0]);
                } catch (\Throwable $e) {
                }
                //restore the previous error handler
                restore_error_handler();
            }

            if ($light_image || $dark_image) {

            ?>
                <div class="relative only-xl:max-w-[70%]">
                    <?php

                    if (!empty(trim($light_url)) && !empty(trim($dark_url))) {
                        echo '<img class="hidden dark:block" src="' . $dark_url . '" alt="">';
                        echo '<img class="dark:hidden" src="' . $light_url . '" alt="">';
                    } else {
                        echo '<img src="' . ($light_image ? $light_url : $dark_url) . '" alt="">';
                    }

                    if (!empty($floating_image_right)) {


                        set_error_handler(function () {
                        }, E_WARNING);

                        try {
                            $icon1_url = esc_url(wp_get_attachment_image_src($settings['floating-image-right']['id'])[0]);
                        } catch (\Throwable $e) {
                            $icon1_url = '';
                        }

                        //restore the previous error handler
                        restore_error_handler();

                    ?>
                        <span class="absolute top-[100px] lg:top-[210px] right-[-20px] only-md:right-[-10px] only-xl:max-w-[65px] lg:max-w-[80px] xl:max-w-[105px] sm:max-w-[50px] only-md:max-w-[70px] animateUpDown"><img src="<?= $icon1_url ?>" alt=""></span>
                    <?php
                    }
                    if (!empty($floating_image_left)) {
                        set_error_handler(function () {
                        }, E_WARNING);
                        try {
                            $icon2_url = esc_url(wp_get_attachment_image_src($settings['floating-image-left']['id'])[0]);
                        } catch (\Throwable $e) {
                            $icon2_url = '';
                        }
                        //restore the previous error handler
                        restore_error_handler();
                    ?>
                        <span class="absolute top-[80px] left-[-40px] md:left-[-10px] only-xl:max-w-[65px] lg:max-w-[80px] xl:max-w-[105px] sm:max-w-[50px] only-md:max-w-[70px] animateUpDown"><img src="<?= $icon2_url ?>" alt=""></span>
                    <?php }
                    ?>

                </div>
            <?php
            }
            ?>
        </div>
        <!-- Image Container End -->
<?php
    }
}
