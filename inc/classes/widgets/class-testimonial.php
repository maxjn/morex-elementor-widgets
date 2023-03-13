<?php

namespace MOREX_PLUGIN\Inc\Widgets;

use Elementor\Widget_Base;

use Elementor\Icons_Manager;
// Prevent Direct Access
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Testimonial Elementor Widget
 * @package Morex Widget Plugin
 */

class Testimonial extends Widget_Base
{


    public function get_name()
    {
        return 'morex-testimonial';
    }

    public function get_title()
    {
        return __('Morex Testimonial', 'morex-elementor-widgets');
    }

    public function get_icon()
    {
        return ' morex-widget  eicon-testimonial-carousel';
    }

    public function get_categories()
    {
        return ['morex'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        SWITCH_FIELD($this, 'long-line', 'جداکننده بلند');

        $testimonial = new \Elementor\Repeater();
        TXT_FIELD($testimonial, 'name', 'نام', 'علی احمدی');
        TXT_FIELD($testimonial, 'position', 'موقعیت شغلی', 'طراح وب');
        TEXTAREA($testimonial, 'comment', 'متن دیدگاه', 'متن نمونه توضیحات');
        IMAGE($testimonial, 'image', 'تصویر ');
        NUMBER_FIELD($testimonial, 'star', 'تعداد ستاره', 0, 5, 1, 5);
        $this->add_control(
            'testimonials',
            [
                'label' => 'رزومه',
                'type' =>  \Elementor\Controls_Manager::REPEATER,
                'fields' => $testimonial->get_controls(),
                'title_field' => '{{{ name }}}',
            ]
        );

        $this->end_controls_section();
    }

    // front end.
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $testimonials = $settings['testimonials'];

        if (!empty($testimonials)) {
?>
            <div class="testimonial__slider--inner lg:px-[220px] relative">
                <!-- Slider main container -->
                <div class="swiper testimonial__slider">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        <?php
                        // Theme_mod First Culomn testimonials to check.
                        $i = 0;
                        foreach ($testimonials as $testimonial) :
                        ?>
                            <!-- Single slide -->
                            <div class="swiper-slide">
                                <div class="slider__inner text-center">
                                    <div class="client__rating flex justify-center gap-[5px]">
                                        <?php for ($j = 0; $j < 5; $j++) {  ?>
                                            <li class="fa fa-star<?= $j < $testimonial['star'] ? '' : '-o'; ?> fill-[#ffce31] stroke-[#ffce31] text-[#E6BC13]">
                                            </li>
                                        <?php
                                        } ?>
                                    </div>
                                    <div class="text-[24px] leading-8 text-paragraph dark:text-slate-200 italic mt-[20px] mb-[30px]">
                                        <?= $testimonial['comment'] ?>
                                    </div>
                                    <div>
                                        <img class="mx-auto w-[130px] h-[130px] rounded-full shadow-[0_0_50px_0_rgba(196,206,213,0.2)]" src="<?= esc_url(wp_get_attachment_image_src($testimonial['image']['id'])[0]) ?>" alt="">
                                        <div class="mt-[25px]">
                                            <h3 class="text-2xl text-primary dark:text-white"><?= $testimonial['name'] ?></h3>
                                            <span class="dark:text-slate-100"><?= $testimonial['position'] ?></span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- Single slide -->

                    <?php
                            $i++;
                        endforeach;
                    } ?>


                    </div>
                    <!-- If we need pagination -->
                    <div class="swiper-pagination mt-7"></div>
                </div>
                <div class="md:hidden">
                    <span class="absolute top-[38%] translate-y-[-50%] left-0 xl:left-[-12%] only-xl:left-[0]  text-accent1">
                        <svg class="w-full only-lg:max-w-[130px] only-xl:max-w-[150px] xl:max-w-[250px] opacity-30" fill="currentColor" stroke="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path d="M0 216C0 149.7 53.7 96 120 96h8c17.7 0 32 14.3 32 32s-14.3 32-32 32h-8c-30.9 0-56 25.1-56 56v8h64c35.3 0 64 28.7 64 64v64c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V320 288 216zm256 0c0-66.3 53.7-120 120-120h8c17.7 0 32 14.3 32 32s-14.3 32-32 32h-8c-30.9 0-56 25.1-56 56v8h64c35.3 0 64 28.7 64 64v64c0 35.3-28.7 64-64 64H320c-35.3 0-64-28.7-64-64V320 288 216z" />
                        </svg>
                    </span>
                    <span class="absolute top-[38%] translate-y-[-50%] right-0 xl:right-[-12%] only-xl:right-[0] text-accent1">
                        <svg class="w-full only-lg:max-w-[130px] only-xl:max-w-[150px] xl:max-w-[250px] opacity-30" fill="currentColor" stroke="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path d="M448 296c0 66.3-53.7 120-120 120h-8c-17.7 0-32-14.3-32-32s14.3-32 32-32h8c30.9 0 56-25.1 56-56v-8H320c-35.3 0-64-28.7-64-64V160c0-35.3 28.7-64 64-64h64c35.3 0 64 28.7 64 64v32 32 72zm-256 0c0 66.3-53.7 120-120 120H64c-17.7 0-32-14.3-32-32s14.3-32 32-32h8c30.9 0 56-25.1 56-56v-8H64c-35.3 0-64-28.7-64-64V160c0-35.3 28.7-64 64-64h64c35.3 0 64 28.7 64 64v32 32 72z" />
                        </svg>
                    </span>
                </div>
            </div>
    <?php

    }
}
