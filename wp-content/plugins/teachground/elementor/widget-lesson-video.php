<?php
/**
 * Lesson video widget class.
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

class Lesson_Video extends Widget_Abstract {

	/**
	 * Get widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'tg_lesson_video';
	}

	/**
	 * Get widget resource.
	 *
	 * @access public
	 *
	 * @return string Widget resource.
	 */
	public function get_title() {
		return __( 'Lesson Video', 'teachground' );
	}

	/**
	 * Get widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-play';
	}

	/**
	 * Register content controls
	 *
	 * @access protected
	 *
	 * @return void
	 */
	protected function register_content_controls() {
		$this->start_controls_section(
			'_section_message',
			[
				'label' => __( 'Message', 'teachground' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'_usage_message',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => __( 'Display lesson video associated with a lesson and this widget is for lesson page.', 'teachground' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->end_controls_section();
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
		$settings = $this->get_settings_for_display();
		echo '<div id="video-emb" class="video-wrapper">';
		echo tg_do_shortcode( 'tg_lesson_video' );
		echo '</div>';
	}
}
