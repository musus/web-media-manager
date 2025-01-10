<?php
$wpwmm_options = get_option( 'wpwmm_options' );
if ( isset( $_POST['submit'] ) ) {

	$wpwmm_options['wpwmm_user_icon']          = sanitize_text_field( wp_unslash( $_POST['wpwmm_user_icon'] ?? '' ) );
	$wpwmm_options['wpwmm_rename_file']        = sanitize_text_field( wp_unslash( $_POST['wpwmm_rename_file'] ?? '' ) );
	$wpwmm_options['wpwmm_restrict_dashboard'] = sanitize_text_field( wp_unslash( $_POST['wpwmm_restrict_dashboard'] ?? '' ) );
	$wpwmm_options['wpwmm_ga']                 = sanitize_text_field( wp_unslash( $_POST['wpwmm_ga'] ?? '' ) );
	$wpwmm_options['wpwmm_show_update_date']   = sanitize_text_field( wp_unslash( $_POST['wpwmm_show_update_date'] ?? '' ) );
	$wpwmm_options['wpwmm_revisions']          = sanitize_text_field( wp_unslash( $_POST['wpwmm_revisions'] ?? '' ) );
	update_option( 'wpwmm_options', $wpwmm_options );
}


$message = '';
?>
<?php if ( ! empty( $_POST ) ) : ?>
	<div id="message" class="updated fade"><p><strong><?php _e( 'Options saved.' ); ?></strong></p></div>
