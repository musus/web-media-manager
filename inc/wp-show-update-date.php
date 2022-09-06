<?php
// replace update date
function change_modified( $value, $format, $post ) {
	$post_id      = $post->ID;
	$publish_date = get_the_time( $format, $post_id );
	$update_date  = get_the_modified_date( $format, $post_id );

	if ( $publish_date < $update_date ) {
		return get_the_modified_date( $format, $post_id );
	} else {
		return get_the_time( $format, $post_id );
	}

}

add_filter( 'get_the_date', 'change_modified', 10, 3 );
