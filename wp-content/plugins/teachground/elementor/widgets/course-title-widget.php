<?php

/**
 * Elementor Title Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Elementor_Course_Title_Widget extends \Elementor\Widget_Base
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
        return 'tg_course_title';
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
        return __('TeachGround Course Title', 'teachground');
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
        return 'fa fa-text-height';
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
                'label' => __('Content', 'teachground'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'post_id',
            [
                'label' => __('Course Id (if required)', 'teachground'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'color',
            [
                'label' => __('Title color', 'teachground'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => 'COLOR_1'
            ]
        );

        $this->add_control(
            'font',
            [
                'label' => __('Title font', 'teachground'),
                'type' => \Elementor\Controls_Manager::FONT
            ]
        );
        $this->add_control(
            'font-size',
            [
                'label' => __('Title font size', 'teachground'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 20,
                'step' => 1
            ]
        );
        $this->add_control(
            'font-weight',
            [
                'label' => __('Title font weight', 'teachground'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'normal',
                'options' => [
                    '100'  => __('Thin', 'teachground'),
                    'normal'  => __('Normal', 'teachground'),
                    'bold' => __('Bold', 'teachground'),
                    'bolder' => __('Bolder', 'teachground')
                ],
            ]
        );
        $this->add_control(
            'align',
            [
                'label' => __('Content text align', 'teachground'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left'  => __('Left', 'teachground'),
                    'right' => __('Right', 'teachground'),
                    'center' => __('Center', 'teachground'),
                    'justify' => __('Justify', 'teachground')
                ],
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

        $html = wp_oembed_get($settings['url']);

        echo do_shortcode('[tg_lesson_title post_id="' . $settings["post_id"] . '" align="' . $settings["align"] . '" color="' . $settings["color"] . '" font="' . $settings["font"] . '" font-size="' . $settings["font-size"] . '" font-weight="' . $settings["font-weight"] . '"]');
    }
}
