<?php
add_action('admin_init', 'wpwmm_restrict_dashboard');

function wpwmm_restrict_dashboard()
{
    if (!current_user_can('administrator')) {
//        $redirect_url = home_url('');
//        header("Location: " . $redirect_url);
//        exit;
        wp_die('<div id="message" class="updated"><p><b>メンテナンスモード:</b> サイトはメンテナンス中です。管理者に連絡してください。</p></div>');
    }
}