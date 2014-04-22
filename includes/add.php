<div class="wrap">
    <div class="icon32" id="icon-add"><br></div>
    <h2><?php echo 'Web Simple Image Gallery-Add Image'?></h2>
    <div class="clear"></div>
    <form action="" method="post" id="ws_form_add">
        <input type="hidden" name="page" value="<?php echo $_GET['page']?>" />
        <input type="hidden" name="mode" value="<?php echo $mode?>" />
        <input type="hidden" name="id" value="<?php echo isset($form->id)? $form->id:''?>" />
        <table cellspacing="0" class="wp-list-taxonomy">
            <tbody>
            <tr>
                <td><label>Title</label></td>
                <td><input type="text" name="title" id="title" class="required" value="<?php echo isset($form->title)? $form->title : '';?>"> </td>
            </tr>
            <tr>
                <td><label>Image</label></td>
                <td>
                    <input type="text"  name="ws_button" id="ws_button" value="" class="custom_media_url <?php if($mode=='add'){?>required<?php } ?>" />

                </td>
            </tr>
            <tr>
                <td colspan="2" align="right">
                    <div class="uploader">
                        <img class="custom_media_image" src="<?php echo isset($image_full[0])?$image_full[0]:'';?>" />
                        <input class="custom_media_id" type="hidden" name="attachment_id" value="<?php echo isset($form->image)?$form->image:''?>">
                    </div>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td align="right">
                        <input type="submit" name="submit" value="Add" class="btn-inverse">
                        <input type="button" name="cancel" value="Cancel" class="btn-inverse" onclick="window.location.href='?page=<?php echo $_GET['page']?>'">
                </td>
            </tr>
            </tbody>
        </table>
        <br /><br />
    </form>
</div>

<script type="text/javascript">
    jQuery('.custom_media_url').focus(function(e) {
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