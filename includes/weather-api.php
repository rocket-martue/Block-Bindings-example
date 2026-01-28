<?php
/**
 * Weather API functions for Block Bindings Example.
 *
 * This file contains functions to fetch and cache weather data
 * from the Open-Meteo API.
 *
 * @package Block_Bindings_Example
 */

/**
 * Fetch and cache weather data from Open-Meteo API.
 *
 * @param int $post_id The post ID to fetch weather data for.
 * @return array|false Weather data array or false on failure.
 */
function bb_fetch_and_cache_weather_data( $post_id ) {
	$lat = get_post_meta( $post_id, 'block_bindings_city_lat', true );
	$lng = get_post_meta( $post_id, 'block_bindings_city_lng', true );

	$lat = str_replace( ',', '.', trim( $lat ) );
	$lng = str_replace( ',', '.', trim( $lng ) );

	if ( ! is_numeric( $lat ) || ! is_numeric( $lng ) ) {
		bb_debug_log( 'BB DEBUG: 緯度・経度の値が不正です（正規化後も数値として解釈できません）' );
		return false;
	}

	$transient_key = 'bb_weather_data_' . $post_id;
	$cached_data   = get_transient( $transient_key );

	if ( false !== $cached_data ) {
		bb_debug_log( "BB DEBUG: キャッシュを使用します（post_id: {$post_id}）" );
		return $cached_data;
	}

	// Open-Meteo API のURLを組み立て
	$api_url = sprintf(
		'https://api.open-meteo.com/v1/forecast?latitude=%s&longitude=%s¤t=weather_code,temperature_2m',
		rawurlencode( $lat ),
		rawurlencode( $lng )
	);

	bb_debug_log( "BB DEBUG: 天気データを取得します: {$api_url}" );

	$response = wp_remote_get( $api_url, array( 'timeout' => 10 ) );

	if ( is_wp_error( $response ) ) {
		bb_debug_log( 'BB DEBUG: APIリクエストに失敗しました – ' . $response->get_error_message() );
		return false;
	}

	if ( wp_remote_retrieve_response_code( $response ) !== 200 ) {
		bb_debug_log( 'BB DEBUG: APIが200以外のステータスコードを返しました' );
		return false;
	}

	$body = wp_remote_retrieve_body( $response );
	$data = json_decode( $body, true );

	if ( ! $data || ! isset( $data['current'] ) ) {
		bb_debug_log( 'BB DEBUG: APIレスポンスが空、または形式が想定と異なります' );
		return false;
	}

	$temperature  = $data['current']['temperature_2m'] ?? null;
	$weather_code = $data['current']['weather_code'] ?? 0;

	$mapped_data = array(
		'temperature'   => round( (float) $temperature ),
		'weather_state' => bb_map_wmo_code_to_state( (int) $weather_code ),
	);

	// Cache for 30 minutes
	set_transient( $transient_key, $mapped_data, BB_WEATHER_CACHE_TIME );

	bb_debug_log( 'BB DEBUG: 天気データを取得し、キャッシュしました' );

	return $mapped_data;
}

/**
 * Map WMO weather code to a simplified weather state string.
 *
 * @param int $code WMO weather code from Open-Meteo API.
 * @return string Weather state: 'clear', 'rainy', 'snowy', 'thunderstorm', or 'cloudy'.
 */
function bb_map_wmo_code_to_state( $code ) {
	if ( $code >= 0 && $code <= 3 ) {
		return 'clear';
	} elseif ( $code >= 51 && $code <= 67 ) {
		return 'rainy';
	} elseif ( $code >= 71 && $code <= 77 ) {
		return 'snowy';
	} elseif ( $code >= 95 ) {
		return 'thunderstorm';
	}
	return 'cloudy';
}
