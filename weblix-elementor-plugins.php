<?php
/**
 * Plugin Name: Weblix Elementor Plugins
 * Description: Custom Elementor widgets by Weblix.
 * Version: 1.1.0
 * Author: Weblix
 * Text Domain: weblix-elementor
 * Requires Plugins: elementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WEBLIX_ELEMENTOR_PATH', plugin_dir_path( __FILE__ ) );
define( 'WEBLIX_ELEMENTOR_URL', plugin_dir_url( __FILE__ ) );

// Auto-updater: checks self-hosted GitLab for new releases (tags = versions)
require_once WEBLIX_ELEMENTOR_PATH . 'lib/plugin-update-checker/plugin-update-checker.php';

use YahnisElsts\PluginUpdateChecker\v5\Vcs\GitLabApi;
use YahnisElsts\PluginUpdateChecker\v5\Vcs\PluginUpdateChecker as VcsPluginChecker;

$weblix_gitlab_api = new GitLabApi(
	'https://git.hosting.gl/Adrian/weblix-elementor-plugins',
	'glpat-CrUaHqVIC8ilrluDJhHZzW86MQp1OjMH.01.0w0591bm0',
	'git.hosting.gl'
);
$weblix_updater = new VcsPluginChecker( $weblix_gitlab_api, __FILE__, 'weblix-elementor-plugins' );
$weblix_updater->setBranch( 'main' );

final class Weblix_Elementor_Plugins {

	private static $instance = null;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	public function init() {
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', function () {
				echo '<div class="notice notice-error"><p><strong>Weblix Elementor Plugins</strong> wymaga zainstalowanego i aktywnego pluginu <strong>Elementor</strong>.</p></div>';
			} );
			return;
		}

		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
		add_action( 'elementor/frontend/after_register_styles', [ $this, 'register_assets' ] );
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'register_assets' ] );
	}

	public function register_assets() {
		wp_register_style(
			'weblix-wave-ticker',
			WEBLIX_ELEMENTOR_URL . 'widgets/wave-ticker/style.css',
			[],
			filemtime( WEBLIX_ELEMENTOR_PATH . 'widgets/wave-ticker/style.css' )
		);
		wp_register_script(
			'weblix-wave-ticker',
			WEBLIX_ELEMENTOR_URL . 'widgets/wave-ticker/script.js',
			[],
			filemtime( WEBLIX_ELEMENTOR_PATH . 'widgets/wave-ticker/script.js' ),
			true
		);
	}

	public function register_widgets( $widgets_manager ) {
		require_once WEBLIX_ELEMENTOR_PATH . 'widgets/wave-ticker/widget.php';
		$widgets_manager->register( new \Weblix\Widgets\Wave_Ticker() );
	}
}

Weblix_Elementor_Plugins::instance();
