<?php
/**
 * Navigation widget class.
 *
 * @package TeachGround
 */
namespace TeachGround\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || exit;

class Lesson_Index extends Widget_Abstract {

    /**
     * Get widget name.
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'tg_lesson_index';
    }

    /**
     * Get widget title.
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'Lesson Index', 'teachground' );
    }

    /**
     * Get widget icon.
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-table-of-contents';
	}

	/**
	 * Register content controls
	 *
	 * @access protected
	 *
	 * @return void
	 */
	protected function register_content_controls() {
	}

	/**
	 * Register styles controls.
	 *
	 * @access protected
	 *
	 * @return void
	 */
	protected function register_style_controls() {
	}

    /**
	 * Render widget contents
	 *
	 * @access protected
	 *
	 * @return void
	 */
    protected function render() {
        echo tg_do_shortcode( 'tg_lesson_index' );
    }
}
