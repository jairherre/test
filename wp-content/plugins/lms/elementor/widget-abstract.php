<?php
/**
 * Elementor widget base class
 *
 * @package LMS
 */
namespace LMS\Elementor\Widgets;

use Elementor\Widget_Base;

defined( 'ABSPATH' ) || exit;

abstract class Widget_Abstract extends Widget_Base {

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
    public function get_categories() {
        return [ 'lms-category' ];
    }

    /**
     * Register oEmbed widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls() {
        $this->register_content_controls();
        $this->register_style_controls();
    }

    abstract protected function register_content_controls();

    abstract protected function register_style_controls();
}
