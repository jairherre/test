<?php
/**
 * Course List widget class.
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

class Course_List extends Widget_Abstract {

	/**
	 * Get widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'tg_course_list';
	}

	/**
	 * Get widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Course List', 'teachground' );
	}

	/**
	 * Get widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-posts-grid';
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
			'_section_query_settings',
			[
				'label' => __( 'Query Settings', 'teachground' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$taxonomy = 'tg_course_category';
		$terms = get_terms($taxonomy);

		$options = [];
		foreach ($terms as $value) {
			$options[$value->term_id] = $value->name;
		}

		$this->add_control(
			'is_user_only',
			[
				'label' => __( 'Show Only User Courses', 'teachground' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'assigned_first',
			[
				'label' => __( 'Show Assigned Courses First', 'teachground' ),
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
				'label' => __( 'Select Categories', 'teachground' ),
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
				'label' => __( 'Settings', 'teachground' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_image',
			[
				'label' => __( 'Show Image', 'teachground' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);

		$this->add_control(
			'show_title',
			[
				'label' => __( 'Show Title', 'teachground' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label' => __( 'Show Excerpt', 'teachground' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);

		$this->add_control(
			'show_progressbar',
			[
				'label' => __( 'Show Progressbar', 'teachground' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);

		$this->add_control(
			'show_author',
			[
				'label' => __( 'Show Author', 'teachground' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);

		$this->add_control(
			'show_completed',
			[
				'label' => __( 'Show Completed', 'teachground' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => __( 'Columns', 'teachground' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					2 => __( '2 Columns', 'teachground' ),
					3 => __( '3 Columns', 'teachground' ),
					4 => __( '4 Columns', 'teachground' ),
					5 => __( '5 Columns', 'teachground' ),
				],
				'default' => 3,
				'selectors' => [
					'{{WRAPPER}} .tg-CourseList' => '--tg-columns: {{VALUE}};'
				]
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Register styles controls.
	 *
	 * @access protected
	 * @return void
	 */
	protected function register_style_controls() {
		$this->start_controls_section(
			'_section_course_item',
			[
				'label' => __( 'Course Item', 'teachground' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[
				'label' => __( 'Padding', 'teachground' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tg-CourseCard' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .tg-CourseList' => '--tg-spacing: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'item_border',
				'selector' => '{{WRAPPER}} .tg-CourseCard',
			]
		);

		$this->add_responsive_control(
			'item_border_radius',
			[
				'label' => __( 'Border Radius', 'teachground' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tg-CourseCard' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'item_box_shadow',
				'selector' => '{{WRAPPER}} .tg-CourseCard',
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
				'selector' => '{{WRAPPER}} .tg-CourseCard',
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
				'selector' => '{{WRAPPER}} .tg-CourseCard:hover',
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
					'{{WRAPPER}} .tg-CourseCard' => 'transition: background {{SIZE}}s',
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
				'label' => __( 'Featured Image', 'teachground' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_padding',
			[
				'label' => __( 'Padding', 'teachground' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tg-CourseCard__figure img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_spacing',
			[
				'label' => __( 'Bottom Spacing (px)', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .tg-CourseCard__figure' => 'margin-bottom: {{SIZE}}px;'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} .tg-CourseCard__figure img',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' => __( 'Border Radius', 'teachground' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tg-CourseCard__figure img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_box_shadow',
				'selector' => '{{WRAPPER}} .tg-CourseCard__figure img',
			]
		);

		$this->end_controls_section();

		/**
		 * Title
		 */
		$this->start_controls_section(
			'_section_course_title',
			[
				'label' => __( 'Title', 'teachground' ),
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
					'{{WRAPPER}} .tg-CourseCard__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .tg-CourseCard__title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_text_shadow',
				'selector' => '{{WRAPPER}} .tg-CourseCard__title',
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
				'label' => __( 'Color', 'teachground' ),
				'selectors' => [
					'{{WRAPPER}} .tg-CourseCard__title a' => 'color: {{VALUE}};',
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
				'label' => __( 'Color', 'teachground' ),
				'selectors' => [
					'{{WRAPPER}} .tg-CourseCard__title a:hover, {{WRAPPER}} .tg-CourseCard__title a:focus' => 'color: {{VALUE}};',
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
				'label' => __( 'Excerpt', 'teachground' ),
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
					'{{WRAPPER}} .tg-CourseCard__excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'excerpt_typography',
				'selector' => '{{WRAPPER}} .tg-CourseCard__excerpt',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'excerpt_text_shadow',
				'selector' => '{{WRAPPER}} .tg-CourseCard__excerpt',
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => __( 'Color', 'teachground' ),
				'selectors' => [
					'{{WRAPPER}} .tg-CourseCard__excerpt' => 'color: {{VALUE}};',
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
				'label' => __( 'Progressbar', 'teachground' ),
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
					'{{WRAPPER}} .tg-CourseCard__progressbar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'progressbar_size',
			[
				'label' => __( 'Size (px)', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .tg-CourseCard__progressbar' => 'height: {{SIZE}}px;'
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

		/**
		 * Author
		 */
		$this->start_controls_section(
			'_section_course_author',
			[
				'label' => __( 'Author', 'teachground' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'author_typography',
				'selector' => '{{WRAPPER}} .tg-CourseCard__author',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'author_text_shadow',
				'selector' => '{{WRAPPER}} .tg-CourseCard__author',
			]
		);

		$this->add_control(
			'author_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => __( 'Color', 'teachground' ),
				'selectors' => [
					'{{WRAPPER}} .tg-CourseCard__author' => 'color: {{VALUE}};',
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
				'label' => __( 'Completed', 'teachground' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'completed_typography',
				'selector' => '{{WRAPPER}} .tg-CourseCard__completed',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'completed_text_shadow',
				'selector' => '{{WRAPPER}} .tg-CourseCard__completed',
			]
		);

		$this->add_control(
			'completed_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => __( 'Color', 'teachground' ),
				'selectors' => [
					'{{WRAPPER}} .tg-CourseCard__completed' => 'color: {{VALUE}};',
				]
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
		$settings = $this->get_settings_for_display();
		$categories =  ( ! empty( $settings['categories'] ) ? implode( ',', $settings['categories'] ) : '' );

		$args = array(
			'show_image'       => $settings['show_image'],
			'show_title'       => $settings['show_title'],
			'show_excerpt'     => $settings['show_excerpt'],
			'show_progressbar' => $settings['show_progressbar'],
			'show_author'      => $settings['show_author'],
			'show_completed'   => $settings['show_completed'],
			'categories'       => $categories,
		);

		if ( $settings['is_user_only'] == 'yes' ) {
			echo tg_do_shortcode( 'tg_user_courses', $args );
			return;
		}

		if ( $settings['assigned_first'] == 'yes' ) {
			echo tg_do_shortcode( 'tg_user_courses', $args );

			$args['assigned_first'] = 'yes';
			echo tg_do_shortcode( 'tg_course_list', $args );
		} else {
			$args['assigned_first'] = 'no';
			echo tg_do_shortcode( 'tg_course_list', $args );
		}
	}
}
