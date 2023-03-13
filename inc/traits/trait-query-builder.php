<?php

/**
 * Singleton trait which implements wp query builder  in any class in which this trait is used.
 *
 * @package Morex
 */

namespace MOREX_PLUGIN\Inc\Traits;

use Elementor\Controls_Manager;

// Prevent Direct Access
if (!defined('ABSPATH')) {
    exit;
}

defined('ABSPATH') || die();

trait Query_Builder
{

    private function get_post_types()
    {
        $post_types = get_post_types(['public' => true, 'show_in_nav_menus' => true], 'objects');
        $post_types = wp_list_pluck($post_types, 'label', 'name');

        return array_diff_key($post_types, ['elementor_library', 'attachment']);
    }

    private function get_taxonomies()
    {
        $taxonomies = get_taxonomies(null, 'objects');
        $taxes      = [];
        foreach ($taxonomies as $taxonomy) {
            if (!in_array($taxonomy->name, [
                'nav_menu',
                'elementor_font_type',
                'wp_template_part_area',
                'elementor_library_type',
                'elementor_library_category',
                'post_format',
                'wp_theme',
                'link_category'
            ])) {
                $taxes[$taxonomy->name] = $taxonomy->label;
            }
        }

        return $taxes;
    }


    protected function QuerySettings()
    {
        $META_COMPARE_OPTIONS = [
            '='      => 'برابر باشد',
            '!='     => 'برابر نباشد',
            '>'      => 'بزرگتر',
            '>='     => 'بزرگتر مساوی',
            '<'      => 'کوچکتر',
            '<='     => 'کوچکتر مساوی',
            'IN'     => 'IN',
            'NOT IN' => 'NOT IN',
        ];

        $META_VALUE_TYPES = [
            'NUMERIC'  => 'NUMERIC',
            'BINARY'   => 'BINARY',
            'CHAR'     => 'CHAR',
            'DECIMAL'  => 'DECIMAL',
            'DATETIME' => 'DATETIME',
        ];

        $TAXONOMY_OPERATORS = [
            'IN'         => 'IN',
            'NOT IN'     => 'NOT IN',
            'EXISTS'     => 'EXISTS',
            'NOT EXISTS' => 'NOT EXISTS',
            'AND'        => 'AND',
        ];

        $POST_STATUS = [
            'publish' => 'منتشر شده',
            'private' => 'خصوصی',
            'pending' => 'در انتشار',
            'draft'   => 'پیش نویس',
            'trash'   => 'حذف شده',
            'any'     => 'هر نوع',
        ];


        $this->start_controls_section('query_settings', ['label' => 'تنظیمات کوئری']);

        // MULTIPLE_SELECT_FIELD( $this, 'post_type', 'نوع نوشته', $this->get_post_types(), [ 'post' ] );
        MULTIPLE_SELECT_FIELD($this, 'post_status', 'وضعیت نوشته', $POST_STATUS, ['publish']);

        $this->add_control(
            'post__in',
            [
                'label'       => 'درج پست',
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'description' => 'نکته:آیدی پست ها را با | جدا کنید. در صورت درج پست، بقیه تنظیمات نادیده گرفته خواهد شد!'
            ]
        );
        $this->add_control(
            'post__not_in',
            [
                'label'       => 'جداسازی پست',
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'description' => 'نکته:آیدی پست ها را با | جدا کنید.'
            ]
        );

        SWITCH_FIELD($this, 'exclude_this_post', 'نادیده گرفتن این پست', 'yes');
        NUMBER_FIELD($this, 'posts_per_page', 'تعداد نوشته', -1, 30);
        NUMBER_FIELD($this, 'offset', 'offset', 0, 100, 1, 0, true, 'no_found_rows', '');
        SWITCH_FIELD($this, 'ignore_sticky_posts', 'نادیده گرفتن پست های چسبان', 'yes');
        SWITCH_FIELD($this, 'no_found_rows', 'نیاز به صفحه بندی', '');


        $order = [
            'ASC'  => 'صعودی',
            'DESC' => 'نزولی'
        ];
        SELECT_FIELD($this, 'order', 'ترتیب', $order, 'DESC');

        $order_by = [
            'none'           => 'بدون ترتیب',
            'ID'             => 'ID',
            'title'          => 'عنوان',
            'name'           => 'نامک',
            'date'           => 'تاریخ انتشار',
            'modified'       => 'تاریخ ویرایش',
            'rand'           => 'تصادفی',
            'comment_count'  => 'تعداد کامنت',
            'meta_value'     => 'زمینه دلخواه',
            'meta_value_num' => 'زمینه دلخواه عددی',
        ];
        SELECT_FIELD($this, 'orderby', 'مرتب سازی', $order_by, 'date');
        $this->add_control(
            'meta_value_key',
            [
                'label'       => 'کلید زمینه دلخواه',
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic'     => [
                    'active' => true,
                ],
                'condition'   => [
                    'orderby' => ['meta_value', 'meta_value_num']
                ]
            ]
        );
        $this->add_control(
            'meta_value_compare',
            [
                'label'       => 'نوع عملیات زمینه دلخواه',
                'type'        => Controls_Manager::SELECT,
                'label_block' => false,
                'options'     => $META_COMPARE_OPTIONS,
                'default'     => '=',
                'condition'   => [
                    'orderby' => ['meta_value', 'meta_value_num']
                ]
            ]
        );
        $this->add_control(
            'meta_value_type',
            [
                'label'       => 'نوع مقایسه',
                'type'        => Controls_Manager::SELECT,
                'label_block' => false,
                'options'     => $META_VALUE_TYPES,
                'default'     => 'CHAR',
                'condition'   => [
                    'orderby' => 'meta_value',
                ]
            ]
        );
        $this->add_control(
            'meta_value_value',
            [
                'label'       => 'مقدار زمینه دلخواه',
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic'     => [
                    'active' => true,
                ],
                'description' => 'با استفاده از کامای انگلیسی (,) چندین مقدار را از هم جدا کنید.',
                'condition'   => [
                    'orderby'          => ['meta_value', 'meta_value_num'],
                    'meta_value_type!' => 'DATETIME'
                ]
            ]
        );
        $this->add_control(
            'meta_value_date',
            [
                'label'     => 'مقدار زمینه دلخواه',
                'type'      => \Elementor\Controls_Manager::DATE_TIME,
                'condition' => [
                    'orderby'         => ['meta_value', 'meta_value_num'],
                    'meta_value_type' => 'DATETIME'
                ]
            ]
        );

        $tax_query = new \Elementor\Repeater();
        $this->add_control(
            'enable_tax_query',
            [
                'label'        => 'تکسونومی کوئری',
                'type'         => Controls_Manager::SWITCHER,
                'label_block'  => false,
                'label_on'     => 'بله',
                'label_off'    => 'خیر',
                'return_value' => 'yes',
                'default'      => '',
                'description'  => 'برای دریافت term های مشابه، فیلد را روی "آیدی" تنظیم کنید.',
                'separator'    => 'before'
            ]
        );
        $tax_query->add_control('taxonomy', [
            'label'       => 'تکسونومی',
            'type'        => Controls_Manager::SELECT2,
            'options'     => $this->get_taxonomies(),
            'label_block' => false,
            'default'     => 'category',
        ]);
        $tax_query->add_control(
            'terms',
            [
                'label'       => 'زمینه ها',
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'label_block' => true,
                'description' => 'برای لیستی از زمینه ها با کامای انگلیسی از هم جدا کنید. برای دسته بندی های مرتبط از %current% استفاده کنید.'
            ]
        );
        $tax_fields = [
            'term_id' => 'آیدی',
            'name'    => 'نام',
            'slug'    => 'نامک',
        ];
        $tax_query->add_control('fieldx', [
            'label'       => 'فیلد',
            'type'        => Controls_Manager::SELECT2,
            'options'     => $tax_fields,
            'label_block' => false,
            'default'     => 'term_id',
        ]);


        SELECT_FIELD($tax_query, 'operator', 'نوع عملیات', $TAXONOMY_OPERATORS, 'IN');
        $this->add_control('tax_query', [
            'label'       => 'تکسونومی ها',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $tax_query->get_controls(),
            'title_field' => '{{{ taxonomy }}} {{{ operator }}} {{{ terms }}}',
            'prevent_empty' => false,
            'condition'   => [
                'enable_tax_query' => 'yes'
            ]
        ]);
        $this->add_control('tax_relation', [
            'label'       => 'ارتباط بین تکسونومی ها',
            'type'        => Controls_Manager::SELECT2,
            'label_block' => false,
            'options'     => [
                'AND' => 'AND',
                'OR'  => 'OR'
            ],
            'default'     => 'AND',
            'condition'   => [
                'enable_tax_query' => 'yes'
            ]
        ]);


        $meta_query = new \Elementor\Repeater();
        $this->add_control(
            'enable_meta_query',
            [
                'label'        => 'متا کوئری',
                'type'         => Controls_Manager::SWITCHER,
                'label_block'  => false,
                'label_on'     => 'بله',
                'label_off'    => 'خیر',
                'return_value' => 'yes',
                'default'      => '',
                'separator'    => 'before'
            ]
        );
        $meta_query->add_control(
            'key',
            [
                'label'       => 'کلید',
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );
        $meta_query->add_control(
            'compare',
            [
                'label'       => 'نوع عملیات',
                'type'        => Controls_Manager::SELECT2,
                'label_block' => false,
                'dynamic'     => [
                    'active' => true,
                ],
                'options'     => $META_COMPARE_OPTIONS,
                'default'     => '=',
            ]
        );
        $meta_query->add_control(
            'value',
            [
                'label'       => 'مقدار',
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic'     => [
                    'active' => true,
                ],
                'description' => 'وقتی "نوع عملیات" یکی از عملیات های IN / NOT IN / BETWEEN / NOT BETWEEN باشد میتوانید چندین مقدار وارد کنید. با کامای انگلیسی مقادیر را جدا کنید.'
            ]
        );
        $this->add_control('meta_query', [
            'label'       => 'متا کوئری ها',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $meta_query->get_controls(),
            'title_field' => '{{{ key }}} {{{ compare }}} {{{ value }}}',
            'prevent_empty' => false,
            'condition'   => [
                'enable_meta_query' => 'yes'
            ]
        ]);
        $this->add_control('meta_relation', [
            'label'       => 'ارتباط بین متا کوئری ها',
            'type'        => Controls_Manager::SELECT2,
            'options'     => [
                'AND' => 'AND',
                'OR'  => 'OR'
            ],
            'label_block' => false,
            'separator'   => 'after',
            'default'     => 'AND',
            'condition'   => [
                'enable_meta_query' => 'yes'
            ]
        ]);



        $this->end_controls_section();
    }

    protected function QueryArgBuilder()
    {
        $settings = $this->get_settings_for_display();
        $args = [];

        $order               = $settings['order'] ?: 'DESC';
        $ignore_sticky_posts = (bool) $settings['ignore_sticky_posts'];
        $no_found_rows       = (bool) $settings['no_found_rows'];
        $order_by            = $settings['orderby'] ?: 'date';

        if (!empty($settings['post_type'])) {
            $post_type           = $settings['post_type'];
            $args['post_type'] = count($post_type) > 1 ? $post_type : $post_type[0];
        }
        if (!empty($settings['post_status'])) {
            $post_status         = $settings['post_status'];

            $args['post_status'] = count($post_status) > 1 ? $post_status : $post_status[0];
        }
        if (!empty($settings['post__in'])) {
            $args['post__in'] = $settings['post__in'];
        }
        if (!empty($settings['post__not_in'])) {
            $args['post__not_in'] = $settings['post__not_in'];
        }
        if (!empty($settings['exclude_this_post'])) {
            $args['post__not_in'][] = get_the_ID();
        }
        $args['posts_per_page'] =  $settings['posts_per_page'] ?: 5;

        if ($no_found_rows !== false) {

            $args['offset'] = $settings['offset'];
            $page_arg = (is_front_page() && is_page_template('templates/home.php')) ? 'page' : 'paged';
            // WP_Query argument For all the portfolio posts
            $args['paged']  = (get_query_var($page_arg)) ? get_query_var($page_arg) : 1;
        } else {
            $args['no_found_rows'] = true;
        }

        $args['order']               = $order;
        $args['ignore_sticky_posts'] = $ignore_sticky_posts;

        $args['orderby'] = $order_by;

        // insert meta value -> orderby
        if ($order_by === 'meta_value' || $order_by === 'meta_value_num') {
            $meta_value_key = $settings['meta_value_key'] ?: '';

            $meta_value_value = $settings['meta_value_value'] ?: '';
            if (!empty($meta_value_value) && strpos($meta_value_value, ',') !== false) {
                $meta_value_value = explode(',', $meta_value_value);
            }

            $meta_value_date    = $settings['meta_value_date'] ?: '';
            $meta_value_compare = $settings['meta_value_compare'];
            $meta_value_type    = $settings['meta_value_type'] ?: '';

            if (!empty($meta_value_key) || !empty($meta_value_value) || !empty($meta_value_date)) {
                if (!empty($meta_value_key)) {
                    $args['meta_key'] = $meta_value_key;
                }

                if (!empty($meta_value_type)) {
                    $args['meta_type'] = $meta_value_type;
                }

                if (!empty($meta_value_value)) {
                    if ($order_by === 'meta_value') {
                        $args['meta_value'] = $meta_value_value;
                    }
                    if ($order_by === 'meta_value_num') {
                        $args['meta_value_num'] = (int) $meta_value_value;
                    }
                }

                if (!empty($meta_value_date)) {
                    $args['meta_value_date'] = $meta_value_date;
                    $args['orderby']         = 'meta_value';
                }

                // calculate meta_compare
                if (
                    (
                        (!empty($meta_value_date) || !empty($meta_value_value))
                        && !empty($meta_value_key)
                    )
                    && !empty($meta_value_compare)
                ) {
                    $args['meta_compare'] = $meta_value_compare;
                }
            }
        }


        // insert taxonomy query
        $enable_tax_query = $settings['enable_tax_query'];
        $tax_query        = $settings['tax_query'];
        if (!empty($enable_tax_query) && !empty($tax_query)) {
            $tax_query_pack = [];

            if (count($tax_query) > 1) {
                $tax_query_pack['relation'] = $settings['tax_relation'] ?: 'AND';
            }

            foreach ($tax_query as $item) {
                if (!empty($item['terms'])) {
                    $pack['taxonomy'] = $item['taxonomy'];
                    $pack['field']    = $item['fieldx'];
                    if ($item['terms'] !== '%current%') {
                        $pack['terms'] = is_array($item['terms']) ? $item['terms'] : array_map('trim', explode(',', $item['terms']));
                    } else {
                        $terms = get_the_terms(get_the_ID(), $item['taxonomy']);
                        if (is_array($terms) && !is_wp_error($terms)) {
                            foreach ($terms as $term) {
                                $pack['terms'][] = $term->term_id;
                            }
                        }
                    }
                    if ($item['operator'] !== 'IN') {
                        $pack['operator'] = $item['operator'];
                    }
                    $tax_query_pack[] = $pack;
                }
            }

            $args['tax_query'] = $tax_query_pack;
        }


        // if tax query does not used
        if (empty($enable_tax_query)) {
            $args['update_post_term_cache'] = false;
        }


        // insert meta query
        $enable_meta_query = $settings['enable_meta_query'];
        $meta_query        = $settings['meta_query'];
        if (!empty($enable_meta_query) && !empty($meta_query)) {
            $meta_query_pack = [];

            if (count($meta_query) > 1) {
                $meta_query_pack['relation'] = $settings['meta_relation'] ?: 'AND';
            }

            foreach ($meta_query as $item) {
                $pack = [];

                if (!empty($item['key'])) {
                    $pack['key'] = $item['key'];
                }

                if (!empty($item['value'])) {
                    if (strpos($item['value'], ',') !== false) {
                        $pack['value'] = explode(',', $item['value']);
                    } else {
                        $pack['value'] = $item['value'];
                    }
                }

                if (!empty($item['compare']) && $item['compare'] !== '=' && !empty($item['key'])) {
                    $pack['compare'] = $item['compare'];
                }

                if (!empty($pack)) {
                    $meta_query_pack[] = $pack;
                }
            }

            $args['meta_query'] = $meta_query_pack;
        }


        // if meta_query not used
        if (empty($enable_meta_query) && $order_by !== 'meta_value' && $order_by !== 'meta_value_num') {
            $args['update_post_meta_cache'] = false;
        }

        return $args;
    }
}
