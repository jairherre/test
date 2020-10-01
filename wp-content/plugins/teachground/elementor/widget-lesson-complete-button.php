<?php
/**
 * Mark lesson complete button widget
 *
 * @package TeachGround
 */
namespace TeachGround\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || exit;

class Lesson_Complete_Button extends Widget_Abstract {

	/**
	 * Get widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
    public function get_name() {
        return 'tg_lesson_complete_button';
	}

	/**
	 * Get widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
    public function get_title() {
        return __( 'Lesson Complete Button', 'teachground' );
    }

	/**
	 * Get widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
    public function get_icon() {
        return 'eicon-check-circle';
	}

	/**
	 * Get widget keywords, helpful for editor panel serach.
	 *
	 * @access protected
	 *
	 * @return array
	 */
	public function get_keywords() {
		return ['teach', 'ground', 'mark', 'complete', 'button'];
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
			'_section_button_content',
			[
				'label' => __( 'Button', 'teachground' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'complete_button_text',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Button Text', 'teachground' ),
				'placeholder' => __( 'Enter button text', 'teachground' ),
			]
		);

		$this->add_responsive_control(
			'complete_button_align',
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
					'{{WRAPPER}} .tg-Lesson__completeBtnWrap' => 'text-align: {{VALUE}};'
				],
				'default' => '',
			]
		);

		$this->add_control(
			'uncomplete_button_text',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Uncomplete Button Text', 'teachground' ),
				'placeholder' => __( 'Enter button text', 'teachground' ),
			]
		);

		$this->add_responsive_control(
			'uncomplete_button_align',
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
					'{{WRAPPER}} .tg-Lesson__uncompleteBtnWrap' => 'text-align: {{VALUE}};'
				],
				'default' => '',
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
			'_section_complete_button_style',
			[
				'label' => __( 'Complete Button', 'teachground' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label' => __( 'Padding', 'teachground' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tg-Lesson__completeBtn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'selector' => '{{WRAPPER}} .tg-Lesson__completeBtn',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label' => __( 'Border Radius', 'teachground' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tg-Lesson__completeBtn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .tg-Lesson__completeBtn',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'button_text_shadow',
				'selector' => '{{WRAPPER}} .tg-Lesson__completeBtn',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .tg-Lesson__completeBtn',
			]
		);

		$this->start_controls_tabs( '_tabs_button_style' );

		$this->start_controls_tab(
			'_tab_button_normal',
			[
				'label' => __( 'Normal', 'teachground' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => __( 'Text Color', 'teachground' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tg-Lesson__completeBtn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label' => __( 'Background Color', 'teachground' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tg-Lesson__completeBtn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tab_button_hover',
			[
				'label' => __( 'Hover', 'teachground' ),
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label' => __( 'Text Color', 'teachground' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tg-Lesson__completeBtn:hover, {{WRAPPER}} .tg-Lesson__completeBtn:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bg_hover_color',
			[
				'label' => __( 'Background Color', 'teachground' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tg-Lesson__completeBtn:hover, {{WRAPPER}} .tg-Lesson__completeBtn:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'teachground' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .tg-Lesson__completeBtn:hover, {{WRAPPER}} .tg-Lesson__completeBtn:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Uncomplete button
		 */
		$this->start_controls_section(
			'_section_uncomplete_button_style',
			[
				'label' => __( 'Uncomplete Button', 'teachground' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'uncomplete_button_padding',
			[
				'label' => __( 'Padding', 'teachground' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tg-Lesson__uncompleteBtn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'uncomplete_button_border',
				'selector' => '{{WRAPPER}} .tg-Lesson__uncompleteBtn',
			]
		);

		$this->add_control(
			'uncomplete_button_border_radius',
			[
				'label' => __( 'Border Radius', 'teachground' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tg-Lesson__uncompleteBtn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'uncomplete_button_box_shadow',
				'selector' => '{{WRAPPER}} .tg-Lesson__uncompleteBtn',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'uncomplete_button_text_shadow',
				'selector' => '{{WRAPPER}} .tg-Lesson__uncompleteBtn',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'uncomplete_button_typography',
				'selector' => '{{WRAPPER}} .tg-Lesson__uncompleteBtn',
			]
		);

		$this->start_controls_tabs( '_tabs_uncomplete_button_style' );

		$this->start_controls_tab(
			'_tab_uncomplete_button_normal',
			[
				'label' => __( 'Normal', 'teachground' ),
			]
		);

		$this->add_control(
			'uncomplete_button_text_color',
			[
				'label' => __( 'Text Color', 'teachground' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tg-Lesson__uncompleteBtn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'uncomplete_button_bg_color',
			[
				'label' => __( 'Background Color', 'teachground' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tg-Lesson__uncompleteBtn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tab_uncomplete_button_hover',
			[
				'label' => __( 'Hover', 'teachground' ),
			]
		);

		$this->add_control(
			'uncomplete_button_hover_color',
			[
				'label' => __( 'Text Color', 'teachground' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tg-Lesson__uncompleteBtn:hover, {{WRAPPER}} .tg-Lesson__uncompleteBtn:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'uncomplete_button_bg_hover_color',
			[
				'label' => __( 'Background Color', 'teachground' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tg-Lesson__uncompleteBtn:hover, {{WRAPPER}} .tg-Lesson__completeBtn:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'uncomplete_button_hover_border_color',
			[
				'label' => __( 'Border Color', 'teachground' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .tg-Lesson__uncompleteBtn:hover, {{WRAPPER}} .tg-Lesson__completeBtn:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

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

		echo tg_do_shortcode( 'tg_lesson_complete_button', [
			'complete_text'   => $settings['complete_button_text'],
			'uncomplete_text' => $settings['uncomplete_button_text'],
		] );
    }
}
