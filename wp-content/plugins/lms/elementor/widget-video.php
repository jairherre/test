<?php

/**
 * Elementor button Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Elementor_Video_Widget extends \Elementor\Widget_Base
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
        return 'lms_video';
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
        return __('LMS Video widget', 'lms');
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
        return 'fa fa-video';
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
        return ['lms-category'];
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
                'label' => __('General Settings', 'lms'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'border-radius',
            [
                'label' => __('Border radius', 'lms'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 0,
                'step' => 1
            ]
        );
        $this->add_control(
            'border-size',
            [
                'label' => __('Border size', 'lms'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 1,
                'step' => 1
            ]
        );
        $this->add_control(
            'border-color',
            [
                'label' => __('Border color', 'lms'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'scheme' => 'COLOR_1'
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => __('Box Shadow', 'lms'),
                'selector' => '.video-wrapper',
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
            #video-emb {
                overflow: hidden;
                border: <?php echo $settings['border-color']; ?> <?php echo $settings['border-size']; ?>px solid;
                border-radius: <?php echo $settings['border-radius']; ?>px;
            }
        </style>
    <?php
        echo '<div id="video-emb" class="video-wrapper">';
        echo do_shortcode('[lms_video post_id="' . get_the_ID() . '"]');
        echo '</div>';
    }

    protected function _content_template()
    {
    ?>
        <style>
            #video-emb {
                overflow: hidden;
                border: <?php echo $settings['border-color']; ?> <?php echo $settings['border-size']; ?>px solid;
                border-radius: <?php echo $settings['border-radius']; ?>px;
            }
        </style>
<?php
        echo '<div id="video-emb" class="video-wrapper">';
        echo do_shortcode('[lms_video post_id="' . get_the_ID() . '"]');
        echo '</div>';
    }
}
