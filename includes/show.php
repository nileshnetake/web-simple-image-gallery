<div class="wrap">
    <div class="icon32" id="icon-edit"><br></div>
    <h2><?php echo 'Web Simple Image Gallery'?></h2>
    <div><a class="btn btn-small btn-inverse" href="?page=<?php echo $_GET['page'].'&action=add'?>">Add</a></div>
    <div class="clear"></div>
    <form action="" method="post" id="ws_form">
        <input type="hidden" name="page" value="" />
        <table class="table table-striped table-bordered table-condensed albu   mList">
            <?php if($_GET['msg']!=''){?><tr><td align="center" colspan="3"><div  class="success"><?php echo $_GET['msg'] ?></div></td></tr> <?php } ?>
            <tr>
                <th>Title</th>
                <th>Image</th>
                <th>Action</th>
            </tr>

            <?php foreach($results as $key=>$val){
                $image = wp_get_attachment_image( $val->image, 'thumb');?>

            <tr>
                    <td><?php echo $val->title;?></td>
                    <td><?php echo $image?></td>
                    <td class="actions">
                        <a class="btn btn-small btn-inverse" href="?page=<?php echo $_GET['page']?>&action=edit&id=<?php echo $val->id?>">Edit</a>
                        <a class="btn btn-small btn-inverse" href="?page=<?php echo $_GET['page']?>&action=delete&id=<?php echo $val->id?>" onclick="confirm('Are you sure, you want to delete this image?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <br /><br />
    </form>
</div>