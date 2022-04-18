<?php

add_action('wp_head', 'wp_google_analytics', 10);

function wp_google_analytics()
{
    $wpwmm_options = get_option( 'wpwmm_options' );

    if ( isset( $wpwmm_options['wpwmm_ga'] ) ){

    ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $wpwmm_options['wpwmm_ga']; ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', '<?php echo $wpwmm_options['wpwmm_ga'];?>');
    </script>
    <?php
	}
}

