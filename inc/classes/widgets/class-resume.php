<?php

namespace MOREX_PLUGIN\Inc\Widgets;

use Elementor\Widget_Base;

use Elementor\Icons_Manager;
// Prevent Direct Access
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Infos Elementor Widget
 * @package Morex Widget Plugin
 */

class Resume extends Widget_Base
{


    public function get_name()
    {
        return 'morex-resume';
    }

    public function get_title()
    {
        return __('Morex Resume', 'morex-elementor-widgets');
    }

    public function get_icon()
    {
        return ' morex-widget  eicon-document-file';
    }

    public function get_categories()
    {
        return ['morex'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('settings', ['label' => 'تنظیمات']);

        SWITCH_FIELD($this, 'long-line', 'جداکننده بلند');

        $resume = new \Elementor\Repeater();
        TXT_FIELD($resume, 'title', 'عنوان اصلی', 'طراحی وب');
        TXT_FIELD($resume, 'subtitle', 'عنوان فرعی', 'دانشگاه صنعتی');
        TEXTAREA($resume, 'description', 'توضیحات', 'متن نمونه توضیحات');
        TXT_FIELD($resume, 'year', 'سال', '1401-1402');
        ICONS_FIELD($resume, 'selected_icon', 'آیکون');
        $this->add_control(
            'resumes',
            [
                'label' => 'رزومه',
                'type' =>  \Elementor\Controls_Manager::REPEATER,
                'fields' => $resume->get_controls(),
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();
    }

    // front end.
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $resumes = $settings['resumes'];
        $long_line = $settings['long-line'];

        if (!empty($resumes)) {
?>
            <div class="w-full max-w-full sm:max-w-full flex-grow">
                <div class="relative ltr:pl-[30px] rtl:pr-[30px]">
                    <?php if ($long_line) { ?>
                        <!-- border line -->
                        <div class="absolute w-[1px] ltr:left-0 rtl:right-0 top-[10px] bottom-[5px] bg-accent1">
                        </div>
                        <!-- border line  end-->
                    <?php } ?>

                    <?php
                    $i = 0;
                    foreach ($resumes as $resume) {
                    ?>
                        <!-- Single resume start -->
                        <div class="flex ltr:pr-[50px] ltr:sm:pr-[0] ltr:lg:pr-[70px rtl:pl-[50px] rtl:sm:pl-[0] rtl:lg:pl-[70px relative <?= $i != 0 ? 'mt-[40px]' : ''; ?>  ">
                            <?php if ($long_line) { ?>
                                <span class="absolute w-[20px] h-[20px] ltr:left-[-40px] rtl:right-[-40px] top-[10px] bg-accent1 rounded-full z-10 before:absolute before:bg-white before:w-[16px] before:h-[16px] before:rounded-full ltr:before:left-[2px] rtl:before:right-[2px] before:top-[2px]"></span>
                            <?php } ?>
                            <div class="w-[70px] h-[70px]">
                                <span class="w-[50px] h-[50px] bg-accent1 text-[25px] text-white flex items-center rounded-full justify-center">
                                    <?php
                                    if (!empty($resume['selected_icon'])) {

                                        $migration_allowed = Icons_Manager::is_migration_allowed();
                                        $migrated          = isset($resume['__fa4_migrated']['selected_icon']);
                                        $is_new            = !isset($resume['icon']) && $migration_allowed;
                                        if (!empty($resume['icon']) || (!empty($resume['selected_icon']['value']) && $is_new)) {

                                            if ($is_new || $migrated) {
                                                Icons_Manager::render_icon($resume['selected_icon'], ['aria-hidden' => 'true']);
                                            } else { ?>
                                                <i class="<?php echo esc_attr($resume['icon']); ?>" aria-hidden="true"></i>
                                    <?php }
                                        }
                                    }
                                    ?>
                                </span>
                            </div>
                            <div class="flex-grow ltr:pl-[15px] rtl:pr-[15px]">
                                <div class="flex items-center only-md:flex-col only-md:items-start 2xs:flex-col 2xs:items-start">
                                    <h3 class="font-heebo 2xs:text-[18px] text-[20px] lg:text-[25px] text-primary dark:text-white">
                                        <?= $resume['title'] ?></h3>
                                    <?php if (!empty($resume['subtitle'])) { ?>
                                        <span class="bg-accent1 text-white text-[13px] rounded-[30px] px-[15px] py-[5px] uppercase ltr:ml-[15px] rtl:mr-[15px] ltr:only-md:ml-0 only-md:my-[5px] ltr:2xs:ml-0 rtl:only-md:m-0 rtl:2xs:mr-0 2xs:my-[5px] text-center"><?= $resume['subtitle'] ?></span>
                                    <?php } ?>
                                </div>
                                <?php if (!empty($resume['description'])) { ?>
                                    <p class="text-paragraph dark:text-slate-200 mt-[10px] text-[17px]">
                                        <?= $resume['description'] ?> </p>
                                <?php } ?>
                                <?php if (!empty($resume['year'])) { ?>
                                    <span class="text-[17px] font-medium text-accent1 relative ltr:pl-[20px] rtl:pr-[20px] before:absolute before:bg-accent1 before:w-[7px] before:h-[7px] ltr:before:left-0 rtl:before:right-0 before:top-[50%] before:translate-y-[-50%] mt-[20px] block"><?= $resume['year'] ?></span>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- Single resume end -->

                    <?php $i++;
                    } ?>


                </div>
            </div>
<?php

        }
    }
}
