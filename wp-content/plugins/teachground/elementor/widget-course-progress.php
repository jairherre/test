<?php
/**
 * Course progress widget
 *
 * @package TeachGround
 */
namespace TeachGround\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || exit;

class Course_Progress extends Widget_Abstract {

	/**
	 * Get widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'tg_course_progress';
	}

	/**
	 * Get widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Course Progress', 'teachground' );
	}

	/**
	 * Get widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-skill-bar';
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
				'raw' => __( 'Display course progress of a course lessons and this widget is for course page.', 'teachground' ),
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
		$this->start_controls_section(
			'_section_progress_text_style',
			[
				'label' => __( 'Text', 'teachground'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'text_margin',
			[
				'label' => __( 'Text Margin', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tg-CourseProgressbar__text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'selector' => '{{WRAPPER}} .tg-CourseProgressbar__text',
			]
		);

		$this->add_control(
			'text_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => __( 'Color', 'teachground' ),
				'selectors' => [
					'{{WRAPPER}} .tg-CourseProgressbar__text' => 'color: {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'_section_progress_style',
			[
				'label' => __( 'Progressbar', 'teachground'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'progressbar_margin',
			[
				'label' => __( 'Margin', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tg-CourseProgressbar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'progressbar_size',
			[
				'label' => __( 'Size (px)', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .tg-CourseProgressbar' => 'height: {{SIZE}}px;'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'progressbar_border',
				'selector' => '{{WRAPPER}} .tg-CourseProgressbar',
			]
		);

		$this->add_responsive_control(
			'progressbar_border_radius',
			[
				'label' => __( 'Border Radius', 'teachground' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tg-CourseProgressbar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'progressbar_box_shadow',
				'selector' => '{{WRAPPER}} .tg-CourseProgressbar',
			]
		);

		$this->start_controls_tabs( '_tabs_progress_stats' );
		$this->start_controls_tab(
			'_tab_progress_stat_incomplete',
			[
				'label' => __( 'Incomplete', 'elementor' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'progressbar_incomplete_bg',
				'exclude' => ['image'],
				'selector' => '{{WRAPPER}} .tg-CourseProgressbar',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tab_progress_stat_complete',
			[
				'label' => __( 'Complete', 'elementor' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'progressbar_complete_bg',
				'exclude' => ['image'],
				'selector' => '{{WRAPPER}} .tg-CourseProgressbar__completed',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'_section_progress_msg_style',
			[
				'label' => __( 'Message', 'teachground'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'message_margin',
			[
				'label' => __( 'Text Margin', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tg-CourseProgressbar__msg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'message_padding',
			[
				'label' => __( 'Padding', 'teachground' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tg-CourseProgressbar__msg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'message_typography',
				'selector' => '{{WRAPPER}} .tg-CourseProgressbar__msg',
			]
		);

		$this->add_control(
			'message_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => __( 'Color', 'teachground' ),
				'selectors' => [
					'{{WRAPPER}} .tg-CourseProgressbar__msg' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
			'message_align',
			[
				'label' => __( 'Alignment', 'teachground' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => __( 'Left', 'teachground' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'teachground' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'teachground' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'teachground' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tg-CourseProgressbar__msg' => 'text-align: {{VALUE}};'
				],
				'default' => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget contents
	 *
	 * @access protected
	 *
	 * @return void
	 */
	protected function render() {
		echo tg_do_shortcode( 'tg_course_progressbar' );
	}
}
