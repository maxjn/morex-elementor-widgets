<?php

namespace MOREX_PLUGIN\Inc\Widgets;

use Elementor\Widget_Base;
use MOREX_PLUGIN\Inc\Traits\Query_Builder;
// Prevent Direct Access
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Have the widget code for the Custom Elementor Morex Heading.
 *
 * @package Morex Widget Plugin
 */

class Posts extends Widget_Base
{
    use Query_Builder;

    public function get_name()
    {
        return 'morex-posts';
    }

    public function get_title()
    {
        return __('Morex Posts', 'morex-elementor-widgets');
    }

    public function get_icon()
    {
        return ' morex-widget  eicon-posts-grid';
    }

    public function get_categories()
    {
        return ['morex'];
    }

    protected function register_controls()
    {
        // Query Settings
        $this->QuerySettings();
    }

    // front end.
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $args  = $this->QueryArgBuilder();
        $query = new \WP_Query($args);

?>

<?php
        // The Query
        if ($query->have_posts()) {
        ?>
<div class="grid grid-cols-1 only-md:grid-cols-2 lg:grid-cols-3 gap-[30px]">

    <?php while ($query->have_posts()) : $query->the_post(); ?>
    <!-- single blog  start -->
    <div
        class="blog__card shadow-[0_0_50px_0_rgba(196,206,213,0.2)] hover:shadow-[0_0_100px_0_rgba(196,206,213,0.7)] dark:shadow-[0_0_20px_0_rgba(0,0,0,0.1)] dark:hover:shadow-[0_0_50px_0_rgba(0,0,0,0.2)] transition duration-500">
        <a class="block popup-modal--open" href="#">
            <!-- blog image -->
            <div class="overflow-hidden">
                <span class="block">
                    <?= get_the_post_thumbnail(get_the_ID(), 'post-card', ['calss' => 'blog__thumb w-full transition duration-300']); ?>
                </span>
            </div>
            <!-- blog image end -->

            <!-- blog content -->
            <div class="p-[30px]">
                <div class="mb-[15px]">
                    <?php
                                    foreach ((get_the_category()) as $category) {
                                        $category_name = $category->cat_name;
                                        $cat_id = get_cat_ID($category_name);
                                        $category_link = get_category_link($cat_id);
                                    ?>
                    <span
                        class="bg-accent1_rgb text-[14px] uppercase py-1 px-[6px] text-accent1 dark:text-white dark:bg-accent1 hover:bg-accent1 hover:text-white transition-all duration-300 inline-block">
                        <?= $category_name ?>
                    </span>
                    <?php
                                    }
                                    ?>

                </div>
                <div>
                    <h3 class="text-[25px] leading-7 font-heebo font-bold">
                        <span
                            class="text-primary hover:text-accent1 dark:text-white dark:hover:text-accent1 transition-all duration-300">
                            <?= the_title() ?> </span>
                    </h3>
                    <p class="mt-[15px] text-paragraph dark:text-slate-200 text-[17px]">
                        <?php if (function_exists('morex_the_excerpt')) {
                                            echo morex_the_excerpt(140);
                                        } ?></p>
                </div>
            </div>
            <!-- blog content end -->
        </a>

        <!-- Blog popup start -->
        <div class="modal_portfolio fixed h-screen w-full left-0 top-0 z-[98] opacity-0 invisible">
            <div class="modal_popup_overlay fixed w-full h-full bg-[#000] left-0 top-0 opacity-[0.3]">
            </div>

            <!-- Modal content -->
            <div
                class="modal__portfolio--content relative z-10 h-full flex items-center px-[15px] max-w-[750px] xl:max-w-[800px] mx-auto transition duration-300 translate-y-[-50px]">

                <div
                    class="overflow-y-auto modal__portfolio--content-inner bg-white dark:bg-gray-800  max-h-[60vh] lg:max-h-[80vh] p-8 rounded-2xl relative">
                    <!-- Modal close button -->
                    <button
                        class="modal__popup--close ltr:right-[5px] rtl:left-[5px] top-[5px] absolute w-[50px] h-[50px] bg-accent1 text-white rounded-full flex items-center justify-center transition-all duration-300 hover:bg-primary dark:hover:bg-dark_accent1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                    <!-- Modal close button -->
                    <!-- Modal main content -->
                    <div class="pt-3">
                        <img class="max-w-full h-auto rounded-xl mt-6 mx-auto w-full"
                            src="<?= the_post_thumbnail_url() ?>">
                    </div>
                    <h4 class="text-[25px] lg:text-[32px] leading-7 font-heebo font-bold mt-8">
                        <a href="<?= get_the_permalink() ?>"> <span
                                class="text-primary dark:text-white"><?php the_title() ?></span> </a>
                    </h4>
                    <div class="blog__content mt-5 text-[17px] leading-7 dark:text-slate-300">
                        <?php the_content(); ?>
                    </div>
                    <div class="blog__content mt-5 text-[17px] leading-7 dark:text-slate-300 flex justify-between">
                        <div class="mb-[15px] w-auto">
                            <?php
        if (is_single() || is_archive() || is_front_page()) {
            echo __('published in', 'morex') . human_time_diff(get_the_time('U'), current_time('U')) . ' ' . __('ago', 'morex');
        }
        ?>
                        </div>
                        <div class="mb-[15px] w-auto">
                            <?php
        if (get_the_category()) {
            echo __('Tags: ', 'morex');
        }
        ?>
                            <?php
        foreach ((get_the_category()) as $category) {
            $category_name = $category->cat_name;
            $cat_id = get_cat_ID($category_name);
            $category_link = get_category_link($cat_id);
        ?>
                            <a href="<?= $category_link ?>">
                                <span
                                    class="bg-accent1_rgb text-[14px] uppercase py-1 px-[6px] text-accent1 dark:text-white dark:bg-accent1 hover:bg-accent1 hover:text-white transition-all duration-300 inline-block">
                                    <?= $category_name ?>
                                </span>
                            </a>
                            <?php
        }
        ?>

                        </div>
                    </div>
                    <!-- Blog comment box start -->
                    <?php get_template_part('comments') ?>

                    <!-- Modal main content end -->

                </div>
            </div>
            <!-- Modal content end -->

        </div>
        <!-- Blog popup end -->

    </div>
    <!-- single blog end -->

    <?php endwhile; ?>

</div>

<?php if (function_exists('morex_the_post_pagination')) {
                morex_the_post_pagination($query);
            }
        } ?>

<?php
    }
}
