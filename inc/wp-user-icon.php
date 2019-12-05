<?php

add_action( 'show_user_profile', 'wp_user_icon_fields' );
add_action( 'edit_user_profile', 'wp_user_icon_fields' );

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
					<input type="text" name="wp_user_icon" id="btn-add-image" value="<?php echo esc_attr( get_the_author_meta( 'wp_user_icon', $user->ID ) ); ?>" class="regular-text"/>
					<p class="description"><input type='button' class="button" value="画像選択" id="uploadimage"/>  <input type='button' id="wpui-clear" class="clear-button button" value="リセット"/></p>
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
        jQuery(document).ready(function() {

            jQuery(document).find("input[id^='uploadimage']").live('click', function(){
                //var num = this.id.split('-')[1];
                formfield = jQuery('#wpui-image').attr('name');
                tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');

                window.send_to_editor = function(html) {
                    imgurl = jQuery('img',html).attr('src');
                    jQuery('#wpui-image').val(imgurl);

                    tb_remove();
                }

                return false;
            });
        });
        jQuery(function($){
            $("#wpui-clear").click(function () {
                // テキストボックスへ値を設定します
                $("#wpui-image").val("");
            });
        });

        wrapper.find( '#btn-add-image' ).click( function( e ) {
            e.preventDefault();
            var custom_uploader_image;
            var upload_button = $( this );
            if ( custom_uploader_image ) {
                custom_uploader_image.open();
                return;
            }

            wp.media.view.Modal.prototype.on( 'ready', function(){
                $( 'select.attachment-filters' )
                    .find( '[value="uploaded"]' )
                    .attr( 'selected', true )
                    .parent()
                    .trigger( 'change' );
            } );

            custom_uploader_image = wp.media( {
                button : {
                    text: smart_cf_uploader.image_uploader_title
                },
                states: [
                    new wp.media.controller.Library({
                        title     :  smart_cf_uploader.image_uploader_title,
                        library   :  wp.media.query( { type: 'image' } ),
                        multiple  :  false,
                        filterable: 'uploaded'
                    })
                ]
            } );

            custom_uploader_image.on( 'select', function() {
                var images = custom_uploader_image.state().get( 'selection' );
                images.each( function( file ){
                    var sizes = file.get('sizes');
                    var image_area = upload_button.parent().find( '.smart-cf-upload-image' );
                    var sizename = image_area.data('size');
                    var img = sizes[ sizename ] || sizes.full;
                    var alt_attr = file.get('title');
                    image_area.find( 'img' ).remove();
                    image_area.prepend(
                        '<img src="' + img.url + '" alt="' + alt_attr + '" />'
                    );
                    image_area.removeClass( 'hide' );
                    upload_button.parent().find( 'input[type="hidden"]' ).val( file.toJSON().id );
                } );
            } );

            custom_uploader_image.open();
        } );
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