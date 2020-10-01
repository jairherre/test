<?php

/**
 * Elementor excerpt Widget.
 *
 *
 * @since 1.0.0
 */
class Elementor_Navigation_Widget extends \Elementor\Widget_Base
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
        return 'tg_navigation_widget';
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
        return __('TeachGround Navigation widget', 'teachground');
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
        return 'fa fa-bars';
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
        return ['teachground-category'];
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
                'label' => __('Sections settings', 'teachground'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        // $this->add_control(
        //     'important_note',
        //     [
        //         'label' => __('Important Note', 'plugin-name'),
        //         'type' => \Elementor\Controls_Manager::RAW_HTML,
        //         'raw' => __('A very important message to show in the panel.', 'plugin-name'),
        //         'content_classes' => 'your-class',
        //     ]
        // );
        $this->add_control(
            'h_bg',
            [
                'label' => __('Section title background color', 'teachground'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => 'COLOR_1',
                'default' => '#fafafe'
            ]
        );
        $this->add_control(
            'h_size',
            [
                'label' => __('Section font size', 'teachground'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 16,
                'step' => 1
            ]
        );
        $this->add_control(
            'h_color',
            [
                'label' => __('Section color', 'teachground'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => 'COLOR_1',
                'default' => '#000'
            ]
        );
        $this->add_control(
            'h_weight',
            [
                'label' => __('Section font weight', 'teachground'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'bold',
                'options' => [
                    '100'  => __('Thin', 'teachground'),
                    'normal'  => __('Normal', 'teachground'),
                    'bold' => __('Bold', 'teachground'),
                    'bolder' => __('Bolder', 'teachground')
                ],
            ]
        );
        $this->add_control(
            'h_font',
            [
                'label' => __('Section font', 'teachground'),
                'type' => \Elementor\Controls_Manager::FONT
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'lessons_settings',
            [
                'label' => __('Lessons settings', 'teachground'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'l_font',
            [
                'label' => __('Lesson font', 'teachground'),
                'type' => \Elementor\Controls_Manager::FONT
            ]
        );
        $this->add_control(
            'l_color',
            [
                'label' => __('Main color', 'teachground'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => 'COLOR_1',
                'default' => '#3a3a3a'
            ]
        );
        $this->add_control(
            'l_sec_color',
            [
                'label' => __('Secondary color', 'teachground'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => 'COLOR_1',
                'default' => '#f47021'
            ]
        );

        $this->add_control(
            't_size',
            [
                'label' => __('Toggle font size', 'teachground'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 15,
                'step' => 1
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'toggle_settings',
            [
                'label' => __('Toggle button settings', 'teachground'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            't_weight',
            [
                'label' => __('Toggle font weight', 'teachground'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'bold',
                'options' => [
                    '100'  => __('Thin', 'teachground'),
                    'normal'  => __('Normal', 'teachground'),
                    'bold' => __('Bold', 'teachground'),
                    'bolder' => __('Bolder', 'teachground')
                ],
            ]
        );
        $this->add_control(
            't_font',
            [
                'label' => __('Toggle font', 'teachground'),
                'type' => \Elementor\Controls_Manager::FONT
            ]
        );
        $this->add_control(
            't_color',
            [
                'label' => __('Main color', 'teachground'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => 'COLOR_1',
                'default' => '#3a3a3a'
            ]
        );
        $this->add_control(
            't_sec_color',
            [
                'label' => __('Secondary color', 'teachground'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => 'COLOR_1',
                'default' => '#f47021'
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
?>
        <style>
            .wid-section-title {
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
                list-style: none !important;
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
        echo do_shortcode('[tg_navigation_widget]');
    }
}
