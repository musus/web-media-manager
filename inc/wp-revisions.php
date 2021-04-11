<?php

add_filter( 'wp_revisions_to_keep', 'wpwmm_revisions', 10, 2 );

function wpwmm_revisions( $num ) {
	$wpwmm_options = get_option( 'wpwmm_options' );
	$num           = $wpwmm_options['wpwmm_revisions'];

	return $num;
}

