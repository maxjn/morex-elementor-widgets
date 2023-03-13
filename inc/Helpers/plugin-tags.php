<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Utils;

// Prevent Direct Access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Custom plugin tags for the plugin.
 * Elementor Controls
 *
 * @package Morex
 */


function getImageById(int $id, $size = 'thumbnail')
{
    $src = get_template_directory_uri() . '/assets/images/no-image.jpg';

    if (!empty(wp_get_attachment_image_src($id))) {
        $src = wp_get_attachment_image_src($id, $size)[0];
    }

    return $src;
}

function getAttachmentById($id = '')
{
    if (!empty($id)) {
        return wp_get_attachment_url($id);
    }

    return null;
}

function getPostType(int $post_id = 0)
{
    if ($post_id === 0) {
        $postID = get_the_ID();
    } else {
        $postID = $post_id;
    }

    if (get_post_type($postID) === 'post') {
        return !empty(get_post_meta($postID, '_post_type', true)) ?
            get_post_meta($postID, '_post_type', true) : 'music';
    }

    return get_post_type($postID);
}

function TXT_FIELD($widget, string $id, string $title, string $default = '', $dynamic = false, $condition = false, $condition_value = '')
{
    $control_args = [
        'label'       => $title,
        'type'        => Controls_Manager::TEXT,
        'label_block' => true,
        'dynamic'     => [
            'active' => $dynamic,
        ],
        'default'     => $default
    ];

    if ($condition !== false) {
        $control_args['condition'] = [
            $condition => $condition_value
        ];
    }

    $widget->add_control(
        $id,
        $control_args
    );
}

function URL_FIELD($widget, string $id, string $title, $dynamic = false, $condition = false, $condition_value = '')
{
    $control_args = [
        'label'       => $title,
        'type'        => Controls_Manager::URL,
        'label_block' => true,
        'dynamic'     => [
            'active' => $dynamic,
        ],
        'placeholder' => 'https://your-link.com',
        'default'     => [
            'url' => '#',
        ],
    ];

    if ($condition !== false) {
        $control_args['condition'] = [
            $condition => $condition_value
        ];
    }

    $widget->add_control(
        $id,
        $control_args
    );
}

function NUMBER_FIELD($widget, string $id, string $title, $min = 0, $max = 100, $step = 1, $default = 5, $dynamic = false, $condition = false, $condition_value = '')
{
    $control_args = [
        'label'       => $title,
        'type'        => Controls_Manager::NUMBER,
        'label_block' => false,
        'min'         => $min,
        'max'         => $max,
        'step'        => $step,
        'default'     => $default,
        'dynamic'     => [
            'active' => $dynamic,
        ],
    ];

    if ($condition !== false) {
        $control_args['condition'] = [
            $condition => $condition_value
        ];
    }

    $widget->add_control(
        $id,
        $control_args
    );
}

function TEXTAREA($widget, string $id, string $title, string $default = '', $dynamic = false, $condition = false, $condition_value = '')
{
    $control_args = [
        'label'       => $title,
        'type'        => Controls_Manager::TEXTAREA,
        'rows'        => 7,
        'label_block' => true,
        'dynamic'     => [
            'active' => $dynamic,
        ],
        'default'     => $default
    ];

    if ($condition !== false) {
        $control_args['condition'] = [
            $condition => $condition_value
        ];
    }

    $widget->add_control(
        $id,
        $control_args
    );
}

function SWITCH_FIELD($widget, string $id, string $title, string $default = '', bool $label_block = false, $condition = false, $condition_value = null)
{
    $control_args = [
        'label'        => $title,
        'type'         => Controls_Manager::SWITCHER,
        'label_block'  => $label_block,
        'label_on'     => 'بله',
        'label_off'    => 'خیر',
        'return_value' => 'yes',
        'default'      => $default
    ];

    if ($condition !== false) {
        $control_args['condition'] = [
            $condition => $condition_value
        ];
    }

    $widget->add_control(
        $id,
        $control_args
    );
}

function SELECT_FIELD($widget, string $id, string $title, array $options, string $default, $condition = false, $condition_value = null)
{
    $control_args = [
        'label'       => $title,
        'type'        => Controls_Manager::SELECT,
        'label_block' => false,
        'options'     => $options,
        'default'     => $default
    ];

    if ($condition !== false) {
        $control_args['condition'] = [
            $condition => $condition_value
        ];
    }

    $widget->add_control(
        $id,
        $control_args
    );
}

function MULTIPLE_SELECT_FIELD($widget, string $id, string $title, array $options, array $default, $condition = false, $condition_value = null)
{
    $control_args = [
        'label'       => $title,
        'type'        => Controls_Manager::SELECT2,
        'label_block' => false,
        'options'     => $options,
        'default'     => $default,
        'multiple'    => true,
        'sortable'    => true
    ];

    if ($condition !== false) {
        $control_args['condition'] = [
            $condition => $condition_value
        ];
    }

    $widget->add_control(
        $id,
        $control_args
    );
}

function SLIDER_FIELD_STYLE($widget, string $id, string $title, int $min, int $max, $default, string $class, string $selector, $condition = false, $condition_value = null)
{
    $control_args = [
        'label'       => $title,
        'type'        => Controls_Manager::SLIDER,
        'label_block' => true,
        'size_units'  => ['px', '%'],
        'range'       => [
            'px' => [
                'min' => $min,
                'max' => $max,
            ],
            '%'  => [
                'min' => 0,
                'max' => 100,
            ],
        ],
        'default'     => [
            'size' => $default
        ],
        'selectors'   => [
            '{{WRAPPER}} ' . $class => $selector . ': {{SIZE}}{{UNIT}};',
        ],
    ];

    if ($condition !== false) {
        $control_args['condition'] = [
            $condition => $condition_value
        ];
    }

    $widget->add_responsive_control(
        $id,
        $control_args
    );
}

function SLIDER_FIELD_PIX_STYLE($widget, string $id, string $title, int $min, int $max, $default, string $target, string $selector, $condition = false, $condition_value = '')
{
    $control_args = [
        'label'       => $title,
        'type'        => Controls_Manager::SLIDER,
        'label_block' => true,
        'size_units'  => ['px'],
        'range'       => [
            'px' => [
                'min' => $min,
                'max' => $max,
            ],
        ],
        'default'     => [
            'size' => $default
        ],
        'selectors'   => [
            '{{WRAPPER}} ' . $target => $selector . ': {{SIZE}}{{UNIT}};',
        ],
    ];

    if ($condition !== false) {
        $control_args['condition'] = [
            $condition => $condition_value
        ];
    }

    $widget->add_responsive_control(
        $id,
        $control_args
    );
}

