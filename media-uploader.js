jQuery(document).ready(function($) {
    const mediaUploader = wp.media({
        title: '画像を選択',
        button: {
            text: '画像を選択'
        },
        multiple: false
    });
    $('#upload_image_button').click(function(e) {
        e.preventDefault();
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#background_image').val(attachment.url);
        });
        mediaUploader.open();
    });
});