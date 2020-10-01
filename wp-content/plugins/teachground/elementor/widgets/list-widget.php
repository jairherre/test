<?php

/**
 * Elementor excerpt Widget.
 *
 *
 * @since 1.0.0
 */
class Elementor_List_Widget extends \Elementor\Widget_Base
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
        return 'tg_lesson_list';
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
        return __('TeachGround Lesson List', 'teachground');
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
                'label' => __('Lesson list settings', 'teachground'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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

        $settings = $this->get_settings_for_display(); ?>

        <style>
            .tg-row h3 {
                margin: 0 0 15px 0;
                padding: 12px 20px;
                background: <?php echo $settings['h_bg']; ?>;
                font-weight: <?php echo $settings['h_weight']; ?>;
                font-size: <?php echo $settings['h_size']; ?>px;
                font-family: <?php echo $settings['h_font']; ?>;
                color: <?php echo $settings['h_color']; ?>;
            }

            .tg-lessons li {
                margin-top: 0;
                margin-bottom: 0;
                border: none;
                border-bottom: 1px solid #eef0f4;

            }

            .tg-lessons li i {
                display: inline-block;
                margin-right: 6px;
                color: #f47021;
            }

            .tg-lessons li:last-child {
                border: none;
                border-bottom: none;
            }

            ul.tg-lessons-widget li a {
                font-family: <?php echo $settings['l_font']; ?>;
            }

            ul.tg-lessons-widget li a {
                color: <?php echo $settings['l_color']; ?>;
            }

            .lessons-widget-cont .lesson-active a {
                color: <?php echo $settings['l_sec_color']; ?>;
            }

            ul.tg-lessons-widget li a:hover,
            ul.tg-lessons-widget li a:focus {
                color: <?php echo $settings['l_sec_color']; ?> !important;
                text-decoration: none !important;
                box-shadow: none !important;
                outline: none;
            }

            ul.tg-lessons-widget li i {
                display: inline-block;
                margin-right: 6px;
                color: <?php echo $settings['l_sec_color']; ?>;
            }

            .toggle_all_secs {
                margin-left: 20px;
                margin-bottom: 10px;
                margin-top: 10px;
                cursor: pointer;
                font-weight: <?php echo $settings['t_weight']; ?>;
                font-size: <?php echo $settings['t_size']; ?>px;
                color: <?php echo $settings['t_color']; ?>;
                font-family: <?php echo $settings['t_font']; ?>;
            }

            .toggle_all_secs:hover {
                color: <?php echo $settings['t_sec_color']; ?> !important;
            }
        </style>
<?php
        echo do_shortcode('[tg_lesson_list]');
    }
}