function SLIDER_FIELD_PERCENT_STYLE($widget, string $id, string $title, int $min, int $max, $default, string $target, string $selector, $condition = false, $condition_value = '')
{
    $control_args = [
        'label'       => $title,
        'type'        => Controls_Manager::SLIDER,
        'label_block' => true,
        'size_units'  => ['%'],
        'range'       => [
            '%' => [
                'min' => $min,
                'max' => $max,
            ],
        ],
        'default'     => [
            'size' => $default
        ],
        'selectors'   => [
            '{{WRAPPER}} ' . $target => $selector . ': {{SIZE}}%;',
        ],
    ];

    if ($condition !== false) {
        $control_args['condition'] = [
            $condition => $condition_value
        ];
    }

    $widget->add_responsive_control(
        $id,
        $control_args
    );
}

function DIMENSIONS_FIELD($widget, string $id, string $title, string $class, string $style_selector, $condition = false, $condition_value = '')
{
    $control_args = [
        'label'     => $title,
        'type'      => \Elementor\Controls_Manager::DIMENSIONS,
        'selectors' => [
            '{{WRAPPER}} ' . $class => $style_selector .
                ': {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px',
        ]
    ];

    if ($condition !== false) {
        $control_args['condition'] = [
            $condition => $condition_value
        ];
    }

    $widget->add_responsive_control(
        $id,
        $control_args
    );
}

function COLOR_FIELD($widget, string $id, string $title, string $default, string $class, string $style_selector, $condition = false, $condition_value = '')
{
    $control_args = [
        'label'       => $title,
        'label_block' => false,
        'type'        => \Elementor\Controls_Manager::COLOR,
        'default'     => $default,
        'selectors'   => [
            '{{WRAPPER}} ' . $class => $style_selector . ': {{VALUE}};',
        ]
    ];

    if ($condition !== false) {
        $control_args['condition'] = [
            $condition => $condition_value
        ];
    }

    $widget->add_control(
        $id,
        $control_args
    );
}

function FONT_FIELD($widget, string $id, string $title, string $target, $condition = false, $condition_value = '')
{
    $control_args = [
        'name'       => $id,
        'label'      => $title,
        'show_label' => true,
        'selector'   => '{{WRAPPER}} ' . $target,
    ];

    if ($condition !== false) {
        $control_args['condition'] = [
            $condition => $condition_value
        ];
    }

    $widget->add_group_control(
        Group_Control_Typography::get_type(),
        $control_args
    );
}

function FONT_STROKE_FIELD($widget, string $id, string $target, $condition = false, $condition_value = '')
{
    $control_args = [
        'name'     => $id,
        'selector' => '{{WRAPPER}} ' . $target,
    ];

    if ($condition !== false) {
        $control_args['condition'] = [
            $condition => $condition_value
        ];
    }

    $widget->add_group_control(
        Group_Control_Text_Stroke::get_type(),
        $control_args
    );
}

function BORDER_FIELD($widget, string $id, string $title, string $target, $condition = false, $condition_value = '')
{
    $control_args = [
        'name'       => $id,
        'label'      => $title,
        'show_label' => true,
        'selector'   => '{{WRAPPER}} ' . $target,
    ];

    if ($condition !== false) {
        $control_args['condition'] = [
            $condition => $condition_value
        ];
    }

    $widget->add_group_control(
        Group_Control_Border::get_type(),
        $control_args
    );
}

function SHADOW_FIELD($widget, string $id, string $title, string $target, bool $condition = false, $condition_value = '')
{

    $control_args = [
        'name'       => $id,
        'label'      => $title,
        'show_label' => true,
        'selector'   => '{{WRAPPER}} ' . $target,
    ];

    if ($condition !== false) {
        $control_args['condition'] = [
            $condition => $condition_value
        ];
    }

    return $widget->add_group_control(
        Group_Control_Box_Shadow::get_type(),
        $control_args
    );
}

function BACKGROUND_FIELD($widget, string $id, string $target, bool $condition = false, $condition_value = '')
{

    $control_args = [
        'name'     => $id,
        'selector' => '{{WRAPPER}} ' . $target,
    ];

    if ($condition !== false) {
        $control_args['condition'] = [
            $condition => $condition_value
        ];
    }

    $widget->add_group_control(
        Group_Control_Background::get_type(),
        $control_args
    );
}

function BACKGROUND_WO_IMG_FIELD($widget, string $id, string $target, bool $condition = false, $condition_value = '')
{

    $control_args = [
        'name'     => $id,
        'selector' => '{{WRAPPER}} ' . $target,
        'exclude'  => [
            'image'
        ]
    ];

    if ($condition !== false) {
        $control_args['condition'] = [
            $condition => $condition_value
        ];
    }

    $widget->add_group_control(
        Group_Control_Background::get_type(),
        $control_args
    );
}

function ICON($widget, string $id, $default = 'fas fa-star')
{
    $widget->add_control(
        $id . 'icon_type',
        [
            'label'   => 'نوع آیکون',
            'type'    => Controls_Manager::CHOOSE,
            'toggle'  => false,
            'default' => 'icon',
            'options' => [
                'icon'  => [
                    'title' => 'آیکون',
                    'icon'  => $default
                ],
                'image' => [
                    'title' => 'عکس',
                    'icon'  => 'far fa-image'
                ],
            ]
        ]
    );
    $widget->add_control(
        $id . 'selected_icon',
        [
            'label'            => 'آیکون',
            'type'             => Controls_Manager::ICONS,
            'fa4compatibility' => 'icon',
            'default'          => [
                'value'   => $default,
                'library' => 'fa-solid',
            ],
            'condition'        => [
                $id . 'icon_type' => 'icon',
            ],
            'label_block'      => false,
            'skin'             => 'inline'
        ]
    );
    $widget->add_control(
        $id . 'image',
        [
            'label'     => 'عکس',
            'type'      => Controls_Manager::MEDIA,
            'default'   => [
                'url' => Utils::get_placeholder_image_src(),
            ],
            'condition' => [
                $id . 'icon_type' => 'image',
            ]
        ]
    );
    $widget->add_control(
        $id . 'image_alt',
        [
            'label'     => 'متن جایگزین تصویر',
            'type'      => Controls_Manager::TEXT,
            'default'   => 'متن جایگزین تصویر',
            'condition' => [
                $id . 'icon_type' => 'image',
            ]
        ]
    );
}

function ICON_PRINT($widget, $settings, $icon_id)
{
    $migrated = isset($settings['__fa4_migrated'][$icon_id . 'selected_icon']);
    $is_new   =
        empty($settings[$icon_id . 'icon']) && Icons_Manager::is_migration_allowed();

    if ('icon' == $settings[$icon_id . 'icon_type']) {
        if (!empty($settings[$icon_id . 'icon_type'])) {
            echo '<div class="nader-icon dfx jcc aic">';
        }

        if ($is_new || $migrated) {
            Icons_Manager::render_icon(
                $settings[$icon_id . 'selected_icon'],
                ['aria-hidden' => 'true']
            );
        } else {
            echo '<i ' . $widget->get_render_attribute_string('font-icon') . '></i>';
        }

        if (!empty($settings[$icon_id . 'icon_type'])) {
            echo '</div>';
        }
    } elseif ('image' == $settings[$icon_id . 'icon_type']) {
        echo '<div class="nader-icon dfx jcc aic">';
        echo '<img src="' . $settings[$icon_id . 'image']['url'] . '" alt="' .
            $settings[$icon_id . 'image_alt'] . '">';
        echo '</div>';
    }
}

