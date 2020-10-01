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

class Lesson_Resources extends Widget_Abstract {

    public function get_name() {
        return 'lms_resources';
	}

    public function get_title() {
        return __( 'Lesson Resources', 'lms' );
	}

    public function get_icon() {
        return 'fa fa-link';
    }

	protected function register_content_controls() {
		$this->start_controls_section(
			'_section_message',
			[
				'label' => __( 'Message', 'lms' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'_usage_message',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => __( 'Display listed resources associated with a lesson and this widget is for lesson page.', 'lms' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_controls() {
		$this->start_controls_section(
			'_section_style_section',
			[
				'label' => __( 'Section', 'lms' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( '_section_tabs' );

		$this->start_controls_tab(
			'_section_tab_normal',
			[
				'label' => __( 'Normal', 'elementor' ),
			]
		);

		$this->add_responsive_control(
			'section_margin',
			[
				'label' => __( 'Margin', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lms-ResourcesSection' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'section_padding',
			[
				'label' => __( 'Padding', 'lms' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lms-ResourcesSection' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'section_background',
				'selector' => '{{WRAPPER}} .lms-ResourcesSection',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_section_tab_highlight',
			[
				'label' => __( 'Highlight', 'elementor' ),
			]
		);

		$this->add_responsive_control(
			'highlight_section_margin',
			[
				'label' => __( 'Margin', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lms-ResourcesSection.lms-ResourcesSection--highlight' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'highlight_section_padding',
			[
				'label' => __( 'Padding', 'lms' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lms-ResourcesSection.lms-ResourcesSection--highlight' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'highlight_section_background',
				'selector' => '{{WRAPPER}} .lms-ResourcesSection.lms-ResourcesSection--highlight',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Section title
		 */
		$this->start_controls_section(
			'_section_style_section_title',
			[
				'label' => __( 'Section Title', 'lms' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( '_section_title_tabs' );

		$this->start_controls_tab(
			'_section_title_tab_normal',
			[
				'label' => __( 'Normal', 'elementor' ),
			]
		);

		$this->add_responsive_control(
			'section_title_margin',
			[
				'label' => __( 'Margin', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lms-ResourcesSection__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'section_title_padding',
			[
				'label' => __( 'Padding', 'lms' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lms-ResourcesSection__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'section_title_border',
				'selector' => '{{WRAPPER}} .lms-ResourcesSection__title',
			]
		);

		$this->add_control(
			'section_title_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => __( 'Color', 'lms' ),
				'selectors' => [
					'{{WRAPPER}} .lms-ResourcesSection__title' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'section_title_typography',
				'selector' => '{{WRAPPER}} .lms-ResourcesSection__title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'section_title_text_shadow',
				'selector' => '{{WRAPPER}} .lms-ResourcesSection__title',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_section_title_tab_highlight',
			[
				'label' => __( 'Highlight', 'elementor' ),
			]
		);

		$this->add_responsive_control(
			'highlight_section_title_margin',
			[
				'label' => __( 'Margin', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lms-ResourcesSection--highlight .lms-ResourcesSection__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'highlight_section_title_padding',
			[
				'label' => __( 'Padding', 'lms' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lms-ResourcesSection--highlight .lms-ResourcesSection__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'highlight_section_title_border',
				'selector' => '{{WRAPPER}} .lms-ResourcesSection--highlight .lms-ResourcesSection__title',
			]
		);

		$this->add_control(
			'highlight_section_title_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => __( 'Color', 'lms' ),
				'selectors' => [
					'{{WRAPPER}} .lms-ResourcesSection--highlight .lms-ResourcesSection__title' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'highlight_section_title_typography',
				'selector' => '{{WRAPPER}} .lms-ResourcesSection--highlight .lms-ResourcesSection__title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'highlight_section_title_text_shadow',
				'selector' => '{{WRAPPER}} .lms-ResourcesSection--highlight .lms-ResourcesSection__title',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * List
		 */
		$this->start_controls_section(
			'_section_style_list',
			[
				'label' => __( 'List', 'lms' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'list_item_spacing',
			[
				'label' => __( 'Spacing (px)', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .lms-ResourcesList__item:not(:first-child)' => 'margin-bottom: {{SIZE}}px;'
				],
			]
		);

		$this->add_responsive_control(
			'list_item_padding',
			[
				'label' => __( 'Padding', 'lms' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lms-ResourcesList__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'list_item_border',
				'selector' => '{{WRAPPER}} .lms-ResourcesList__item',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'list_item_typography',
				'selector' => '{{WRAPPER}} .lms-ResourcesList__item',
			]
		);

		$this->add_responsive_control(
			'list_item_icon_size',
			[
				'label' => __( 'Icon Size (px)', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .lms-ResourcesList__item i' => 'font-size: {{SIZE}}px;'
				],
			]
		);

		$this->start_controls_tabs( '_tabs_list_item' );

		$this->start_controls_tab(
			'_tabs_list_item_normal',
			[
				'label' => __( 'Normal', 'elementor' ),
			]
		);

		$this->add_control(
			'list_item_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => __( 'Color', 'lms' ),
				'selectors' => [
					'{{WRAPPER}} .lms-ResourcesList__itemLink' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'list_item_icon_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => __( 'Icon Color', 'lms' ),
				'selectors' => [
					'{{WRAPPER}} .lms-ResourcesList__item i' => 'color: {{VALUE}};',
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tabs_list_item_highlight',
			[
				'label' => __( 'Highlight', 'elementor' ),
			]
		);

		$this->add_control(
			'highlight_list_item_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => __( 'Color', 'lms' ),
				'selectors' => [
					'{{WRAPPER}} .lms-ResourcesSection--highlight .lms-ResourcesList__itemLink' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'highlight_list_item_icon_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => __( 'Icon Color', 'lms' ),
				'selectors' => [
					'{{WRAPPER}} .lms-ResourcesSection--highlight .lms-ResourcesList__item i' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'highlight_list_item_border_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => __( 'Border Color', 'lms' ),
				'selectors' => [
					'{{WRAPPER}} .lms-ResourcesSection--highlight .lms-ResourcesList__item' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'list_item_border_border!' => ''
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

    protected function render() {
		$settings = $this->get_settings_for_display();
		echo lms_resources_shortcode();
    }
}
