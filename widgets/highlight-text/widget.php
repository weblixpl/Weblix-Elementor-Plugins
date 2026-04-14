<?php
namespace Weblix\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Highlight_Text extends \Elementor\Widget_Base {

	public function get_name() {
		return 'weblix-highlight-text';
	}

	public function get_title() {
		return 'Highlight Text';
	}

	public function get_icon() {
		return 'eicon-heading';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	public function get_keywords() {
		return [ 'highlight', 'heading', 'text', 'glow', 'mark', 'weblix' ];
	}

	public function get_style_depends() {
		return [ 'weblix-highlight-text' ];
	}

	public function get_script_depends() {
		return [ 'weblix-highlight-text' ];
	}

	protected function register_controls() {

		// === TREŚĆ ===
		$this->start_controls_section( 'section_content', [
			'label' => 'Treść',
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'heading_text', [
			'label'       => 'Tekst nagłówka',
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'default'     => 'Twórz [hl]ROLKI[/hl], które chce się oglądać',
			'description' => 'Zaznacz słowa do wyróżnienia używając <code>[hl]słowo[/hl]</code>',
			'rows'        => 4,
		] );

		$this->add_control( 'html_tag', [
			'label'   => 'Tag HTML',
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'h2',
			'options' => [
				'h1'  => 'H1',
				'h2'  => 'H2',
				'h3'  => 'H3',
				'h4'  => 'H4',
				'h5'  => 'H5',
				'h6'  => 'H6',
				'div' => 'div',
				'p'   => 'p',
			],
		] );

		$this->end_controls_section();

		// === STYL: Nagłówek ===
		$this->start_controls_section( 'section_style_heading', [
			'label' => 'Nagłówek',
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'text_color', [
			'label'     => 'Kolor tekstu',
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .weblix-hl-heading' => 'color: {{VALUE}};',
			],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'selector' => '{{WRAPPER}} .weblix-hl-heading',
			]
		);

		$this->add_responsive_control( 'text_align', [
			'label'     => 'Wyrównanie',
			'type'      => \Elementor\Controls_Manager::CHOOSE,
			'options'   => [
				'left'   => [ 'title' => 'Do lewej', 'icon' => 'eicon-text-align-left' ],
				'center' => [ 'title' => 'Środek',   'icon' => 'eicon-text-align-center' ],
				'right'  => [ 'title' => 'Do prawej', 'icon' => 'eicon-text-align-right' ],
			],
			'selectors' => [
				'{{WRAPPER}} .weblix-hl-heading' => 'text-align: {{VALUE}};',
			],
		] );

		$this->end_controls_section();

		// === STYL: Wyróżnienie ===
		$this->start_controls_section( 'section_style_highlight', [
			'label' => 'Wyróżnienie',
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'hl_type', [
			'label'   => 'Typ wyróżnienia',
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'background',
			'options' => [
				'background' => 'Tło',
				'underline'  => 'Podkreślenie',
				'border'     => 'Obramowanie',
			],
		] );

		$this->add_control( 'hl_text_color', [
			'label'     => 'Kolor tekstu wyróżnienia',
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#e8c8ff',
			'selectors' => [
				'{{WRAPPER}} .weblix-hl' => 'color: {{VALUE}};',
			],
		] );

		$this->add_control( 'hl_bg_color', [
			'label'     => 'Kolor tła',
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#7b2fff',
			'selectors' => [
				'{{WRAPPER}} .weblix-hl' => 'background-color: {{VALUE}}; --hl-bg: {{VALUE}};',
			],
			'condition' => [ 'hl_type' => [ 'background', 'border' ] ],
		] );

		$this->add_control( 'hl_border_radius', [
			'label'      => 'Zaokrąglenie rogów',
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', '%' ],
			'default'    => [ 'size' => 0.4, 'unit' => 'em' ],
			'range'      => [
				'px' => [ 'min' => 0, 'max' => 60 ],
				'em' => [ 'min' => 0, 'max' => 3, 'step' => 0.05 ],
				'%'  => [ 'min' => 0, 'max' => 50 ],
			],
			'selectors'  => [
				'{{WRAPPER}} .weblix-hl' => 'border-radius: {{SIZE}}{{UNIT}};',
			],
			'condition'  => [ 'hl_type' => [ 'background', 'border' ] ],
		] );

		$this->add_control( 'hl_padding_x', [
			'label'      => 'Padding poziomy',
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'default'    => [ 'size' => 0.4, 'unit' => 'em' ],
			'range'      => [
				'px' => [ 'min' => 0, 'max' => 40 ],
				'em' => [ 'min' => 0, 'max' => 2, 'step' => 0.05 ],
			],
			'selectors'  => [
				'{{WRAPPER}} .weblix-hl' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
			],
			'condition'  => [ 'hl_type' => [ 'background', 'border' ] ],
		] );

		$this->add_control( 'hl_padding_y', [
			'label'      => 'Padding pionowy',
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'default'    => [ 'size' => 0.05, 'unit' => 'em' ],
			'range'      => [
				'px' => [ 'min' => 0, 'max' => 20 ],
				'em' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ],
			],
			'selectors'  => [
				'{{WRAPPER}} .weblix-hl' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
			],
			'condition'  => [ 'hl_type' => [ 'background', 'border' ] ],
		] );

		$this->add_control( 'hl_border_width', [
			'label'     => 'Grubość obramowania',
			'type'      => \Elementor\Controls_Manager::SLIDER,
			'default'   => [ 'size' => 2 ],
			'range'     => [ 'px' => [ 'min' => 1, 'max' => 10 ] ],
			'selectors' => [
				'{{WRAPPER}} .weblix-hl' => 'border-width: {{SIZE}}px; border-style: solid;',
			],
			'condition' => [ 'hl_type' => 'border' ],
		] );

		$this->add_control( 'hl_border_color', [
			'label'     => 'Kolor obramowania',
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#7b2fff',
			'selectors' => [
				'{{WRAPPER}} .weblix-hl' => 'border-color: {{VALUE}};',
			],
			'condition' => [ 'hl_type' => 'border' ],
		] );

		$this->add_control( 'hl_outline_heading', [
			'label'     => 'Obrys (outline)',
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'hl_outline_width', [
			'label'     => 'Grubość obrysu',
			'type'      => \Elementor\Controls_Manager::SLIDER,
			'default'   => [ 'size' => 0 ],
			'range'     => [ 'px' => [ 'min' => 0, 'max' => 10 ] ],
			'selectors' => [
				'{{WRAPPER}} .weblix-hl' => 'outline-width: {{SIZE}}px; outline-style: solid;',
			],
		] );

		$this->add_control( 'hl_outline_color', [
			'label'     => 'Kolor obrysu',
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#ffffff',
			'selectors' => [
				'{{WRAPPER}} .weblix-hl' => 'outline-color: {{VALUE}};',
			],
			'condition' => [ 'hl_outline_width[size]!' => '0' ],
		] );

		$this->add_control( 'hl_outline_offset', [
			'label'     => 'Offset obrysu',
			'type'      => \Elementor\Controls_Manager::SLIDER,
			'default'   => [ 'size' => 2 ],
			'range'     => [ 'px' => [ 'min' => -10, 'max' => 20 ] ],
			'selectors' => [
				'{{WRAPPER}} .weblix-hl' => 'outline-offset: {{SIZE}}px;',
			],
			'condition' => [ 'hl_outline_width[size]!' => '0' ],
		] );

		$this->add_control( 'hl_underline_color', [
			'label'     => 'Kolor podkreślenia',
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#7b2fff',
			'selectors' => [
				'{{WRAPPER}} .weblix-hl' => '--hl-underline-color: {{VALUE}};',
			],
			'condition' => [ 'hl_type' => 'underline' ],
		] );

		$this->add_control( 'hl_underline_height', [
			'label'      => 'Grubość podkreślenia',
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'default'    => [ 'size' => 4, 'unit' => 'px' ],
			'range'      => [
				'px' => [ 'min' => 1, 'max' => 20 ],
				'em' => [ 'min' => 0.05, 'max' => 1, 'step' => 0.05 ],
			],
			'selectors'  => [
				'{{WRAPPER}} .weblix-hl' => '--hl-underline-height: {{SIZE}}{{UNIT}};',
			],
			'condition'  => [ 'hl_type' => 'underline' ],
		] );

		$this->end_controls_section();

		// === STYL: Efekty ===
		$this->start_controls_section( 'section_style_effects', [
			'label' => 'Efekty',
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'hl_glow', [
			'label'   => 'Efekt glow',
			'type'    => \Elementor\Controls_Manager::SWITCHER,
			'default' => 'yes',
		] );

		$this->add_control( 'hl_glow_color', [
			'label'     => 'Kolor glow',
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#7b2fff',
			'selectors' => [
				'{{WRAPPER}} .weblix-hl' => '--hl-glow-color: {{VALUE}};',
			],
			'condition' => [ 'hl_glow' => 'yes' ],
		] );

		$this->add_control( 'hl_glow_size', [
			'label'     => 'Rozmiar glow (px)',
			'type'      => \Elementor\Controls_Manager::SLIDER,
			'default'   => [ 'size' => 20 ],
			'range'     => [ 'px' => [ 'min' => 2, 'max' => 80 ] ],
			'selectors' => [
				'{{WRAPPER}} .weblix-hl' => '--hl-glow-size: {{SIZE}}px;',
			],
			'condition' => [ 'hl_glow' => 'yes' ],
		] );

		$this->add_control( 'hl_animation', [
			'label'   => 'Animacja',
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'none',
			'options' => [
				'none'    => 'Brak',
				'pulse'   => 'Pulse glow',
				'shimmer' => 'Shimmer',
				'bounce'  => 'Bounce',
			],
		] );

		$this->add_control( 'hl_animation_speed', [
			'label'     => 'Prędkość animacji (s)',
			'type'      => \Elementor\Controls_Manager::NUMBER,
			'default'   => 2,
			'min'       => 0.3,
			'max'       => 10,
			'step'      => 0.1,
			'selectors' => [
				'{{WRAPPER}} .weblix-hl' => '--hl-anim-speed: {{VALUE}}s;',
			],
			'condition' => [ 'hl_animation!' => 'none' ],
		] );

		$this->end_controls_section();
	}

	private static $allowed_tags = [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'p' ];

	protected function render() {
		$settings = $this->get_settings_for_display();

		$tag = $settings['html_tag'] ?? 'h2';
		if ( ! in_array( $tag, self::$allowed_tags, true ) ) {
			$tag = 'h2';
		}

		$hl_type      = $settings['hl_type'] ?? 'background';
		$has_glow     = isset( $settings['hl_glow'] ) && 'yes' === $settings['hl_glow'];
		$animation    = $settings['hl_animation'] ?? 'none';

		$mark_classes = [ 'weblix-hl', 'weblix-hl--' . $hl_type ];
		if ( $has_glow ) {
			$mark_classes[] = 'weblix-hl--glow';
		}
		if ( 'none' !== $animation ) {
			$mark_classes[] = 'weblix-hl--anim-' . $animation;
		}
		$mark_class = implode( ' ', $mark_classes );

		$raw_text = $settings['heading_text'] ?? '';
		$escaped  = esc_html( $raw_text );

		$parsed = preg_replace_callback(
			'/\[hl\](.*?)\[\/hl\]/s',
			static function ( $matches ) use ( $mark_class ) {
				return '<mark class="' . esc_attr( $mark_class ) . '">' . $matches[1] . '</mark>';
			},
			$escaped
		);

		wp_enqueue_style( 'weblix-highlight-text' );
		wp_enqueue_script( 'weblix-highlight-text' );

		echo '<' . $tag . ' class="weblix-hl-heading">' . $parsed . '</' . $tag . '>';
	}
}
