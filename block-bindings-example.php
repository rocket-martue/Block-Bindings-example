<?php
/**
 * Plugin Name: Block Bindings example
 * Description: Block Bindings API を使用するためのサンプルプラグイン
 * Version: 1.0.0
 * Author: Rocket Martue
 * License: GPL3
 * Text Domain: block-bindings-example
 *
 * @package Block_Bindings_Example
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // 直接アクセスされた場合は終了
}

/**
 * 天気データのキャッシュ期間：30分
 * API呼び出し回数を減らし、パフォーマンスを改善
 */
define( 'BB_WEATHER_CACHE_TIME', HOUR_IN_SECONDS / 2 );

require_once plugin_dir_path( __FILE__ ) . 'includes/meta-fields.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/binding-sources.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/weather-api.php';

/**
 * 初期化処理
 */
function bb_init_setup() {
	bb_register_post_meta();
	bb_register_binding_sources();
}
add_action( 'init', 'bb_init_setup' );

/**
 * WP_DEBUG_LOG が有効な場合にデバッグメッセージをログに記録する。
 *
 * @param string $message ログに記録するメッセージ。
 * @return void
 */
function bb_debug_log( $message ) {
	if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log -- Intentional debug logging.
		error_log( $message );
	}
}