function ICONS_FIELD($widget, string $id, string $title, string $default = 'fas fa-star', $condition = false, $condition_value = '')
{
    if (!$condition) {
        $widget->add_control(
            $id,
            [
                'label'            => $title,
                'type'             => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'          => [
                    'value'   => $default,
                    'library' => 'fa-solid',
                ],
                'label_block'      => false,
                'skin'             => 'inline'
            ]
        );
    } else {
        $widget->add_control(
            $id,
            [
                'label'            => $title,
                'type'             => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'          => [
                    'value'   => $default,
                    'library' => 'fa-solid',
                ],
                'label_block'      => false,
                'skin'             => 'inline',
                'condition'        => [
                    $condition => $condition_value
                ]
            ]
        );
    }
}

function IMAGE($widget, string $id, string $title, $dynamic = true, $condition = false, $condition_value = '')
{
    if (!$condition) {
        $widget->add_control(
            $id,
            [
                'label'   => $title,
                'type'    => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
                    'active' => $dynamic,
                ],
            ]
        );
    } else {
        $widget->add_control(
            $id,
            [
                'label'     => $title,
                'type'      => \Elementor\Controls_Manager::MEDIA,
                'default'   => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    $condition => $condition_value
                ]
            ]
        );
    }
}

function IMAGE_SIZE($widget, string $id, string $def = 'large', $condition = false, $condition_value = '')
{
    if (!$condition) {
        $widget->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => $id,
                // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
                'default'   => $def,
                'separator' => 'none',
                'exclude'   => ['custom']
            ]
        );
    } else {
        $widget->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => $id,
                // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
                'default'   => $def,
                'separator' => 'none',
                'exclude'   => ['custom'],
                'condition' => [
                    $condition => $condition_value
                ]
            ]
        );
    }
}

function IMAGE_DIMENSION($widget, string $id, $condition = false, $condition_value = '')
{
    if (!$condition) {
        $widget->add_control(
            $id,
            [
                'label' => $id,
                'type'  => \Elementor\Controls_Manager::IMAGE_DIMENSIONS,
            ]
        );
    } else {
        $widget->add_control(
            $id,
            [
                'label'     => $id,
                'type'      => \Elementor\Controls_Manager::IMAGE_DIMENSIONS,
                'condition' => [
                    $condition => $condition_value
                ]
            ]
        );
    }
}

function HEADING_FIELD($widget, string $id, string $title)
{
    return $widget->add_control(
        $id,
        [
            'label'       => $title,
            'label_block' => true,
            'type'        => \Elementor\Controls_Manager::HEADING,
        ]
    );
}

function TEXT_ALIGNMENT($widget, string $id, string $target, $condition = false, $condition_value = '')
{
    if (!$condition) {
        $widget->add_responsive_control(
            $id,
            [
                'label'     => 'تراز متن',
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'    => [
                        'title' => 'چپ',
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'  => [
                        'title' => 'وسط',
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'   => [
                        'title' => 'راست',
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => 'هم تراز',
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $target => 'text-align: {{VALUE}};',
                ],
            ]
        );
    } else {
        $widget->add_responsive_control(
            $id,
            [
                'label'     => 'تراز متن',
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'    => [
                        'title' => 'چپ',
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'  => [
                        'title' => 'وسط',
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'   => [
                        'title' => 'راست',
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => 'هم تراز',
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $target => 'text-align: {{VALUE}};',
                ],
                'condition' => [
                    $condition => $condition_value
                ]
            ]
        );
    }
}

function SCROLLER($widget, string $id, string $target)
{
    SLIDER_FIELD_STYLE(
        $widget,
        $id . 'scroller_width',
        'عرض نوار اسکرول',
        2,
        10,
        4,
        $target . '::-webkit-scrollbar',
        'width'
    );
    COLOR_FIELD(
        $widget,
        $id . 'scroller_tracker_bg',
        'رنگ ریل نوار اسکرول',
        '',
        $target . '::-webkit-scrollbar-track',
        'background'
    );
    COLOR_FIELD(
        $widget,
        $id . 'scroller_bg',
        'رنگ نوار اسکرول',
        '#161616',
        $target . '::-webkit-scrollbar-thumb',
        'background'
    );
    COLOR_FIELD(
        $widget,
        $id . 'scroller_bg_hover',
        'رنگ هاور نوار اسکرول',
        '#333333',
        $target . '::-webkit-scrollbar-thumb:hover',
        'background'
    );
}

function HTML_TAG($widget, string $id, string $title, string $default = 'h3', $condition = false, $condition_value = '')
{
    if (!$condition) {
        $widget->add_control(
            $id,
            [
                'label'       => 'تگ HTML ' . $title,
                'type'        => Controls_Manager::SELECT,
                'label_block' => false,
                'options'     => [
                    'h1'     => 'h1',
                    'h2'     => 'h2',
                    'h3'     => 'h3',
                    'h4'     => 'h4',
                    'h5'     => 'h5',
                    'h6'     => 'h6',
                    'span'   => 'span',
                    'strong' => 'strong',
                    'div'    => 'div',
                    'p'      => 'p',
                ],
                'default'     => $default
            ]
        );
    } else {
        $widget->add_control(
            $id,
            [
                'label'       => 'تگ HTML ' . $title,
                'type'        => Controls_Manager::SELECT,
                'label_block' => false,
                'options'     => [
                    'h1'     => 'h1',
                    'h2'     => 'h2',
                    'h3'     => 'h3',
                    'h4'     => 'h4',
                    'h5'     => 'h5',
                    'h6'     => 'h6',
                    'span'   => 'span',
                    'strong' => 'strong',
                    'div'    => 'div',
                    'p'      => 'p',
                ],
                'default'     => $default,
                'condition'   => [
                    $condition => $condition_value
                ]
            ]
        );
    }
}

function H_ALIGNMENT($widget, string $id, string $target)
{
    $widget->add_responsive_control(
        $id,
        [
            'label'       => 'ترازبندی افقی',
            'type'        => Controls_Manager::SELECT,
            'label_block' => false,
            'options'     => [
                'flex-start'    => 'آغاز',
                'center'        => 'وسط',
                'flex-end'      => 'پایان',
                'space-between' => 'فاصله بینابینی',
                'space-around'  => 'فاصله اطراف',
                'space-evenly'  => 'فاصله یکنواخت',
            ],
            'default'     => 'flex-start',
            'selectors'   => [
                '{{WRAPPER}} ' . $target => 'justify-content: {{VALUE}}'
            ]
        ]
    );
}

