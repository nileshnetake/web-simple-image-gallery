<div class="wrap">
    <div class="icon32" id="icon-add"><br></div>
    <h2><?php echo 'Web Simple Image Gallery-Add Image'?></h2>
    <div><a href="?page=<?php echo $_GET['page'].'&action=add'?>">Add</a></div>
    <div class="clear"></div>

    <form action="" method="post" id="ws_form_add">
        <input type="hidden" name="page" value="<?php echo $_GET['page']?>" />
        <input type="hidden" name="mode" value="<?php echo $_GET['action']?>" />
        <table cellspacing="0" class="wp-list-taxonomy">
            <tbody>
            <tr>
                <td>Title</td>
                <td><input type="text" name="title" id="title" value=""> </td>

            </tr>
            <tr>
                <td colspan="2">
                    <div class="uploader">
                        <input type="button"  name="_unique_name_button" id="_unique_name_button" value="Upload Image" class="custom_media_upload" />
                        <img class="custom_media_image" src="" />
                        <input class="custom_media_id" type="hidden" name="attachment_id" value="">
                    </div>
                </td>
            </tr>

            <tr>
                <td colspan="2"><input type="submit" name="submit" value="Add"></td>
            </tr>

            </tbody>
        </table>
        <br /><br />
    </form>
</div>

<script type="text/javascript">

    jQuery('.custom_media_upload').click(function(e) {
        e.preventDefault();

        var custom_uploader = wp.media({
            title: 'Upload Image for WS gallery',
            button: {
                text: 'Submit'
            },
            multiple: false  // Set this to true to allow multiple files to be selected
        })
            .on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                jQuery('.custom_media_image').attr('src', attachment.url);
                jQuery('.custom_media_url').val(attachment.url);
                jQuery('.custom_media_id').val(attachment.id);
            })
            .open();
    });
</script>