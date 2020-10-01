<?php
/**
 * All courses widget class.
 *
 * @package LMS
 */
namespace LMS\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || exit;

class All_Courses extends Widget_Abstract {

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
	public function get_name() {
		return 'lms_all_courses';
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
	public function get_title() {
		return __( 'All Courses', 'lms' );
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
	public function get_icon() {
		return 'fa fa-list';
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_content_controls() {
		$this->start_controls_section(
			'_section_query_settings',
			[
				'label' => __( 'Query Settings', 'lms' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$taxonomy = 'lms_course_category';
		$terms = get_terms($taxonomy);

		$options = [];
		foreach ($terms as $value) {
			$options[$value->term_id] = $value->name;
		}

		$this->add_control(
			'is_user_only',
			[
				'label' => __( 'Show Only User Courses', 'lms' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'assigned_first',
			[
				'label' => __( 'Show Assigned Courses First', 'lms' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'is_user_only' => ''
				],
				'default' => 'no'
			]
		);

		$this->add_control(
			'categories',
			[
				'label' => __( 'Select Categories', 'lms' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => $options,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'_section_display_settings',
			[
				'label' => __( 'Settings', 'lms' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_featured_image',
			[
				'label' => __( 'Show Featured Image', 'lms' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);

		$this->add_control(
			'show_title',
			[
				'label' => __( 'Show Title', 'lms' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label' => __( 'Show Excerpt', 'lms' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);

		$this->add_control(
			'show_progressbar',
			[
				'label' => __( 'Show Progressbar', 'lms' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);

		$this->add_control(
			'show_author',
			[
				'label' => __( 'Show Author', 'lms' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);

		$this->add_control(
			'show_completed',
			[
				'label' => __( 'Show Completed', 'lms' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => __( 'Columns', 'lms' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					2 => __( '2 Columns', 'lms' ),
					3 => __( '3 Columns', 'lms' ),
					4 => __( '4 Columns', 'lms' ),
					5 => __( '5 Columns', 'lms' ),
				],
				'default' => 3,
				'selectors' => [
					'{{WRAPPER}} .lms-CoursesList' => '--lms-columns: {{VALUE}};'
				]
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_controls() {
		$this->start_controls_section(
			'_section_course_item',
			[
				'label' => __( 'Course Item', 'lms' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[
				'label' => __( 'Padding', 'lms' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lms-CourseCard' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_spacing',
			[
				'label' => __( 'Spacing (px)', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lms-CoursesList' => '--lms-spacing: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'item_border',
				'selector' => '{{WRAPPER}} .lms-CourseCard',
			]
		);

		$this->add_responsive_control(
			'item_border_radius',
			[
				'label' => __( 'Border Radius', 'lms' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lms-CourseCard' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'item_box_shadow',
				'selector' => '{{WRAPPER}} .lms-CourseCard',
			]
		);

		$this->start_controls_tabs( '_item_tabs_background', [
			'separator' => 'before',
		] );

		$this->start_controls_tab(
			'_item_tab_background_normal',
			[
				'label' => __( 'Normal', 'elementor' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'item_background',
				'selector' => '{{WRAPPER}} .lms-CourseCard',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_item_tab_background_hover',
			[
				'label' => __( 'Hover', 'elementor' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'item_background_hover',
				'selector' => '{{WRAPPER}} .lms-CourseCard:hover',
			]
		);

		$this->add_control(
			'item_background_hover_transition',
			[
				'label' => __( 'Transition Duration', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .lms-CourseCard' => 'transition: background {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Featured image
		 */
		$this->start_controls_section(
			'_section_course_featured_image',
			[
				'label' => __( 'Featured Image', 'lms' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_padding',
			[
				'label' => __( 'Padding', 'lms' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lms-CourseCard__figure img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_spacing',
			[
				'label' => __( 'Bottom Spacing (px)', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .lms-CourseCard__figure' => 'margin-bottom: {{SIZE}}px;'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} .lms-CourseCard__figure img',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' => __( 'Border Radius', 'lms' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lms-CourseCard__figure img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_box_shadow',
				'selector' => '{{WRAPPER}} .lms-CourseCard__figure img',
			]
		);

		$this->end_controls_section();

		/**
		 * Title
		 */
		$this->start_controls_section(
			'_section_course_title',
			[
				'label' => __( 'Title', 'lms' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label' => __( 'Margin', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lms-CourseCard__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .lms-CourseCard__title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_text_shadow',
				'selector' => '{{WRAPPER}} .lms-CourseCard__title',
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
			'title_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => __( 'Color', 'lms' ),
				'selectors' => [
					'{{WRAPPER}} .lms-CourseCard__title a' => 'color: {{VALUE}};',
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
			'title_hover_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => __( 'Color', 'lms' ),
				'selectors' => [
					'{{WRAPPER}} .lms-CourseCard__title a:hover, {{WRAPPER}} .lms-CourseCard__title a:focus' => 'color: {{VALUE}};',
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Excerpt
		 */
		$this->start_controls_section(
			'_section_course_excerpt',
			[
				'label' => __( 'Excerpt', 'lms' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'excerpt_margin',
			[
				'label' => __( 'Margin', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lms-CourseCard__excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'excerpt_typography',
				'selector' => '{{WRAPPER}} .lms-CourseCard__excerpt',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'excerpt_text_shadow',
				'selector' => '{{WRAPPER}} .lms-CourseCard__excerpt',
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => __( 'Color', 'lms' ),
				'selectors' => [
					'{{WRAPPER}} .lms-CourseCard__excerpt' => 'color: {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();

		/**
		 * Progressbar
		 */
		$this->start_controls_section(
			'_section_course_progressbar',
			[
				'label' => __( 'Progressbar', 'lms' ),
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
					'{{WRAPPER}} .lms-CourseCard__progressbar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'progressbar_size',
			[
				'label' => __( 'Size (px)', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .lms-CourseCard__progressbar' => 'height: {{SIZE}}px;'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'progressbar_border',
				'selector' => '{{WRAPPER}} .lms-CourseProgressbar',
			]
		);

		$this->add_responsive_control(
			'progressbar_border_radius',
			[
				'label' => __( 'Border Radius', 'lms' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lms-CourseProgressbar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'progressbar_box_shadow',
				'selector' => '{{WRAPPER}} .lms-CourseProgressbar',
			]
		);

		$this->end_controls_section();

		/**
		 * Author
		 */
		$this->start_controls_section(
			'_section_course_author',
			[
				'label' => __( 'Author', 'lms' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'author_typography',
				'selector' => '{{WRAPPER}} .lms-CourseCard__author',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'author_text_shadow',
				'selector' => '{{WRAPPER}} .lms-CourseCard__author',
			]
		);

		$this->add_control(
			'author_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => __( 'Color', 'lms' ),
				'selectors' => [
					'{{WRAPPER}} .lms-CourseCard__author' => 'color: {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();

		/**
		 * Completed
		 */
		$this->start_controls_section(
			'_section_course_completed',
			[
				'label' => __( 'Completed', 'lms' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'completed_typography',
				'selector' => '{{WRAPPER}} .lms-CourseCard__completed',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'completed_text_shadow',
				'selector' => '{{WRAPPER}} .lms-CourseCard__completed',
			]
		);

		$this->add_control(
			'completed_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => __( 'Color', 'lms' ),
				'selectors' => [
					'{{WRAPPER}} .lms-CourseCard__completed' => 'color: {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$categories =  ( ! empty( $settings['categories'] ) ? implode( ',', $settings['categories'] ) : '' );

		$atts = array(
			'show_featured_image' => $settings['show_featured_image'],
			'show_title'          => $settings['show_title'],
			'show_excerpt'        => $settings['show_excerpt'],
			'show_progressbar'    => $settings['show_progressbar'],
			'show_author'         => $settings['show_author'],
			'show_completed'      => $settings['show_completed'],
			'categories'          => $categories,
		);

		if ( $settings['is_user_only'] == 'yes' ) {
			echo lms_user_courses_shortcode( $atts );
			return;
		}

		if ( $settings['assigned_first'] == 'yes' ) {
			echo lms_user_courses_shortcode( $atts );
			$atts['assigned_first'] = 'yes';
			echo lms_all_courses_shortcode( $atts );
		} else {
			$atts['assigned_first'] = 'no';
			echo lms_all_courses_shortcode( $atts );
		}
	}
}
