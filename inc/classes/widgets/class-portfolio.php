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

class Portfolio extends Widget_Base
{


    public function get_name()
    {
        return 'morex-portfolio';
    }

    public function get_title()
    {
        return __('Morex Portfolio Filter', 'morex-elementor-widgets');
    }

    public function get_icon()
    {
        return ' morex-widget eicon-gallery-grid';
    }

    public function get_categories()
    {
        return ['morex'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        NUMBER_FIELD($this, 'number', ' تعداد قابل نمایش', 3, 15, 3, 9);

        $this->end_controls_section();
    }

    // front end.
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $number  = $settings['number'];
        if (post_type_exists('portfolio')) {
            $arg = [
                'show_option_all'    => '',
                'show_option_none'   => __('No categories'),
                'orderby'            => 'count',
                'order'              => 'DESC',
                'style'              => 'none',
                'show_count'         => 1,
                'hide_empty'         => 1,
                'use_desc_for_title' => 1,
                'number'             => 8,
                'echo'               => 1,
                'taxonomy'           => isset($args['taxonomy']) ? $args['taxonomy'] : 'portfolio_category',
                'walker'             => 'Walker_Category',
                'hide_title_if_empty' => false,
            ];
            $taxonomies = get_terms($arg);

            // WP_Query argument For all the portfolio posts
            $per_page = $number ? $number : 9;

            $args = array(
                'post_type'              => array('portfolio'), // use any for any kind of post type, custom post type slug for custom post type
                'post_status'            => array('publish'), // Also support: pending, draft, auto-draft, future, private, inherit, trash, any
                'posts_per_page'         => $per_page, // use -1 for all post
                'order'                  => 'DESC', // Also support: ASC
                'orderby'                => 'date', // Also support: none, rand, id, title, slug, modified, parent, menu_order, comment_count

            );

            $query = new \WP_Query($args);

            /**
             * Portfolio Section Template
             *
             * @package Morex
             */
?>

            <!-- Filter portfolio start -->
            <div class="isotope--filter">
                <div class="button-group filters-button-group flex justify-center flex-wrap gap-[30px]">
                    <button class="button is-checked text-primary dark:text-white text-[18px] capitalize font-medium hover:text-accent1 dark:hover:text-accent1 transition duration-300" data-filter="*">نمایش همه</button>
                    <?php
                    foreach ($taxonomies as $taxonomy) {
                    ?>
                        <button class="button text-primary dark:text-white text-[18px] capitalize font-medium hover:text-accent1 dark:hover:text-accent1 transition duration-300" data-filter=".<?= $taxonomy->slug   ?>"><?= $taxonomy->name   ?></button>
                    <?php } ?>
                </div>
                <div class="portfolio__grid flex mt-[50px] mx-[-15px]">
                    <?php
                    // The Query
                    if ($query->have_posts()) {
                        while ($query->have_posts()) : $query->the_post();
                            $categories = get_the_terms(get_the_ID(), 'portfolio_category'); //arry of term objects
                    ?>
                            <!-- single portfolio start -->
                            <div class="element-item mb-[30px] w-[50%] lg:w-[33.33%]  px-[15px] <?php foreach ($categories as $category) {
                                                                                                    echo ' ' . $category->slug;
                                                                                                } //end foreach
                                                                                                ?> portfolio__parent" data-category="<?php foreach ($categories as $category) {
                                                                                                                                            echo ' ' . $category->slug;
                                                                                                                                        } //end foreach
                                                                                                                                        ?>">
                                <div class="relative overflow-hidden">
                                    <a href="#" class="popup-modal--open">
                                        <span class="absolute w-full h-full bg-accent1 left-0 top-0 opacity-0 transition duration-300 portfolio__overlay z-10">
                                            <div class="flex items-center justify-end flex-col text-center h-full text-white p-[20px]">
                                                <span class="portfolio--zoom flex items-center grow transition-all duration-300 translate-y-[-20px]">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize">
                                                        <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3">
                                                        </path>
                                                    </svg>
                                                </span>
                                                <h3 class="portfolio--title text-[18px] lg:text-[24px] font-heebo transition-all duration-300 translate-y-3">
                                                    <?= the_title() ?></h3>
                                                <span class="portfolio--sub-title text-[17px] 2xs:hidden transition-all duration-500 translate-y-3">
                                                    <?= morex_the_excerpt(60) ?></span>
                                            </div>
                                        </span>
                                        <div class="w-full portfolio__image--card">
                                            <?= get_the_post_thumbnail(get_the_ID(), 'portfolio-card', ['class' => 'w-full transition duration-300']) ?>
                                        </div>
                                    </a>
                                    <!-- Portfolio popup start -->
                                    <div class="modal_portfolio fixed h-screen w-full left-0 top-0 z-[98] opacity-0 invisible">
                                        <div class="modal_popup_overlay fixed w-full h-full bg-[#000] left-0 top-0 opacity-[0.3]">
                                        </div>
                                        <!-- Modal content -->
                                        <div class="modal__portfolio--content relative z-10 h-full flex items-center px-[15px] max-w-[750px] xl:max-w-[800px] mx-auto transition duration-300 translate-y-[-50px]">
                                            <div class="overflow-y-auto modal__portfolio--content-inner bg-white dark:bg-gray-800  max-h-[60vh] lg:max-h-[80vh] p-8 rounded-2xl relative">
                                                <button class="modal__popup--close ltr:right-[10px] rtl:left-[10px] top-[10px] absolute w-[50px] h-[50px] bg-accent1 hover:bg-primary dark:hover:bg-dark_accent1 text-white rounded-full flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                    </svg>
                                                </button>
                                                <h2 class="text-accent1 text-center font-bold">
                                                    <?= the_title(); ?>
                                                </h2>
                                                <?= the_content(); ?>

                                                <div class="pr-3">
                                                    <?= get_the_post_thumbnail(get_the_ID(), 'portfolio-single', ['class' => 'max-w-full h-auto rounded-xl mt-6 mx-auto']) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Portfolio popup end -->
                                </div>
                            </div>
                            <!-- single portfolio end -->

                    <?php endwhile;
                    } ?>
                    <!-- Pagination Start -->

                </div>
            </div>
            <!-- Filter portfolio end -->
<?php
        }
    }
}
