<?php

/**
 * Elementor button Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Elementor_Button_Widget extends \Elementor\Widget_Base
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
        return 'tg_button';
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
        return __('TeachGround Mark Complete Button', 'teachground');
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
        return 'fa fa-paperclip';
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
                'label' => __('Not completed style', 'teachground'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'caption',
            [
                'label' => __('Button text (if needed)', 'teachground'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'position',
            [
                'label' => __('Button position', 'teachground'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'center',
                'options' => [
                    'left'  => __('Left', 'teachground'),
                    'center'  => __('Center', 'teachground'),
                    'right' => __('Right', 'teachground')
                ],
            ]
        );

        $this->add_control(
            'color',
            [
                'label' => __('Text color', 'teachground'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => 'COLOR_1'
            ]
        );
        $this->add_control(
            'color-hover',
            [
                'label' => __('Text color on hover', 'teachground'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => 'COLOR_1'
            ]
        );
        $this->add_control(
            'background-color',
            [
                'label' => __('Background color', 'teachground'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => 'COLOR_1'
            ]
        );
        $this->add_control(
            'background-color-hover',
            [
                'label' => __('Background color on hover', 'teachground'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => 'COLOR_1'
            ]
        );

        $this->add_control(
            'font',
            [
                'label' => __('Font', 'teachground'),
                'type' => \Elementor\Controls_Manager::FONT
            ]
        );
        $this->add_control(
            'font-size',
            [
                'label' => __('Font size', 'teachground'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 15,
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
            'height',
            [
                'label' => __('Button Height', 'teachground'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 42,
                'step' => 2
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'border_section',
            [
                'label' => __('Not completed border settings', 'teachground'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'border-radius',
            [
                'label' => __('Border radius', 'teachground'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 0,
                'step' => 1
            ]
        );
        $this->add_control(
            'border-size',
            [
                'label' => __('Border size', 'teachground'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 1,
                'step' => 1
            ]
        );
        $this->add_control(
            'border-color',
            [
                'label' => __('Border color', 'teachground'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => 'COLOR_1'
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'comp_content_section',
            [
                'label' => __('Completed style', 'teachground'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'cc_caption',
            [
                'label' => __('Button text (if needed)', 'teachground'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'cc_color',
            [
                'label' => __('Text color', 'teachground'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => 'COLOR_1'
            ]
        );
        $this->add_control(
            'cc_color-hover',
            [
                'label' => __('Text color on hover', 'teachground'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => 'COLOR_1'
            ]
        );
        $this->add_control(
            'cc_background-color',
            [
                'label' => __('Background color', 'teachground'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => 'COLOR_1'
            ]
        );
        $this->add_control(
            'cc_background-color-hover',
            [
                'label' => __('Background color on hover', 'teachground'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => 'COLOR_1'
            ]
        );

        $this->add_control(
            'cc_font',
            [
                'label' => __('Font', 'teachground'),
                'type' => \Elementor\Controls_Manager::FONT
            ]
        );
        $this->add_control(
            'cc_font-size',
            [
                'label' => __('Font size', 'teachground'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 15,
                'step' => 1
            ]
        );
        $this->add_control(
            'cc_font-weight',
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
            'cc_height',
            [
                'label' => __('Button Height', 'teachground'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 42,
                'step' => 2
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'cc_border_section',
            [
                'label' => __('Completed border settings', 'teachground'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'cc_border-radius',
            [
                'label' => __('Border radius', 'teachground'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 0,
                'step' => 1
            ]
        );
        $this->add_control(
            'cc_border-size',
            [
                'label' => __('Border size', 'teachground'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 1,
                'step' => 1
            ]
        );
        $this->add_control(
            'cc_border-color',
            [
                'label' => __('Border color', 'teachground'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => 'COLOR_1'
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
            .tg-input.text-right {
                text-align: <?php echo $settings['position']; ?>
            }

            #mark-lesson-complete .tg-input input {
                background: <?php echo $settings['background-color'] ? $settings['background-color'] : 'linear-gradient(-90deg, #4F53D3 8%, #5935D1 50%)'; ?>;
                transition: .3s;
                border-radius: 0;
                font-weight: <?php echo $settings['font-weight']; ?>;
                text-transform: uppercase;
                font-family: <?php echo $settings['font']; ?>;
                font-size: <?php echo $settings['font-size']; ?>px;
                height: <?php echo $settings['height']; ?>px;
                color: <?php echo $settings['color']; ?>;
                border: <?php echo $settings['border-color']; ?> <?php echo $settings['border-size']; ?>px solid;
                border-radius: <?php echo $settings['border-radius']; ?>px;
            }

            #mark-lesson-complete .tg-input input:hover {
                background-image: linear-gradient(-90deg, #5935D1 8%, #4F53D3 50%) !important;
                background: <?php echo $settings['background-color-hover'] ? $settings['background-color-hover'] : 'linear-gradient(-90deg, #5935D1 8%, #4F53D3 50%)'; ?> !important;
                ;
                transition: .3s;
                border-radius: 0;
                font-weight: <?php echo $settings['font-weight']; ?>;
                text-transform: uppercase;
                font-family: <?php echo $settings['font']; ?>;
                font-size: <?php echo $settings['font-size']; ?>px;
                color: <?php echo $settings['color-hover']; ?>;
                border: <?php echo $settings['border-color']; ?> <?php echo $settings['border-size']; ?>px solid;
                border-radius: <?php echo $settings['border-radius']; ?>px;
            }

            #mark-lesson-uncomplete-submit {
                background: <?php echo $settings['cc_background-color'] ? $settings['cc_background-color'] : 'linear-gradient(-90deg, #4F53D3 8%, #5935D1 50%)'; ?>;
                transition: .3s;
                border-radius: 0;
                font-weight: <?php echo $settings['cc_font-weight']; ?>;
                text-transform: uppercase;
                font-family: <?php echo $settings['cc_font']; ?>;
                font-size: <?php echo $settings['cc_font-size']; ?>px;
                height: <?php echo $settings['cc_height']; ?>px;
                color: <?php echo $settings['cc_color']; ?>;
                border: <?php echo $settings['cc_border-color']; ?> <?php echo $settings['cc_border-size']; ?>px solid;
                border-radius: <?php echo $settings['cc_border-radius']; ?>px;
            }

            #mark-lesson-uncomplete-submit:hover {
                background: <?php echo $settings['cc_background-color-hover'] ? $settings['cc_background-color-hover'] : 'linear-gradient(-90deg, #5935D1 8%, #4F53D3 50%)'; ?> !important;
                ;
                transition: .3s;
                border-radius: 0;
                font-weight: <?php echo $settings['cc_font-weight']; ?>;
                text-transform: uppercase;
                font-family: <?php echo $settings['cc_font']; ?>;
                font-size: <?php echo $settings['cc_font-size']; ?>px;
                color: <?php echo $settings['cc_color-hover']; ?>;
                border: <?php echo $settings['cc_border-color']; ?> <?php echo $settings['cc_border-size']; ?>px solid;
                border-radius: <?php echo $settings['cc_border-radius']; ?>px;
            }
        </style>
<?php
        echo do_shortcode('[tg_button caption="' . $settings['caption'] . '" cc_caption="' . $settings['cc_caption'] . '"]');
    }
}
