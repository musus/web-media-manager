<?php

/*
Plugin Name: WP Web Media Manager
Description: Multi-function plug-in for all web media.
Version: 1.0
Author: Susumu Seino by aniuma
Author URI: https://aniu.ma
*/


function wpwmm_add_stylesheet() {

	if ( is_admin() or ! is_super_admin() ) {
		return;
	}

	$wp_version = get_bloginfo( 'version' );

	if ( $wp_version >= '3.8' ) {
		$is_older_than_3_8 = '';
	} else {
		$is_older_than_3_8 = '-old';
	}

	$stylesheet_path = plugins_url( 'css/main' . $is_older_than_3_8 . '.css', __FILE__ );
	wp_register_style( 'current-template-style', $stylesheet_path );
	wp_enqueue_style( 'current-template-style' );
	wp_enqueue_script( 'wpwmm', plugins_url( '/js/app.js', __FILE__ ), array( 'jquery' ) );

	wp_enqueue_style( 'thickbox' );
	wp_enqueue_script( 'media-upload' );
	wp_enqueue_script( 'thickbox' );
	wp_enqueue_script( 'jquery' );
}


add_action( 'wp_enqueue_scripts', "wpwmm_add_stylesheet", 9999 );


/*********************************/
/*
/* 基本機能
/*
/*********************************/

$wpwmm_opiton_check = get_option( 'wpwmm_options' );

if( ! isset( $wpwmm_opiton_check['wpwmm_user_icon'] ) ){
	$wpwmm_opiton_check['wpwmm_user_icon'] = '0';
} else if ( $wpwmm_opiton_check['wpwmm_user_icon'] == '1' ) {
	require_once plugin_dir_path( __FILE__ ) . 'inc/wp-user-icon.php';
}

if( ! isset( $wpwmm_opiton_check['wpwmm_rename_file'] ) ){
	$wpwmm_opiton_check['wpwmm_rename_file'] = '0';
} else if ( $wpwmm_opiton_check['wpwmm_rename_file'] == '1' ) {
	function wpwmm_rename_file( $filename ) {
		$info = pathinfo( $filename );
		$ext  = empty( $info['extension'] ) ? '' : '.' . $info['extension'];
		$name = basename( $filename, $ext );

		return md5( $name ) . $ext;
	}
}

if( ! isset( $wpwmm_opiton_check['wpwmm_restrict_dashboard'] ) ){
	$wpwmm_opiton_check['wpwmm_restrict_dashboard'] = '0';
} else if ( $wpwmm_opiton_check['wpwmm_restrict_dashboard'] == '1' ) {
    require_once plugin_dir_path( __FILE__ ) . 'inc/wp-restrict-dashboard.php';
}

if( ! isset( $wpwmm_opiton_check['wpwmm_ga'] ) ){
	$wpwmm_opiton_check['wpwmm_ga'] = '0';
} else if ( $wpwmm_opiton_check['wpwmm_ga']) {
    require_once plugin_dir_path( __FILE__ ) . 'inc/wp-ga.php';
}

add_filter( 'sanitize_file_name', 'wpwmm_rename_file', 10 );


if( ! isset( $wpwmm_opiton_check['wpwmm_show_update_date'] ) ){
	$wpwmm_opiton_check['wpwmm_show_update_date'] = '0';
} else if ( $wpwmm_opiton_check['wpwmm_show_update_date'] == '1' ) {
    require_once plugin_dir_path( __FILE__ ) . 'inc/wp-show-update-date.php';
}

if( ! isset( $wpwmm_opiton_check['wpwmm_revisions'] ) ){
	$wpwmm_opiton_check['wpwmm_revisions'] = '0';
} else if ( $wpwmm_opiton_check['wpwmm_revisions'] ) {
	require_once plugin_dir_path( __FILE__ ) . 'inc/wp-revisions.php';
}

/*********************************/
/*
/* 管理画面
/*
/*********************************/

function wpwmm_init() {
	$wpwmm_options                      = array();
	$wpwmm_options['wpwmm_user_icon']   = 1;
	$wpwmm_options['wpwmm_rename_file'] = 1;
    $wpwmm_options['wpwmm_restrict_dashboard'] = 1;
    $wpwmm_options['wpwmm_ga'] = "";
    $wpwmm_options['wpwmm_show_update_date'] = 1;
	$wpwmm_options['wpwmm_ga'] = "5";
	add_option( 'wpwmm_options', $wpwmm_options );
}

add_action( 'activate_wp-web-media-manager/wp-web-media-manager.php', 'wpwmm_init' );

function wpwmm_get_options() {
	return get_option( 'wpwmm_options' );
}

function wpwmm_config() {
	include( 'wpwmm-admin.php' );
}

function wpwmm_config_page() {
	if ( function_exists( 'add_submenu_page' ) ) {
		add_options_page( __( 'WP Web Media Manager' ), __( 'WP Web Media Manager' ), 'manage_options', 'web-media-manager', 'wpwmm_config' );
	}
}

add_action( 'admin_menu', 'wpwmm_config_page' );
