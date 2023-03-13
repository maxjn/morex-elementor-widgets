<?php

/**
 * Bootstraps the plugin.
 *
 * @package Morex Widget Plugin
 */

namespace MOREX_PLUGIN\Inc;

use MOREX_PLUGIN\Inc\Traits\Singleton;

// Prevent Direct Access
if (!defined('ABSPATH')) {
	exit;
}

class MOREX_PLUGIN_INIT
{
	use Singleton;

	protected function __construct()
	{





		// Load class.


		$this->setup_hooks();
	}
	/**
	 * Setup Plugin
	 *
	 * @return void
	 */
	protected function setup_hooks()
	{

		/**
		 * Actions.
		 */
		if (is_plugin_active('elementor/elementor.php')) {
			add_action('elementor/elements/categories_registered', [$this, 'create_new_category']);
			add_action('elementor/widgets/widgets_registered', [$this, 'init_widgets']);
		}
		add_action('elementor/editor/after_enqueue_styles', [$this, 'dashboard_style']);
	}

	/**
	 * Register custom widgets
	 *
	 * @return void
	 */
	public function init_widgets()
	{

		// Require the widget class.
		require_once MOREX_WIDGET . 'class-heading.php';
		require_once MOREX_WIDGET . 'class-paragraph.php';
		require_once MOREX_WIDGET . 'class-button.php';
		require_once MOREX_WIDGET . 'class-button-primary.php';
		require_once MOREX_WIDGET . 'class-socials.php';
		require_once MOREX_WIDGET . 'class-service.php';
		require_once MOREX_WIDGET . 'class-infos.php';
		require_once MOREX_WIDGET . 'class-info2.php';
		require_once MOREX_WIDGET . 'class-resume.php';
		require_once MOREX_WIDGET . 'class-testimonial.php';
		require_once MOREX_WIDGET . 'class-skill.php';
		require_once MOREX_WIDGET . 'class-brands.php';
		require_once MOREX_WIDGET . 'class-image.php';
		require_once MOREX_WIDGET . 'class-counter.php';
		require_once MOREX_WIDGET . 'class-counter2.php';
		require_once MOREX_WIDGET . 'class-search.php';
		require_once MOREX_WIDGET . 'class-portfolio.php';
		require_once MOREX_WIDGET . 'class-posts.php';

		// Register widget with elementor.
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Heading());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Paragraph());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Button());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Button_Primary());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Socials());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Service());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Resume());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Testimonial());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Infos());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Info2());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Skill());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Brands());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Image());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Counter());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Counter2());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Search());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Portfolio());
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Posts());
	}

	/**
	 * Initialize a custom category
	 *
	 * @return void
	 */
	public function create_new_category($elements_manager)
	{

		$elements_manager->add_category(
			'morex',
			[
				'title' => __('Morex', 'morex-elementor-widgets'),
				'icon'  => 'fa fa-plug'
			]
		);
	}
	/**
	 * Gives some custom style to morex-category's elements and panel
	 *
	 * @return void
	 */
	public function dashboard_style()
	{
		wp_enqueue_style(
			'morex-elementor-editor-style',
			MOREX_PLUGIN_CSS_PATH . '/dashboard-style.css',
			array(),
			false
		);
	}
}
