<div class="wrap">
    <div class="icon32" id="icon-edit"><br></div>
    <h2><?php echo 'Web Simple Image Gallery'?></h2>
    <div><a href="?page=<?php echo $_GET['page'].'&action=add'?>">Add</a></div>
    <div class="clear"></div>

    <form action="" method="post" id="ws_form">
        <input type="hidden" name="page" value="" />

        <table cellspacing="0" class="wp-list-taxonomy">
            <tbody>
            <tr>
                <td>Title</td>
                <td>Image</td>
                <td>Action</td>
            </tr>
            <?php foreach($results as $key=>$val){
                $image = wp_get_attachment_image_src( $val->image, 'medium');
                //echo '<pre>';print_r($image);
                ?>
                <tr><td><?php echo $val->title;?></td>
                    <td><img src="<?php  echo $image[0]?>"></td>
                    <td><a href="#">Delete</a> | <a href="#">Edit</a></td></tr>

            <?php } ?>

            </tbody>
        </table>
        <br /><br />
    </form>
</div>