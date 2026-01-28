<?php
/**
 * Meta Fields Registration
 *
 * REST API および Block Bindings のエディターパネルに表示されるカスタムフィールドを登録する。
 *
 * @package Block_Bindings_Example
 */

/**
 * カスタム投稿メタを登録する
 *
 * @return void
 */
function bb_register_post_meta() {

	if ( ! function_exists( 'register_post_meta' ) ) {
		return;
	}

	register_post_meta(
		'post',
		'block_bindings_city_name',
		array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
			'description'   => __( '都市名を入力', 'block-bindings-example' ),
			'label'         => __( '都市名', 'block-bindings-example' ),
			'auth_callback' => 'is_user_logged_in',
		)
	);

	register_post_meta(
		'post',
		'block_bindings_image_url',
		array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
			'description'   => __( '都市の画像URLを入力', 'block-bindings-example' ),
			'label'         => __( '都市画像のURL', 'block-bindings-example' ),
			'auth_callback' => 'is_user_logged_in',
		)
	);

	register_post_meta(
		'post',
		'block_bindings_city_lat',
		array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
			'description'   => __( '都市の緯度を入力', 'block-bindings-example' ),
			'label'         => __( '緯度', 'block-bindings-example' ),
			'auth_callback' => 'is_user_logged_in',
		)
	);

	register_post_meta(
		'post',
		'block_bindings_city_lng',
		array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
			'description'   => __( '都市の経度を入力', 'block-bindings-example' ),
			'label'         => __( '経度', 'block-bindings-example' ),
			'auth_callback' => 'is_user_logged_in',
		)
	);
}
