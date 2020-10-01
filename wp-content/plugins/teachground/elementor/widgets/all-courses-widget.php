<?php

/**
 * Elementor excerpt Widget.
 *
 *
 * @since 1.0.0
 */
class Elementor_All_Courses_Widget extends \Elementor\Widget_Base
{

    /**
     * Get widget name.
     *
     * Retrieve oEmbed widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'tg_all_courses';
    }

    /**
     * Get widget title.
     *
     * Retrieve oEmbed widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return __('TeachGround Courses List', 'teachground');
    }

    /**
     * Get widget icon.
     *
     * Retrieve oEmbed widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'fa fa-list';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the oEmbed widget belongs to.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return ['tg-category'];
    }

    /**
     * Register oEmbed widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls()
    {

        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Courses list settings', 'teachground'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $taxonomy = 'tg_course_category';
        $terms = get_terms($taxonomy);

        $options = [];
        foreach ($terms as $value) {
            $options[$value->term_id] = $value->name;
        }

        $this->add_control(
            'is_user_only',
            [
                'label' => __('Show only user courses', 'teachground'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control(
            'assigned_first',
            [
                'label' => __('Show assigned courses first', 'teachground'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'condition' => ['is_user_only' => ''],
                'default' => 'no'
            ]
        );
        $this->add_control(
            'categories',
            [
                'label' => __('Select categories', 'teachground'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $options,
                'default' => ''
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render oEmbed widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        if ($settings['is_user_only'] == 'yes') {
            echo do_shortcode('[tg_user_courses categories=' . implode(',', $settings['categories']) . ']');
        } else {
            if ($settings['assigned_first'] == 'yes') {
                echo do_shortcode('[tg_user_courses categories=' . implode(',', $settings['categories']) . ']');
                echo do_shortcode('[tg_all_courses assigned_first="yes" categories=' . implode(',', $settings['categories']) . ']');
            } else {
                echo do_shortcode('[tg_all_courses assigned_first="no" categories=' . implode(',', $settings['categories']) . ']');
            }
        }
    }
}
