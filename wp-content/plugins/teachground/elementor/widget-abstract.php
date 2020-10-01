<?php
/**
 * Elementor widget base class
 *
 * @package TeachGround
 */
namespace TeachGround\Elementor\Widgets;

use Elementor\Widget_Base;

defined( 'ABSPATH' ) || exit;

abstract class Widget_Abstract extends Widget_Base {

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the oEmbed widget belongs to.
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'teachground-category' ];
    }

    /**
     * Register widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @access protected
     */
    protected function _register_controls() {
        $this->register_content_controls();
        $this->register_style_controls();
    }

	/**
	 * Register content controls.
	 *
	 * @access protected
	 * @return void
	 */
    abstract protected function register_content_controls();

	/**
	 * Register style controls.
	 *
	 * @access protected
	 * @return void
	 */
    abstract protected function register_style_controls();
}
