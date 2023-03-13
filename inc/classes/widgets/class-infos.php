<?php

namespace MOREX_PLUGIN\Inc\Widgets;

use Elementor\Widget_Base;
// Prevent Direct Access
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Infos Elementor Widget
 * @package Morex Widget Plugin
 */

class Infos extends Widget_Base
{


    public function get_name()
    {
        return 'morex-infos';
    }

    public function get_title()
    {
        return __('Morex Infos List', 'morex-elementor-widgets');
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

        $info = new \Elementor\Repeater();
        TXT_FIELD($info, 'text', 'متن اطلاعات', 'نام: علی احمدی');
        $this->add_control(
            'infos',
            [
                'label' => 'اطلاعات',
                'type' =>  \Elementor\Controls_Manager::REPEATER,
                'fields' => $info->get_controls(),
                'title_field' => '{{{ text }}}',
            ]
        );

        $this->end_controls_section();
    }

    // front end.
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $infos = $settings['infos'];

        if (!empty($infos)) {
?>
            <ul class="flex justify-between flex-wrap mt-[18px]">
                <?php
                $i = 0;
                foreach ($infos as $info) {
                ?>

                    <li class="text-paragraph dark:text-slate-200 w-full xs:max-w-[100%]  max-w-[100%] ltr:pl-[18px] rtl:pr-[18px] my-[10px] relative before:absolute before:content-[''] before:bg-accent1 before:w-[6px] before:h-[6px] ltr:before:left-0 rtl:before:right-0 before:top-[8px] before:rounded-full after:absolute after::content-[''] after:w-4 after:h-4 after:border-2 after:border-accent1 ltr:after:left-[-5px] rtl:after:right-[-5px] after:top-[3px] after:border-solid after:rounded-full text-[17px]">
                        <?= $info['text'] ?></li>

                <?php $i++;
                } ?>
            </ul>
<?php

        }
    }
}