function V_ALIGNMENT($widget, string $id, string $target)
{
    $widget->add_responsive_control(
        $id,
        [
            'label'       => 'ترازبندی عمودی',
            'type'        => Controls_Manager::SELECT,
            'label_block' => false,
            'options'     => [
                'flex-start' => 'آغاز',
                'center'     => 'وسط',
                'flex-end'   => 'پایان',
            ],
            'default'     => 'flex-start',
            'selectors'   => [
                '{{WRAPPER}} ' . $target => 'align-items: {{VALUE}}'
            ]
        ]
    );
}

function grid_columns($widget, string $id, string $target)
{
    $widget->add_responsive_control(
        $id,
        [
            'label'       => 'تعداد ستونها',
            'type'        => Controls_Manager::SELECT,
            'label_block' => false,
            'options'     => [
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
                6 => 6,
                7 => 7,
                8 => 8,
            ],
            'default'     => 1,
            'selectors'   => [
                '{{WRAPPER}} ' . $target => 'grid-template-columns: repeat({{VALUE}}, 1fr)'
            ]
        ]
    );
}

function DIVIDER_FIELD($widget, $id)
{
    $widget->add_control($id, ['type' => Controls_Manager::DIVIDER]);
}


function TAB_START($widget, $id)
{
    $widget->start_controls_tabs($id . '_tab');
    $widget->start_controls_tab($id . '_tab_normal', ['label' => 'حالت عادی']);
}

function TAB_MIDDLE($widget, $id, $active = false)
{
    if ($active) {
        $widget->end_controls_tab();
        $widget->start_controls_tab($id . '_tab_active', ['label' => 'حالت فعال']);
    } else {
        $widget->end_controls_tab();
        $widget->start_controls_tab($id . '_tab_hover', ['label' => 'حالت هاور']);
    }
}

function TAB_MIDDLE_($widget, $id, $title)
{
    $widget->end_controls_tab();
    $widget->start_controls_tab($id, ['label' => $title]);
}

function TAB_END($widget)
{
    $widget->end_controls_tab();
    $widget->end_controls_tabs();
}

function Separator($widget, string $id, string $title)
{
    DIVIDER_FIELD($widget, $id . '_divider_d1');
    HEADING_FIELD($widget, $id . '_divider_heading', $title);
    DIVIDER_FIELD($widget, $id . '_divider_d2');
}

function BoxUtils($widget, string $id, string $target, string $parent_target = '', bool $active = false, bool $parent_active = false, bool $font = false)
{
    if ($font) {
        FONT_FIELD(
            $widget,
            $id . '_font_settings',
            'تایپوگرافی',
            $parent_target . $target
        );
    }

    DIMENSIONS_FIELD(
        $widget,
        $id . '_margin',
        'فاصله بیرونی',
        $parent_target . $target,
        'margin'
    );
    DIMENSIONS_FIELD(
        $widget,
        $id . '_padding',
        'فاصله درونی',
        $parent_target . $target,
        'padding'
    );

    $widget->start_controls_tabs($id . '-tab');
    $widget->start_controls_tab($id . '-tab-normal', ['label' => 'حالت عادی']);

    COLOR_FIELD($widget, $id . '_color', 'رنگ', '', $parent_target . $target, 'color');
    BACKGROUND_FIELD($widget, $id . '_bg', $parent_target . $target);
    BORDER_FIELD($widget, $id . '_border', 'حاشیه', $parent_target . $target);
    DIMENSIONS_FIELD(
        $widget,
        $id . '_border_radius',
        'گردی حاشیه',
        $parent_target . $target,
        'border-radius'
    );
    SHADOW_FIELD($widget, $id . '_shadow', 'سایه', $parent_target . $target);

    $widget->end_controls_tab();
    $widget->start_controls_tab($id . '-tab-hover', ['label' => 'حالت هاور']);

    if (!empty($parent_target)) {
        $parent_target = str_replace(' ', '', $parent_target);

        COLOR_FIELD(
            $widget,
            $id . '_color_hover',
            'رنگ',
            '',
            $parent_target . ':hover ' . $target,
            'color'
        );
        BACKGROUND_FIELD(
            $widget,
            $id . '_bg_hover',
            $parent_target . ':hover ' . $target
        );
        BORDER_FIELD(
            $widget,
            $id . '_border_hover',
            'حاشیه',
            $parent_target . ':hover ' . $target
        );
        DIMENSIONS_FIELD(
            $widget,
            $id . '_border_radius_hover',
            'گردی حاشیه',
            $parent_target . ':hover ' . $target,
            'border-radius'
        );
        SHADOW_FIELD(
            $widget,
            $id . '_shadow_hover',
            'سایه',
            $parent_target . ':hover ' . $target
        );
    } else {
        COLOR_FIELD(
            $widget,
            $id . '_color_hover',
            'رنگ',
            '',
            $target . ':hover',
            'color'
        );
        BACKGROUND_FIELD($widget, $id . '_bg_hover', $target . ':hover');
        BORDER_FIELD($widget, $id . '_border_hover', 'حاشیه', $target . ':hover');
        DIMENSIONS_FIELD(
            $widget,
            $id . '_border_radius_hover',
            'گردی حاشیه',
            $target . ':hover',
            'border-radius'
        );
        SHADOW_FIELD($widget, $id . '_shadow_hover', 'سایه', $target . ':hover');
    }

    $widget->end_controls_tab();

    if ($active && !$parent_active) {
        $widget->start_controls_tab($id . '-tab-active', ['label' => 'حالت فعال']);

        COLOR_FIELD(
            $widget,
            $id . '_color_active',
            'رنگ',
            '',
            $parent_target . $target . '.active',
            'color'
        );
        BACKGROUND_FIELD(
            $widget,
            $id . '_bg_active',
            $parent_target . $target . '.active'
        );
        BORDER_FIELD(
            $widget,
            $id . '_border_active',
            'حاشیه',
            $parent_target . $target . '.active'
        );
        DIMENSIONS_FIELD(
            $widget,
            $id . '_border_radius_active',
            'گردی حاشیه',
            $parent_target . $target . '.active',
            'border-radius'
        );
        SHADOW_FIELD(
            $widget,
            $id . '_shadow_active',
            'سایه',
            $parent_target . $target . '.active'
        );

        $widget->end_controls_tab();
    }

    if ($parent_active && !$active) {
        $widget->start_controls_tab($id . '-tab-active', ['label' => 'حالت فعال']);

        COLOR_FIELD(
            $widget,
            $id . '_color_active',
            'رنگ',
            '',
            $parent_target . '.active ' . $target,
            'color'
        );
        BACKGROUND_FIELD(
            $widget,
            $id . '_bg_active',
            $parent_target . '.active ' . $target
        );
        BORDER_FIELD(
            $widget,
            $id . '_border_active',
            'حاشیه',
            $parent_target . '.active ' . $target
        );
        DIMENSIONS_FIELD(
            $widget,
            $id . '_border_radius_active',
            'گردی حاشیه',
            $parent_target . '.active ' . $target,
            'border-radius'
        );
        SHADOW_FIELD(
            $widget,
            $id . '_shadow_active',
            'سایه',
            $parent_target . '.active ' . $target
        );

        $widget->end_controls_tab();
    }

    $widget->end_controls_tabs();
}

