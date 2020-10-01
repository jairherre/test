<?php

/**
 * Elementor excerpt Widget.
 *
 *
 * @since 1.0.0
 */
class Elementor_Excerpt_Widget extends \Elementor\Widget_Base
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
        return 'tg_lesson_exerpt';
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
        return __('TeachGround Lesson Exerpt', 'teachground');
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
        return 'fa fa-paragraph';
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
                'label' => __('Excerpt settings', 'teachground'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'color',
            [
                'label' => __('Excerpt color', 'teachground'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => 'COLOR_1'
            ]
        );

        $this->add_control(
            'font',
            [
                'label' => __('Excerpt font', 'teachground'),
                'type' => \Elementor\Controls_Manager::FONT
            ]
        );
        $this->add_control(
            'font-size',
            [
                'label' => __('Excerpt font size', 'teachground'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 15,
                'step' => 1
            ]
        );
        $this->add_control(
            'font-weight',
            [
                'label' => __('Excerpt font weight', 'teachground'),
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

        echo do_shortcode('[tg_lesson_excerpt color="' . $settings["color"] . '" font="' . $settings["font"] . '" font-size="' . $settings["font-size"] . '" font-weight="' . $settings["font-weight"] . '"]');
    }
}
