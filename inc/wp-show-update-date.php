<?php
// replace update date
function change_modified( $value, $format, $post ) {
    $post_id = $post->ID;
    $publish_date = get_the_time('Ymd', $post_id);
    $update_date = get_the_modified_date('Ymd', $post_id);

    if ($publish_date < $update_date) {
        return get_the_modified_date('Y.m.d', $post_id);
    } else {
        return get_the_time('Y.m.d', $post_id);
    }

}

add_filter('get_the_date', 'change_modified', 10, 3);