function ButtonUtils($widget, string $id, string $target, string $parent_target = '', bool $active = false, bool $parent_active = false)
{
    SLIDER_FIELD_STYLE(
        $widget,
        $id . '_width',
        'عرض',
        20,
        200,
        40,
        $parent_target . $target,
        'width'
    );
    SLIDER_FIELD_STYLE(
        $widget,
        $id . '_height',
        ' ارتفاع',
        20,
        100,
        40,
        $parent_target . $target,
        'height'
    );
    FONT_FIELD($widget, $id . '_font_settings', 'فونت', $parent_target . $target);

    DIMENSIONS_FIELD(
        $widget,
        $id . '_margin',
        'فاصله بیرونی',
        $parent_target . $target,
        'margin'
    );

    $widget->start_controls_tabs($id . '-tab');
    $widget->start_controls_tab($id . '-tab-normal', ['label' => 'حالت عادی']);

    COLOR_FIELD($widget, $id . '_color', 'رنگ', '', $parent_target . $target, 'color');
    BACKGROUND_FIELD($widget, $id . '_bg', $parent_target . $target);
    BORDER_FIELD($widget, $id . '_border', 'حاشیه', $parent_target . $target);
    DIMENSIONS_FIELD(
        $widget,
        $id . '_border_radius',
        'گردی حاشیه',
        $parent_target . $target,
        'border-radius'
    );
    SHADOW_FIELD($widget, $id . '_shadow', 'سایه', $parent_target . $target);

    $widget->end_controls_tab();
    $widget->start_controls_tab($id . '-tab-hover', ['label' => 'حالت هاور']);

    if (!empty($parent_target)) {
        $parent_target = str_replace(' ', '', $parent_target);

        COLOR_FIELD(
            $widget,
            $id . '_color_hover',
            'رنگ',
            '',
            $parent_target . ':hover ' . $target,
            'color'
        );
        BACKGROUND_FIELD(
            $widget,
            $id . '_bg_hover',
            $parent_target . ':hover ' . $target
        );
        BORDER_FIELD(
            $widget,
            $id . '_border_hover',
            'حاشیه',
            $parent_target . ':hover ' . $target
        );
        DIMENSIONS_FIELD(
            $widget,
            $id . '_border_radius_hover',
            'گردی حاشیه',
            $parent_target . ':hover ' . $target,
            'border-radius'
        );
        SHADOW_FIELD(
            $widget,
            $id . '_shadow_hover',
            'سایه',
            $parent_target . ':hover ' . $target
        );
    } else {
        COLOR_FIELD(
            $widget,
            $id . '_color_hover',
            'رنگ',
            '',
            $target . ':hover',
            'color'
        );
        BACKGROUND_FIELD($widget, $id . '_bg_hover', $target . ':hover');
        BORDER_FIELD($widget, $id . '_border_hover', 'حاشیه', $target . ':hover');
        DIMENSIONS_FIELD(
            $widget,
            $id . '_border_radius_hover',
            'گردی حاشیه',
            $target . ':hover',
            'border-radius'
        );
        SHADOW_FIELD($widget, $id . '_shadow_hover', 'سایه', $target . ':hover');
    }

    $widget->end_controls_tab();

    if ($active && !$parent_active) {
        $widget->start_controls_tab($id . '-tab-active', ['label' => 'حالت فعال']);

        COLOR_FIELD(
            $widget,
            $id . '_color_active',
            'رنگ',
            '',
            $parent_target . $target . '.active',
            'color'
        );
        BACKGROUND_FIELD(
            $widget,
            $id . '_bg_active',
            $parent_target . $target . '.active'
        );
        BORDER_FIELD(
            $widget,
            $id . '_border_active',
            'حاشیه',
            $parent_target . $target . '.active'
        );
        DIMENSIONS_FIELD(
            $widget,
            $id . '_border_radius_active',
            'گردی حاشیه',
            $parent_target . $target . '.active',
            'border-radius'
        );
        SHADOW_FIELD(
            $widget,
            $id . '_shadow_active',
            'سایه',
            $parent_target . $target . '.active'
        );

        $widget->end_controls_tab();
    }

    if ($parent_active && !$active) {
        $widget->start_controls_tab($id . '-tab-active', ['label' => 'حالت فعال']);

        COLOR_FIELD(
            $widget,
            $id . '_color_active',
            'رنگ',
            '',
            $parent_target . '.active ' . $target,
            'color'
        );
        BACKGROUND_FIELD(
            $widget,
            $id . '_bg_active',
            $parent_target . '.active ' . $target
        );
        BORDER_FIELD(
            $widget,
            $id . '_border_active',
            'حاشیه',
            $parent_target . '.active ' . $target
        );
        DIMENSIONS_FIELD(
            $widget,
            $id . '_border_radius_active',
            'گردی حاشیه',
            $parent_target . '.active ' . $target,
            'border-radius'
        );
        SHADOW_FIELD(
            $widget,
            $id . '_shadow_active',
            'سایه',
            $parent_target . '.active ' . $target
        );

        $widget->end_controls_tab();
    }

    $widget->end_controls_tabs();
}

