<?php

add_action( 'show_user_profile', 'wp_user_icon_fields' );
add_action( 'edit_user_profile', 'wp_user_icon_fields' );

function media_uploader_enqueue() {
	wp_enqueue_media();
	wp_register_script('media-uploader', plugins_url('media-uploader.js' , __FILE__ ), array('jquery'));
	wp_enqueue_script('media-uploader');
}
add_action('admin_enqueue_scripts', 'media_uploader_enqueue');


function wp_user_icon_fields( $user ) { ?>
	<style>
		.user-profile-picture {
			display: none;
		}
	</style>

	<h3>プロフィール写真</h3>

	<table class="form-table">
		<tr class="user-profile-picture--wpui">
			<th>現在のプロフィール</th>
			<td>
				<?php
				// If is current user's profile (profile.php)
				if ( defined('IS_PROFILE_PAGE') && IS_PROFILE_PAGE ) {
					$user_id = get_current_user_id();
					// If is another user's profile page
				} elseif (! empty($_GET['user_id']) && is_numeric($_GET['user_id']) ) {
					$user_id = $_GET['user_id'];
					// Otherwise something is wrong.
				} else {
					die( 'No user id defined.' );
				}
				$author_id = $user_id;
				$avatar = get_avatar( $author_id );
				echo $avatar;
				?>
			</td>
		</tr>

		<tr>
			<th><label for="image">写真をアップロード</label></th>

			<td>
				<form action="">
					<input type="text" name="wp_user_icon" id="upload_image" value="<?php echo esc_attr( get_the_author_meta( 'wp_user_icon', $user->ID ) ); ?>" class="regular-text"/>
					<p class="description"><input type='button' class="button" value="画像選択" id="upload_btn"/>  <input type='button' id="wpui_clear" class="clear-button button" value="リセット"/></p>
					<p class="description">画像選択・リセットを押した後はプロフィールを更新してください</p>
				</form>
			</td>
		</tr>

	</table>

<?php }

/*
 * Script for saving profile image
 *
 */
add_action( 'admin_head', 'wp_user_icon_upload_js' );
//wp_enqueue_script('media-upload');
//wp_enqueue_script('thickbox');
//wp_enqueue_style('thickbox');
function wp_user_icon_upload_js() { ?>

	<script type="text/javascript">

        jQuery(document).ready(function($){
            var mediaUploader;
            $('#upload_btn').click(function(e) {
                e.preventDefault();
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }
                mediaUploader = wp.media.frames.file_frame = wp.media({
                     multiple: false });
                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#upload_image').val(attachment.url);
                });
                mediaUploader.open();
            });
        });

        jQuery(function($){
            $("#wpui_clear").click(function () {
                $("#upload_image").val("");
            });
        });

	</script>
<?php }

/*
 * Save custom user profile data
 *
 */
add_action( 'personal_options_update', 'wp_user_icon_save_fields' );
add_action( 'edit_user_profile_update', 'wp_user_icon_save_fields' );
function wp_user_icon_save_fields( $user_id ) {
	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}
	update_user_meta( $user_id, 'wp_user_icon', $_POST['wp_user_icon'] );
}

// Apply filter
add_filter( 'get_avatar' , 'wp_user_icon_change_avatar' , 1 , 5 );

function wp_user_icon_change_avatar( $avatar, $id_or_email, $size, $default, $alt ) {
	$user = false;

	if ( is_numeric( $id_or_email ) ) {

		$id = (int) $id_or_email;
		$user = get_user_by( 'id' , $id );

	} elseif ( is_object( $id_or_email ) ) {

		if ( ! empty( $id_or_email->user_id ) ) {
			$id = (int) $id_or_email->user_id;
			$user = get_user_by( 'id' , $id );
		}

	} else {
		$user = get_user_by( 'email', $id_or_email );
	}

	if ( $user && is_object( $user ) ) {
		$user_id       = $user->data->ID;
		$user_icon_url = get_user_meta( $user_id, 'wp_user_icon', 'true' );

		if ( $user_icon_url ) {
			$avatar = $user_icon_url;
			$avatar = "<img alt='{$alt}' src='{$avatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";

		}

	}

	return $avatar;
}