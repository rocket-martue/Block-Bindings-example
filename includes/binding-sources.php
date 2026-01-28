<?php
/**
 * Block Bindings ソースの登録
 *
 * @package Block_Bindings_Example
 */

/**
 * カスタム Block Bindings ソース「bb/weather-condition」を登録
 */
function bb_register_binding_sources() {

	if ( ! function_exists( 'register_block_bindings_source' ) ) {
		return;
	}

	register_block_bindings_source(
		'bb/weather-condition',
		array(
			'label'              => __( '天気の状態', 'block-bindings-example' ),
			'get_value_callback' => 'bb_get_weather_condition_value',
			'uses_context'       => array( 'postId' ), // 投稿メタを取得するために postId が必要
		)
	);
}

/**
 * 天気の状態バインディングの値を取得するコールバック関数
 *
 * @param array    $source_args     ソース引数（'key' を含む）。
 * @param WP_Block $block_instance  ブロックインスタンス。
 * @return string|null 天気データの値、または取得できない場合は null。
 */
function bb_get_weather_condition_value( array $source_args, WP_Block $block_instance ) {

	$key = $source_args['key'] ?? null;
	if ( ! $key ) {
		return null;
	}

	// ブロックのコンテキストから現在の投稿IDを取得（投稿本文内では常に利用可能）
	$post_id = $block_instance->context['postId'] ?? null;

	// コンテキストが取得できない場合は、グローバルループを使用
	if ( ! $post_id && in_the_loop() ) {
		$post_id = get_the_ID();
	}

	if ( ! $post_id || $post_id <= 0 ) {
		bb_debug_log( 'BB DEBUG: 天気バインディング用の投稿IDを特定できませんでした' );
		return null;
	}

	$weather_data = bb_fetch_and_cache_weather_data( $post_id );

	if ( ! is_array( $weather_data ) || ! isset( $weather_data[ $key ] ) ) {
		return null;
	}

	$value = $weather_data[ $key ];

	// 気温の場合は「°C」を付加
	if ( 'temperature' === $key ) {
		return $value . '°C';
	}

	return $value;
}