function IconUtils($widget, string $id, string $target, string $parent_target = '', bool $active = false, bool $parent_active = false)
{
    SLIDER_FIELD_STYLE(
        $widget,
        $id . '_icon_width',
        'عرض باکس',
        10,
        100,
        30,
        $parent_target . $target,
        'width'
    );
    SLIDER_FIELD_STYLE(
        $widget,
        $id . '_icon_height',
        'ارتفاع باکس',
        10,
        100,
        30,
        $parent_target . $target,
        'height'
    );
    DIMENSIONS_FIELD(
        $widget,
        $id . '_margin',
        'فاصله بیرونی',
        $parent_target . $target,
        'margin'
    );

    /**
     * Normal State
     */
    $widget->start_controls_tabs($id . '-tab');
    $widget->start_controls_tab($id . '-tab-normal', ['label' => 'حالت عادی']);

    $widget->add_responsive_control(
        $id . '_icon_font_size',
        [
            'label'      => 'اندازه',
            'type'       => Controls_Manager::SLIDER,
            'default'    => [
                'size' => 16,
            ],
            'size_units' => ['px'],
            'range'      => [
                'px' => [
                    'min' => 10,
                    'max' => 200,
                ],
            ],
            'selectors'  => [
                '{{WRAPPER}} ' . $parent_target . $target . ' i'   => 'font-size: {{SIZE}}px;',
                '{{WRAPPER}} ' . $parent_target . $target .
                    ' svg'                                             => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                '{{WRAPPER}} ' . $parent_target . $target . ' img' => 'width: {{SIZE}}px;',
            ],
        ]
    );
    $widget->add_control(
        $id . '_icon_color',
        [
            'label'       => 'رنگ',
            'label_block' => false,
            'type'        => \Elementor\Controls_Manager::COLOR,
            'default'     => '#3772FF',
            'selectors'   => [
                '{{WRAPPER}} ' . $parent_target . $target . ' i'   => 'color: {{VALUE}};',
                '{{WRAPPER}} ' . $parent_target . $target . ' svg' => 'fill: {{VALUE}};',
            ]
        ]
    );
    BACKGROUND_FIELD($widget, $id . '_icon_box_bg', $parent_target . $target);
    BORDER_FIELD($widget, $id . '_icon_box_border', 'حاشیه', $parent_target . $target);
    DIMENSIONS_FIELD(
        $widget,
        $id . '_icon_box_border_radius',
        'خمیدگی',
        $parent_target . $target,
        'border-radius'
    );
    SHADOW_FIELD($widget, $id . '_icon_box_shadow', 'سایه', $parent_target . $target);

    $widget->end_controls_tab();

    /**
     * Hover State
     */
    $widget->start_controls_tab($id . '-tab-hover', ['label' => 'حالت هاور']);

    if (!empty($parent_target)) {
        $parent_target = str_replace(' ', '', $parent_target);

        $widget->add_responsive_control(
            $id . '_icon_font_size_hover',
            [
                'label'      => 'اندازه',
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 200,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $parent_target . ':hover ' . $target .
                        ' i'   => 'font-size: {{SIZE}}px;',
                    '{{WRAPPER}} ' . $parent_target . ':hover ' . $target .
                        ' svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                    '{{WRAPPER}} ' . $parent_target . ':hover ' . $target .
                        ' img' => 'width: {{SIZE}}px;',
                ],
            ]
        );
        $widget->add_control(
            $id . '_icon_color_hover',
            [
                'label'       => 'رنگ',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} ' . $parent_target . ':hover ' . $target .
                        ' i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} ' . $parent_target . ':hover ' . $target .
                        ' svg' => 'fill: {{VALUE}};',
                ]
            ]
        );
        BACKGROUND_FIELD(
            $widget,
            $id . '_icon_box_bg_hover',
            $parent_target . ':hover ' . $target
        );
        BORDER_FIELD(
            $widget,
            $id . '_icon_box_border_hover',
            'حاشیه',
            $parent_target . ':hover ' . $target
        );
        DIMENSIONS_FIELD(
            $widget,
            $id . '_icon_box_border_radius_hover',
            'خمیدگی',
            $parent_target . ':hover ' . $target,
            'border-radius'
        );
        SHADOW_FIELD(
            $widget,
            $id . '_icon_box_shadow_hover',
            'سایه',
            $parent_target . ':hover ' . $target
        );
    } else {
        $widget->add_responsive_control(
            $id . '_icon_font_size_hover',
            [
                'label'      => 'اندازه',
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 200,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $target . ':hover' . ' i'   => 'font-size: {{SIZE}}px;',
                    '{{WRAPPER}} ' . $target . ':hover' .
                        ' svg'                                       => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                    '{{WRAPPER}} ' . $target . ':hover' . ' img' => 'width: {{SIZE}}px;',
                ],
            ]
        );
        $widget->add_control(
            $id . '_icon_color_hover',
            [
                'label'       => 'رنگ',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} ' . $target . ':hover' . ' i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} ' . $target . ':hover' . ' svg' => 'fill: {{VALUE}};',
                ]
            ]
        );
        BACKGROUND_FIELD($widget, $id . '_icon_box_bg_hover', $target . ':hover');
        BORDER_FIELD(
            $widget,
            $id . '_icon_box_border_hover',
            'حاشیه',
            $target . ':hover'
        );
        DIMENSIONS_FIELD(
            $widget,
            $id . '_icon_box_border_radius_hover',
            'خمیدگی',
            $target . ':hover',
            'border-radius'
        );
        SHADOW_FIELD(
            $widget,
            $id . '_icon_box_shadow_hover',
            'سایه',
            $target . ':hover'
        );
    }

    $widget->end_controls_tab();

    if ($active && !$parent_active) {
        $widget->start_controls_tab($id . '-tab-active', ['label' => 'حالت فعال']);

        $widget->add_responsive_control(
            $id . '_icon_font_size_active',
            [
                'label'      => 'اندازه',
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 200,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $parent_target . $target . '.active' .
                        ' i'   => 'font-size: {{SIZE}}px;',
                    '{{WRAPPER}} ' . $parent_target . $target . '.active' .
                        ' svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                    '{{WRAPPER}} ' . $parent_target . $target . '.active' .
                        ' img' => 'width: {{SIZE}}px;',
                ],
            ]
        );
        $widget->add_control(
            $id . '_icon_color_active',
            [
                'label'       => 'رنگ',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} ' . $parent_target . $target . '.active' .
                        ' i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} ' . $parent_target . $target . '.active' .
                        ' svg' => 'fill: {{VALUE}};',
                ]
            ]
        );
        BACKGROUND_FIELD(
            $widget,
            $id . '_icon_box_bg_active',
            $parent_target . $target . '.active'
        );
        BORDER_FIELD(
            $widget,
            $id . '_icon_box_border_active',
            'حاشیه',
            $parent_target . $target . '.active'
        );
        DIMENSIONS_FIELD(
            $widget,
            $id . '_icon_box_border_radius_active',
            'خمیدگی',
            $parent_target . $target . '.active',
            'border-radius'
        );
        SHADOW_FIELD(
            $widget,
            $id . '_icon_box_shadow_active',
            'سایه',
            $parent_target . $target . '.active'
        );

        $widget->end_controls_tab();
    }

    if ($parent_active && !$active) {
        $widget->start_controls_tab($id . '-tab-active', ['label' => 'حالت فعال']);

        $widget->add_responsive_control(
            $id . '_icon_font_size_active',
            [
                'label'      => 'اندازه',
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 200,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $parent_target . '.active ' . $target .
                        ' i'   => 'font-size: {{SIZE}}px;',
                    '{{WRAPPER}} ' . $parent_target . '.active ' . $target .
                        ' svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                    '{{WRAPPER}} ' . $parent_target . '.active ' . $target .
                        ' img' => 'width: {{SIZE}}px;',
                ],
            ]
        );
        $widget->add_control(
            $id . '_icon_color_active',
            [
                'label'       => 'رنگ',
                'label_block' => false,
                'type'        => \Elementor\Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} ' . $parent_target . '.active ' . $target .
                        ' i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} ' . $parent_target . '.active ' . $target .
                        ' svg' => 'fill: {{VALUE}};',
                ]
            ]
        );
        BACKGROUND_FIELD(
            $widget,
            $id . '_icon_box_bg_active',
            $parent_target . '.active ' . $target
        );
        BORDER_FIELD(
            $widget,
            $id . '_icon_box_border_active',
            'حاشیه',
            $parent_target . '.active ' . $target
        );
        DIMENSIONS_FIELD(
            $widget,
            $id . '_icon_box_border_radius_active',
            'خمیدگی',
            $parent_target . '.active ' . $target,
            'border-radius'
        );
        SHADOW_FIELD(
            $widget,
            $id . '_icon_box_shadow_active',
            'سایه',
            $parent_target . '.active ' . $target
        );

        $widget->end_controls_tab();
    }

    $widget->end_controls_tabs();
}

