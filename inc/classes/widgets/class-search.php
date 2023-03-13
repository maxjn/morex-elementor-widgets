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

class Search extends Widget_Base
{


    public function get_name()
    {
        return 'morex-search';
    }

    public function get_title()
    {
        return __('Morex Search Field', 'morex-elementor-widgets');
    }

    public function get_icon()
    {
        return ' morex-widget eicon-search';
    }

    public function get_categories()
    {
        return ['morex'];
    }

    protected function register_controls()
    {

    }

    // front end.
    protected function render()
    {


?>
<div class="box ">
    <form name="search" role="search" method="get" action="<?php echo home_url('/'); ?>">
        <input type="hidden" name="post_type" value="post">
        <input class="input" type="search" name="s" onmouseout="this.value = ''; this.blur();">
    </form>
    <i class="fas fa-search"></i>
</div>
<?php
    }
}
