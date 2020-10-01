<?php

/**
 * Elementor resource Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Elementor_Resource_Widget extends \Elementor\Widget_Base
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
        return 'tg_resources';
    }

    /**
     * Get widget resource.
     *
     * Retrieve oEmbed widget resource.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget resource.
     */
    public function get_title()
    {
        return __('TeachGround Lesson resources', 'teachground');
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
        return 'fa fa-link';
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
            'general_content_section',
            [
                'label' => __('General settings', 'teachground'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'post_id',
            [
                'label' => __('Lesson Id (if required)', 'teachground'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'standard_content_section',
            [
                'label' => __('Standard resources', 'teachground'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'st_color',
            [
                'label' => __('Title color', 'teachground'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => 'COLOR_1'
            ]
        );
        $this->add_control(
            'st_background-color',
            [
                'label' => __('Title background color', 'teachground'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => 'COLOR_1'
            ]
        );

        $this->add_control(
            'st_font',
            [
                'label' => __('Title font', 'teachground'),
                'type' => \Elementor\Controls_Manager::FONT
            ]
        );
        $this->add_control(
            'st_font-size',
            [
                'label' => __('Title font size', 'teachground'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 20,
                'step' => 1
            ]
        );
        $this->add_control(
            'st_font-weight',
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
            'st_align',
            [
                'label' => __('Title align', 'teachground'),
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

        $this->add_control(
            'st_content-color',
            [
                'label' => __('Content color', 'teachground'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => 'COLOR_1'
            ]
        );
        $this->add_control(
            'st_content-bg',
            [
                'label' => __('Content background color', 'teachground'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => 'COLOR_1'
            ]
        );


        $this->add_control(
            'st_content-font',
            [
                'label' => __('Content font', 'teachground'),
                'type' => \Elementor\Controls_Manager::FONT
            ]
        );
        $this->add_control(
            'st_content-font-size',
            [
                'label' => __('Content font size', 'teachground'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 20,
                'step' => 1
            ]
        );
        $this->add_control(
            'st_content-font-weight',
            [
                'label' => __('Content font weight', 'teachground'),
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
            'st_content-align',
            [
                'label' => __('Content align', 'teachground'),
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
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Highlighted resources', 'teachground'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
            'background-color',
            [
                'label' => __('Title background color', 'teachground'),
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
                'label' => __('Title align', 'teachground'),
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

        $this->add_control(
            'content-color',
            [
                'label' => __('Content color', 'teachground'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => 'COLOR_1'
            ]
        );
        $this->add_control(
            'content-bg',
            [
                'label' => __('Content background color', 'teachground'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => 'COLOR_1'
            ]
        );


        $this->add_control(
            'content-font',
            [
                'label' => __('Content font', 'teachground'),
                'type' => \Elementor\Controls_Manager::FONT
            ]
        );
        $this->add_control(
            'content-font-size',
            [
                'label' => __('Content font size', 'teachground'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 20,
                'step' => 1
            ]
        );
        $this->add_control(
            'content-font-weight',
            [
                'label' => __('Content font weight', 'teachground'),
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
            'content-align',
            [
                'label' => __('Content align', 'teachground'),
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
        $normal_settings = $this->get_settings_for_display();
?>
        <style>
            .resource-block ul li img,
            .resource-block ul li i {
                margin-right: 8px;
                color: <?php echo $settings['st_color']; ?>;
            }

            .resource-block ul li a:hover {
                color: <?php echo $settings['st_color']; ?>;
            }

            .resource-block {
                margin-top: 15px;
                margin-bottom: 30px;
                background: <?php echo $settings['st_content-bg']; ?>;
                text-align: <?php echo $settings['st_content-align']; ?>;
            }

            .resource-block h4 {
                color: <?php echo $settings['st_color']; ?>;
                background: <?php echo $settings['st_background-color']; ?>;
                text-align: <?php echo $settings['st_align']; ?>;
                text-transform: uppercase;
                font-weight: <?php echo $settings['st_font-weight']; ?>;
                font-family: <?php echo $settings['st_font']; ?>;
                font-size: <?php echo $settings['st_font-size']; ?>px;
            }

            .resource-block ul li {
                border-bottom: 1px solid #DEDFE1;
            }

            .resource-block ul li a {
                font-weight: <?php echo $settings['st_content-font-weight']; ?>;
                font-family: <?php echo $settings['st_content-font']; ?>;
                color: <?php echo $settings['st_content-color']; ?>;
                font-size: <?php echo $settings['st_content-font-size']; ?>px;
            }

            .resource-block-highlight ul li img,
            .resource-block-highlight ul li i {
                margin-right: 8px;
                color: <?php echo $settings['color']; ?>;
            }

            .resource-block-highlight ul li a:hover {
                color: <?php echo $settings['color']; ?>;
            }

            .resource-block-highlight {
                margin-top: 15px;
                margin-bottom: 30px;
                background: <?php echo $settings['content-bg']; ?>;
                text-align: <?php echo $settings['content-align']; ?>;
            }

            .resource-block-highlight h4 {
                color: <?php echo $settings['color']; ?>;
                background: <?php echo $settings['background-color']; ?>;
                text-align: <?php echo $settings['align']; ?>;
                text-transform: uppercase;
                font-weight: <?php echo $settings['font-weight']; ?>;
                font-family: <?php echo $settings['font']; ?>;
                font-size: <?php echo $settings['font-size']; ?>px;
            }

            .resource-block-highlight ul li {
                border-bottom: 1px solid #DEDFE1;
            }

            .resource-block-highlight ul li a {
                font-weight: <?php echo $settings['content-font-weight']; ?>;
                font-family: <?php echo $settings['content-font']; ?>;
                color: <?php echo $settings['content-color']; ?>;
                font-size: <?php echo $settings['content-font-size']; ?>px;
            }
        </style>
<?php
        echo do_shortcode('[tg_resources post_id="' . $settings["post_id"] . '"]');
    }
}