function TextUtils($widget, string $id, string $target, string $parent_target = '', bool $hover = true, bool $alignment = false)
{
    $parent_target .= ' ';

    if ($alignment) {
        TEXT_ALIGNMENT($widget, $id . 'tux', $parent_target . $target);
    }

    DIMENSIONS_FIELD(
        $widget,
        $id . '_margin',
        'فاصله بیرونی',
        $parent_target . $target,
        'margin'
    );

    if ($hover) {
        TAB_START($widget, $id . 'font_utils_tb');
    }

    DIMENSIONS_FIELD(
        $widget,
        $id . '_padding',
        'فاصله درونی',
        $parent_target . $target,
        'padding'
    );
    FONT_FIELD($widget, $id . '_font', 'فونت', $parent_target . $target);
    COLOR_FIELD($widget, $id . '_color', 'رنگ', '', $parent_target . $target, 'color');

    if ($hover) {
        TAB_MIDDLE_($widget, $id . 'font_utils_tb', 'حالت هاور');

        DIMENSIONS_FIELD(
            $widget,
            $id . '_padding_h',
            'فاصله درونی',
            $parent_target . ':hover ' . $target,
            'padding'
        );
        FONT_FIELD(
            $widget,
            $id . '_font_h',
            'فونت',
            $parent_target . ':hover ' . $target
        );
        COLOR_FIELD(
            $widget,
            $id . '_color_h',
            'رنگ',
            '',
            $parent_target . ':hover ' . $target,
            'color'
        );

        TAB_END($widget);
    }
}

