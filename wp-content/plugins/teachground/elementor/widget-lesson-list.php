<?php
/**
 * Lessons widget class.
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

class Lesson_List extends Widget_Abstract {

	/**
	 * Get widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'tg_lesson_list';
	}

	/**
	 * Get widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Lesson List', 'teachground' );
	}

	/**
	 * Get widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-editor-list-ol';
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
				'raw' => __( 'You can create a lessons list associated with a course and hence this widget is only functional on course page.', 'teachground' ),
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
			'_section_style_lessons_section',
			[
				'label' => __( 'Section', 'teachground' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'lessons_section_margin',
			[
				'label' => __( 'Margin', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tg-LessonListSection' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lessons_section_padding',
			[
				'label' => __( 'Padding', 'teachground' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tg-LessonListSection' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'lessons_section_background',
				'selector' => '{{WRAPPER}} .tg-LessonListSection',
				'exclude' => [ 'image' ]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'_section_style_lessons_title',
			[
				'label' => __( 'Section Title', 'teachground' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'section_title_margin',
			[
				'label' => __( 'Margin', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tg-LessonListTitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'section_title_padding',
			[
				'label' => __( 'Padding', 'teachground' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tg-LessonListTitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'section_title_border',
				'selector' => '{{WRAPPER}} .tg-LessonListTitle',
			]
		);

		$this->add_responsive_control(
			'section_title_border_radius',
			[
				'label' => __( 'Border Radius', 'teachground' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tg-LessonListTitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'section_title_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => __( 'Color', 'teachground' ),
				'selectors' => [
					'{{WRAPPER}} .tg-LessonListTitle' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'section_title_background',
				'selector' => '{{WRAPPER}} .tg-LessonListTitle',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'section_title_typography',
				'selector' => '{{WRAPPER}} .tg-LessonListTitle',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'section_title_text_shadow',
				'selector' => '{{WRAPPER}} .tg-LessonListTitle',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'section_title_box_shadow',
				'selector' => '{{WRAPPER}} .tg-LessonListTitle',
			]
		);

		$this->end_controls_section();

		/**
		 * Lesson
		 */
		$this->start_controls_section(
			'_section_style_lesson',
			[
				'label' => __( 'Lesson', 'teachground' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'lesson_margin',
			[
				'label' => __( 'Margin', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tg-LessonList__lesson' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'lesson_padding',
			[
				'label' => __( 'Padding', 'teachground' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tg-LessonList__lesson' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'lesson_border',
				'selector' => '{{WRAPPER}} .tg-LessonList__lesson',
			]
		);

		$this->end_controls_section();

		/**
		 * Lessons Icon
		 */
		$this->start_controls_section(
			'_section_style_lesson_icon',
			[
				'label' => __( 'Lesson Icon', 'teachground' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'lesson_icon_spacing',
			[
				'label' => __( 'Spacing (px)', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .tg-LessonList__lessonIcon' => 'margin-right: {{SIZE}}px;'
				],
			]
		);

		$this->add_responsive_control(
			'lesson_icon_size',
			[
				'label' => __( 'Size (px)', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .tg-LessonList__lessonIcon' => 'font-size: {{SIZE}}px;'
				],
			]
		);

		$this->add_control(
			'lesson_icon_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => __( 'Color', 'teachground' ),
				'selectors' => [
					'{{WRAPPER}} .tg-LessonList__lessonIcon' => 'color: {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();

		/**
		 * Lessons Title
		 */
		$this->start_controls_section(
			'_section_style_lesson_title',
			[
				'label' => __( 'Lesson Title', 'teachground' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'lesson_title_typography',
				'selector' => '{{WRAPPER}} .tg-LessonList__lessonTitle',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'lesson_title_text_shadow',
				'selector' => '{{WRAPPER}} .tg-LessonList__lessonTitle',
			]
		);

		$this->start_controls_tabs( '_tabs_title_stats' );

		$this->start_controls_tab(
			'_tab_title_stat_normal',
			[
				'label' => __( 'Normal', 'elementor' ),
			]
		);

		$this->add_control(
			'lesson_title_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => __( 'Color', 'teachground' ),
				'selectors' => [
					'{{WRAPPER}} .tg-LessonList__lessonTitle' => 'color: {{VALUE}};',
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tab_title_stat_hover',
			[
				'label' => __( 'Hover', 'elementor' ),
			]
		);

		$this->add_control(
			'lesson_title_hover_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => __( 'Color', 'teachground' ),
				'selectors' => [
					'{{WRAPPER}} .tg-LessonList__lessonTitle:hover, {{WRAPPER}} .tg-LessonList__lessonTitle:focus' => 'color: {{VALUE}};',
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();


		/**
		 * Free badge
		 */
		$this->start_controls_section(
			'_section_style_lessons_free',
			[
				'label' => __( 'Free Badge', 'teachground' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'free_badge_padding',
			[
				'label' => __( 'Padding', 'teachground' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tg-LessonList__lessonFree' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'free_badge_border',
				'selector' => '{{WRAPPER}} .tg-LessonList__lessonFree',
			]
		);

		$this->add_responsive_control(
			'free_badge_border_radius',
			[
				'label' => __( 'Border Radius', 'teachground' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tg-LessonList__lessonFree' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'free_badge_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => __( 'Color', 'teachground' ),
				'selectors' => [
					'{{WRAPPER}} .tg-LessonList__lessonFree' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'free_badge_background_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => __( 'Background Color', 'teachground' ),
				'selectors' => [
					'{{WRAPPER}} .tg-LessonList__lessonFree' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'free_badge_typography',
				'selector' => '{{WRAPPER}} .tg-LessonList__lessonFree',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'free_badge_text_shadow',
				'selector' => '{{WRAPPER}} .tg-LessonList__lessonFree',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'free_badge_box_shadow',
				'selector' => '{{WRAPPER}} .tg-LessonList__lessonFree',
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
		echo tg_do_shortcode( 'tg_lesson_list' );
	}
}
