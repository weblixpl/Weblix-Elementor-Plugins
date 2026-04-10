<?php
namespace Weblix\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Wave_Ticker extends \Elementor\Widget_Base {

	public function get_name() {
		return 'weblix-wave-ticker';
	}

	public function get_title() {
		return 'Wave Ticker';
	}

	public function get_icon() {
		return 'eicon-text-area';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	public function get_keywords() {
		return [ 'ticker', 'wave', 'scroll', 'text', 'marquee', 'weblix' ];
	}

	public function get_style_depends() {
		return [ 'weblix-wave-ticker' ];
	}

	public function get_script_depends() {
		return [ 'weblix-wave-ticker' ];
	}

	protected function register_controls() {

		// === CONTENT ===
		$this->start_controls_section( 'section_content', [
			'label' => 'Treść',
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'text', [
			'label'       => 'Tekst',
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'default'     => 'Easter Holiday Workshops 🎨   Easter Holiday Workshops 🎨',
			'placeholder' => 'Wpisz tekst tickera...',
		] );

		$this->end_controls_section();

		// === USTAWIENIA ===
		$this->start_controls_section( 'section_settings', [
			'label' => 'Ustawienia animacji',
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'scroll_speed', [
			'label'   => 'Prędkość przewijania (px/s)',
			'type'    => \Elementor\Controls_Manager::SLIDER,
			'default' => [ 'size' => 100 ],
			'range'   => [ 'px' => [ 'min' => 10, 'max' => 300 ] ],
		] );

		$this->add_control( 'wave_amplitude', [
			'label'   => 'Amplituda fali (px)',
			'type'    => \Elementor\Controls_Manager::SLIDER,
			'default' => [ 'size' => 22 ],
			'range'   => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
		] );

		$this->add_control( 'wave_frequency', [
			'label'   => 'Częstotliwość fali',
			'type'    => \Elementor\Controls_Manager::SLIDER,
			'default' => [ 'size' => 0.35 ],
			'range'   => [ 'px' => [ 'min' => 0.05, 'max' => 2, 'step' => 0.05 ] ],
		] );

		$this->add_control( 'wave_speed', [
			'label'   => 'Prędkość fali',
			'type'    => \Elementor\Controls_Manager::SLIDER,
			'default' => [ 'size' => 2 ],
			'range'   => [ 'px' => [ 'min' => 0.1, 'max' => 10, 'step' => 0.1 ] ],
		] );

		$this->add_control( 'char_spacing', [
			'label'   => 'Odstęp między znakami fali (px)',
			'type'    => \Elementor\Controls_Manager::SLIDER,
			'default' => [ 'size' => 18 ],
			'range'   => [ 'px' => [ 'min' => 5, 'max' => 60 ] ],
		] );

		$this->add_control( 'loop_gap', [
			'label'       => 'Odstęp między powtórzeniami (px)',
			'type'        => \Elementor\Controls_Manager::SLIDER,
			'default'     => [ 'size' => 0 ],
			'range'       => [ 'px' => [ 'min' => 0, 'max' => 600 ] ],
			'description' => '0 = brak przerwy, tekst zlewa się płynnie',
		] );

		$this->end_controls_section();

		// === STYL ===
		$this->start_controls_section( 'section_style', [
			'label' => 'Styl',
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'text_color', [
			'label'     => 'Kolor tekstu',
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '#b94040',
			'selectors' => [
				'{{WRAPPER}} .weblix-wave-ticker__char' => 'color: {{VALUE}};',
			],
		] );

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'selector' => '{{WRAPPER}} .weblix-wave-ticker__char',
			]
		);

		$this->add_control( 'bg_color', [
			'label'     => 'Kolor tła',
			'type'      => \Elementor\Controls_Manager::COLOR,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .weblix-wave-ticker' => 'background-color: {{VALUE}};',
			],
		] );

		$this->add_control( 'padding', [
			'label'      => 'Padding',
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', 'rem' ],
			'default'    => [
				'top'    => '12',
				'right'  => '0',
				'bottom' => '12',
				'left'   => '0',
				'unit'   => 'px',
			],
			'selectors'  => [
				'{{WRAPPER}} .weblix-wave-ticker' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$config = [
			'scrollSpeed'   => (float) $settings['scroll_speed']['size'],
			'waveAmplitude' => (float) $settings['wave_amplitude']['size'],
			'waveFrequency' => (float) $settings['wave_frequency']['size'],
			'waveSpeed'     => (float) $settings['wave_speed']['size'],
			'charSpacing'   => (float) $settings['char_spacing']['size'],
			'gap'           => (float) $settings['loop_gap']['size'],
		];

		wp_enqueue_style( 'weblix-wave-ticker' );
		wp_enqueue_script( 'weblix-wave-ticker' );
		?>
		<div class="weblix-wave-ticker"
			data-config="<?php echo esc_attr( wp_json_encode( $config ) ); ?>"
			data-text="<?php echo esc_attr( $settings['text'] ); ?>">
			<span class="weblix-wave-ticker__sr"><?php echo esc_html( $settings['text'] ); ?></span>
		</div>
		<?php
	}
}