function ImageUtils($widget, string $id, string $target, string $parent_target = '')
{
    $parent_target .= ' ';

    $widget->add_responsive_control(
        $id . 'width',
        [
            'label'          => 'عرض',
            'type'           => Controls_Manager::SLIDER,
            'default'        => [
                'unit' => '%',
            ],
            'tablet_default' => [
                'unit' => '%',
            ],
            'mobile_default' => [
                'unit' => '%',
            ],
            'size_units'     => ['%', 'px', 'vw'],
            'range'          => [
                '%'  => [
                    'min' => 1,
                    'max' => 100,
                ],
                'px' => [
                    'min' => 1,
                    'max' => 1000,
                ],
                'vw' => [
                    'min' => 1,
                    'max' => 100,
                ],
            ],
            'selectors'      => [
                '{{WRAPPER}} ' . $parent_target . $target => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        $id . 'space',
        [
            'label'          => 'Max Width',
            'type'           => Controls_Manager::SLIDER,
            'default'        => [
                'unit' => '%',
            ],
            'tablet_default' => [
                'unit' => '%',
            ],
            'mobile_default' => [
                'unit' => '%',
            ],
            'size_units'     => ['%', 'px', 'vw'],
            'range'          => [
                '%'  => [
                    'min' => 1,
                    'max' => 100,
                ],
                'px' => [
                    'min' => 1,
                    'max' => 1000,
                ],
                'vw' => [
                    'min' => 1,
                    'max' => 100,
                ],
            ],
            'selectors'      => [
                '{{WRAPPER}} ' . $parent_target . $target => 'max-width: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        $id . 'height',
        [
            'label'          => 'ارتفاع',
            'type'           => Controls_Manager::SLIDER,
            'default'        => [
                'unit' => 'px',
            ],
            'tablet_default' => [
                'unit' => 'px',
            ],
            'mobile_default' => [
                'unit' => 'px',
            ],
            'size_units'     => ['px', 'vh'],
            'range'          => [
                'px' => [
                    'min' => 1,
                    'max' => 500,
                ],
                'vh' => [
                    'min' => 1,
                    'max' => 100,
                ],
            ],
            'selectors'      => [
                '{{WRAPPER}} ' . $parent_target . $target => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        $id . 'object-fit',
        [
            'label'     => 'Object Fit',
            'type'      => Controls_Manager::SELECT,
            'condition' => [
                $id . 'height[size]!' => '',
            ],
            'options'   => [
                ''        => 'Default',
                'fill'    => 'Fill',
                'cover'   => 'Cover',
                'contain' => 'Contain',
            ],
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} ' . $parent_target . $target => 'object-fit: {{VALUE}};',
            ],
        ]
    );

    $widget->add_control(
        $id . 'separator_panel_style',
        [
            'type'  => Controls_Manager::DIVIDER,
            'style' => 'thick',
        ]
    );

    $widget->start_controls_tabs($id . 'image_effects');

    $widget->start_controls_tab(
        $id . 'normal',
        [
            'label' => 'عادی'
        ]
    );

    $widget->add_control(
        $id . 'opacity',
        [
            'label'     => 'شفافیت',
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
                'px' => [
                    'max'  => 1,
                    'min'  => 0.10,
                    'step' => 0.01,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} ' . $parent_target . $target => 'opacity: {{SIZE}};',
            ],
        ]
    );

    $widget->add_group_control(
        Group_Control_Css_Filter::get_type(),
        [
            'name'     => $id . 'css_filters',
            'selector' => '{{WRAPPER}} ' . $parent_target . $target,
        ]
    );

    $widget->end_controls_tab();

    $widget->start_controls_tab(
        $id . 'hover',
        [
            'label' => 'هاور',
        ]
    );

    $widget->add_control(
        $id . 'opacity_hover',
        [
            'label'     => 'شفافیت',
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
                'px' => [
                    'max'  => 1,
                    'min'  => 0.10,
                    'step' => 0.01,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} ' . $parent_target . ':hover' . $target => 'opacity: {{SIZE}};',
            ],
        ]
    );

    $widget->add_group_control(
        Group_Control_Css_Filter::get_type(),
        [
            'name'     => $id . 'css_filters_hover',
            'selector' => '{{WRAPPER}} ' . $parent_target . ':hover' . $target,
        ]
    );

    $widget->add_control(
        $id . 'background_hover_transition',
        [
            'label'     => 'زمان انیمیشن',
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
                'px' => [
                    'max'  => 3,
                    'step' => 0.1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} ' . $parent_target . ':hover' .
                    $target => 'transition-duration: {{SIZE}}s',
            ],
        ]
    );

    $widget->end_controls_tab();

    $widget->end_controls_tabs();

    $widget->add_group_control(
        Group_Control_Border::get_type(),
        [
            'name'      => $id . 'image_border',
            'selector'  => '{{WRAPPER}} ' . $parent_target . $target,
            'separator' => 'before',
        ]
    );

    $widget->add_responsive_control(
        $id . 'image_border_radius',
        [
            'label'      => 'خمیدگی',
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors'  => [
                '{{WRAPPER}} ' . $parent_target .
                    $target => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_group_control(
        Group_Control_Box_Shadow::get_type(),
        [
            'name'     => $id . 'image_box_shadow',
            'exclude'  => [
                'box_shadow_position',
            ],
            'selector' => '{{WRAPPER}} ' . $parent_target . $target,
        ]
    );
}

/**
 * @param          $widget
 * @param  string  $id
 * @param  string  $target
 * @param  array   $ELEMENTS  -> pattern => ['element-name' => 'human-readable-name']
 *
 * @return void
 */
function VariantUtils($widget, string $id, string $target, array $ELEMENTS)
{
    $init_target = $target;

    foreach ($ELEMENTS as $ELEMENT) {
        $uniq = '';
        if (!empty($ELEMENT['uniq'])) {
            $uniq = $ELEMENT['uniq'];
        }

        if (!empty($ELEMENT['target'])) {
            $target = $ELEMENT['target'];
        } else {
            $target = $init_target;
        }

        $def = '';
        if (!empty($ELEMENT['def'])) {
            $def = $ELEMENT['def'];
        }

        $condition       = false;
        $condition_value = '';
        if (!empty($ELEMENT['cond'])) {
            $condition       = $ELEMENT['cond'];
            $condition_value = $ELEMENT['cond_val'];
        }

        switch ($ELEMENT['type']) {
            case '4dir':
                DIMENSIONS_FIELD(
                    $widget,
                    $id . '-dimension-' . $ELEMENT['css'] . '-' . $uniq,
                    $ELEMENT['title'],
                    $target,
                    $ELEMENT['css'],
                    $condition,
                    $condition_value
                );
                break;

            case 'slider':
                SLIDER_FIELD_STYLE(
                    $widget,
                    $id . '-slider-' . $ELEMENT['css'] . '-' . $uniq,
                    $ELEMENT['title'],
                    $ELEMENT['min'],
                    $ELEMENT['max'],
                    $def,
                    $target,
                    $ELEMENT['css'],
                    $condition,
                    $condition_value
                );
                break;

            case 'bg':
                BACKGROUND_FIELD(
                    $widget,
                    $id . '-bg-' . $uniq,
                    $target,
                    $condition,
                    $condition_value
                );
                break;

            case 'bg-c':
                BACKGROUND_WO_IMG_FIELD(
                    $widget,
                    $id . '-bg-' . $uniq,
                    $target,
                    $condition,
                    $condition_value
                );
                break;

            case 'color':
                COLOR_FIELD(
                    $widget,
                    $id . '-color-' . $uniq,
                    $ELEMENT['title'],
                    $def,
                    $target,
                    'color',
                    $condition,
                    $condition_value
                );
                break;

            case 'color-v':
                COLOR_FIELD(
                    $widget,
                    $id . '-color-bg-' . $uniq,
                    $ELEMENT['title'],
                    $def,
                    $target,
                    $ELEMENT['css'],
                    $condition,
                    $condition_value
                );
                break;

            case 'border':
                BORDER_FIELD(
                    $widget,
                    $id . '-border-' . $uniq,
                    $ELEMENT['title'],
                    $target,
                    $condition,
                    $condition_value
                );
                break;

            case 'shadow':
                SHADOW_FIELD(
                    $widget,
                    $id . '-box-shadow-' . $uniq,
                    $ELEMENT['title'],
                    $target,
                    $condition,
                    $condition_value
                );
                break;

            case 'font':
                FONT_FIELD(
                    $widget,
                    $id . '-font-' . $uniq,
                    $ELEMENT['title'],
                    $target,
                    $condition,
                    $condition_value
                );
                break;

            case 'text-align':
                TEXT_ALIGNMENT(
                    $widget,
                    $id . '-txt-alignment-' . $uniq,
                    $target,
                    $condition,
                    $condition_value
                );
                break;

            case 'sep':
                DIVIDER_FIELD($widget, $id . '-divider-d1-' . $uniq);
                HEADING_FIELD($widget, $id . '-heading-' . $uniq, $ELEMENT['title']);
                DIVIDER_FIELD($widget, $id . '-divider-d2-' . $uniq);
                break;

            case 'box-styles':
                DIMENSIONS_FIELD(
                    $widget,
                    $id . '-dimension-padding' . '-' . $uniq,
                    'فاصله داخلی',
                    $target,
                    'padding'
                );
                DIMENSIONS_FIELD(
                    $widget,
                    $id . '-dimension-margin' . '-' . $uniq,
                    'فاصله بیرونی',
                    $target,
                    'margin'
                );
                DIMENSIONS_FIELD(
                    $widget,
                    $id . '-dimension-border-radius' . '-' . $uniq,
                    'خمیدگی',
                    $target,
                    'border-radius'
                );
                BACKGROUND_FIELD($widget, $id . '-bg-' . $uniq, $target);
                BORDER_FIELD($widget, $id . '-border-' . $uniq, 'خط دور', $target);
                SHADOW_FIELD($widget, $id . '-box-shadow-' . $uniq, 'سایه', $target);

                break;

            case 'text':
                FONT_FIELD(
                    $widget,
                    $id . '-font-' . $uniq,
                    'تایپوگرافی',
                    $target,
                    $condition,
                    $condition_value
                );

                FONT_STROKE_FIELD(
                    $widget,
                    $id . '-font-strok-' . $uniq,
                    $target,
                    $condition,
                    $condition_value
                );

                TEXT_ALIGNMENT(
                    $widget,
                    $id . '-text-alignment-' . $uniq,
                    $target,
                    $condition,
                    $condition_value
                );

                COLOR_FIELD(
                    $widget,
                    $id . '-color-' . $uniq,
                    'رنگ',
                    $def,
                    $target,
                    'color',
                    $condition,
                    $condition_value
                );
                break;

            case 'text-small':
                FONT_FIELD(
                    $widget,
                    $id . '-font-' . $uniq,
                    'تایپوگرافی',
                    $target,
                    $condition,
                    $condition_value
                );

                COLOR_FIELD(
                    $widget,
                    $id . '-color-' . $uniq,
                    'رنگ',
                    $def,
                    $target,
                    'color',
                    $condition,
                    $condition_value
                );
                break;

            case 'tab-start':
                TAB_START($widget, $id . '-start-' . $uniq);
                break;
            case 'tab-end':
                TAB_END($widget);
                break;
            case 'tab-middle':
                TAB_MIDDLE_($widget, $id . '-middle-' . $uniq, $ELEMENT['title']);
                break;
        }

        $target = $init_target;
    }
}