<?php endif; ?>
<div class="wrap">
	<h2><?php _e( 'Web Media Manager Configuration', 'wp-web-media-manager' ); ?></h2>

	<div class="metabox-holder" id="poststuff">
		<div class="meta-box-sortables">
			<script>
				jQuery(document).ready(function ($) {
					$('.postbox').children('h3, .handlediv').click(function () {
						$(this).siblings('.inside').toggle();
					});
				});
			</script>
			<div class="postbox">
				<div title="<?php _e( 'Click to open/close', 'wp-web-media-manager' ); ?>" class="handlediv">
					<br>
				</div>
				<h3 class="hndle"><span><?php _e( 'Hi Web Meida author! Is it good?', 'wp-web-media-manager' ); ?></span></h3>
				<div class="inside" style="display: block;">
					<img src="../wp-content/plugins/web-media-manager/img/icon_coffee.png" alt="buy me a coffee" style="height:60px; margin: 10px; float:left;"/>
					<p>Hi! This plugin from <a href="https://susu.mu?f=wpwmm" target="_blank" title="Susumu Seino">Susumu Seino</a>'s Web Media Manager.</p>
					<p>I'm been spending many hours to develop that plugin. <br/>If you like and use this plugin, you can <strong>buy a cup of coffee</strong>.</p>
				</div>
			</div>
			<form action="" method="post">


				<div class="postbox">
					<div title="<?php _e( 'Click to open/close', 'wp-web-media-manager' ); ?>" class="handlediv">
						<br>
					</div>
					<h3 class="hndle"><span><?php _e( 'Options', 'wp-web-media-manager' ); ?></span></h3>
					<div class="inside" style="display: block;">

						<table class="form-table">
							<tr>
								<th><?php _e( 'User Icon (avatar) Uploader', 'wp-web-media-manager' ); ?></th>
								<td>
									<label for="wpwmm-enabled-ui" style="margin-right: 15px;">
										<input type="radio" name="wpwmm_user_icon" id="wpwmm-enabled-ui" value="1" 
										<?php
										if ( $wpwmm_options['wpwmm_user_icon'] ) {
											echo "checked='checked'"; }
										?>
											/><?php _e( 'Enabled', 'wp-web-media-manager' ); ?></label>
									<label for="wpwmm-disabled-ui">
										<input type="radio" name="wpwmm_user_icon" id="wpwmm-disabled-ui" value="0" 
										<?php
										if ( ! $wpwmm_options['wpwmm_user_icon'] ) {
											echo "checked='checked'"; }
										?>
											/><?php _e( 'Disabled', 'wp-web-media-manager' ); ?></label>
								</td>
							</tr>
							<tr>
								<th><?php _e( 'Rename media on upload', 'wp-web-media-manager' ); ?></th>
								<td>
									<label for="wpwmm-enabled-rf" style="margin-right: 15px;">
										<input type="radio" name="wpwmm_rename_file" id="wpwmm-enabled-rf" value="1" 
										<?php
										if ( $wpwmm_options['wpwmm_rename_file'] ) {
											echo "checked='checked'"; }
										?>
											/><?php _e( 'Enabled', 'wp-web-media-manager' ); ?></label>
									<label for="wpwmm-disabled-rf">
										<input type="radio" name="wpwmm_rename_file" id="wpwmm-disabled-rf" value="0" 
										<?php
										if ( ! $wpwmm_options['wpwmm_rename_file'] ) {
											echo "checked='checked'"; }
										?>
											/><?php _e( 'Disabled', 'wp-web-media-manager' ); ?></label>
								</td>
							</tr>

							<tr>
								<th><?php _e( 'Restrict dashboard access', 'wp-web-media-manager' ); ?></th>
								<td>
									<label for="wpwmm-enabled-ra" style="margin-right: 15px;">
										<input type="radio" name="wpwmm_restrict_dashboard" id="wpwmm-enabled-ra" value="1" 
										<?php
										if ( $wpwmm_options['wpwmm_restrict_dashboard'] ) {
											echo "checked='checked'"; }
										?>
											/><?php _e( 'Enabled', 'wp-web-media-manager' ); ?></label>
									<label for="wpwmm-disabled-ra">
										<input type="radio" name="wpwmm_restrict_dashboard" id="wpwmm-disabled-ra" value="0" 
										<?php
										if ( ! $wpwmm_options['wpwmm_restrict_dashboard'] ) {
											echo "checked='checked'"; }
										?>
											/><?php _e( 'Disabled', 'wp-web-media-manager' ); ?></label>
								</td>
							</tr>

							<tr>
								<th><?php _e( 'Show update date', 'wp-web-media-manager' ); ?></th>
								<td>
									<label for="wpwmm-enabled-ud" style="margin-right: 15px;">
										<input type="radio" name="wpwmm_show_update_date" id="wpwmm-enabled-ud" value="1" 
										<?php
										if ( $wpwmm_options['wpwmm_show_update_date'] ) {
											echo "checked='checked'"; }
										?>
											/><?php _e( 'Enabled', 'wp-web-media-manager' ); ?></label>
									<label for="wpwmm-disabled-ud">
										<input type="radio" name="wpwmm_show_update_date" id="wpwmm-disabled-ud" value="0" 
										<?php
										if ( ! $wpwmm_options['wpwmm_show_update_date'] ) {
											echo "checked='checked'"; }
										?>
											/><?php _e( 'Disabled', 'wp-web-media-manager' ); ?></label>

								</td>
							</tr>

							<tr>
								<th><?php _e( 'Reduce of revisions', 'wp-web-media-manager' ); ?></th>
								<td>
									<label for="wpwmm-enabled-rv" style="margin-right: 15px;">
										<input type="number" name="wpwmm_revisions" id="wpwmm-enabled-rv" value="<?php
										if ( $wpwmm_options['wpwmm_revisions'] ) {
											echo $wpwmm_options['wpwmm_revisions'];}
										?>" />
									</label>
								</td>
							</tr>

							<tr>
								<th><?php _e( 'Google Analytics code', 'wp-web-media-manager' ); ?></th>
								<td>
									<label for="wpwmm-enabled-ga" style="margin-right: 15px;">
										<input type="text" name="wpwmm_ga" id="wpwmm-enabled-ga" value="<?php
										if ( $wpwmm_options['wpwmm_ga'] ) {
											echo $wpwmm_options['wpwmm_ga'];
										}
										?>" />
									</label>
								</td>
							</tr>
							<tr>
								<th></th>
								<td>
									<input type="submit" name="submit" class="button button-primary" value="<?php _e( 'Update options &raquo;' ); ?>"/>
								</td>
							</tr>

						</table>

					</div>
				</div>

			</form>
		</div>
	</div>
