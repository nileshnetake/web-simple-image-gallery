<?php
global $wpdb;
if(isset($_GET['action']) && $_GET['action']=='add'){
    if(isset($_POST) && count($_POST) > 0){
        $table_name = $wpdb->prefix . "gallery";
        $data = array('title'=>$_POST['title'],'image'=>$_POST['attachment_id'],'created_at'=>date('Y-m-d H:i:s'),'modified_at'=>date('Y-m-d H:i:s'));
        if($wpdb->insert( $table_name, $data)){
            $msg = urlencode('Image Added Successfully');
            wp_redirect('admin.php?page='.$_GET['page'].'&msg='.$msg.'&action=show');
            exit;
        }else{
            $wpdb->show_errors();
            echo 'Sorry, Unable to Save data';
        }


    }else{
        wsig_add();
    }
}

if(isset($_GET['action']) && $_GET['action']=='delete'){
    global $wpdb;
    $table_name = $wpdb->prefix . "gallery";
    $wpdb->delete($table_name, array('id' => $_GET['id']));
    $msg = urlencode('Image Deleted Successfully');
    wp_redirect('admin.php?page='.$_GET['page'].'&msg='.$msg);
    exit;
}

if(isset($_GET['action']) && $_GET['action']=='edit'){
    global $wpdb;
    $table_name = $wpdb->prefix . "gallery";
    if(isset($_POST['mode']) && $_POST['mode']=='edit'){

        $wpdb->update(
            $table_name,
            array(
                'image' => $_POST['attachment_id'],
                'title' => $_POST['title'],
                'modified_at'=>date('Y-m-d H:i:s')
            ),
            array( 'id' => $_POST['id'] )
        );
        $msg = urlencode('Image Updated Successfully');
        wp_redirect('admin.php?page='.$_GET['page'].'&msg='.$msg);
        exit;

    }
    $id = $_GET['id'];
    $res =  $wpdb->get_row("SELECT id,image,title FROM $table_name WHERE id=$id");
    wsig_add('edit',$res);
}


function wsig_add($mode= 'add',$form= array()){
    $id = isset($form->id) ? $form->id:'';
    $title =  isset($form->title) ? $form->title:'';
    $image =  isset($form->image) ? $form->image:'';
    $image_full = $image ? wp_get_attachment_image_src( $image, 'full'):'';
    include(WSIGPATH.'/includes/add.php');
}


function wsig_get() {
    global $wpdb;
    $table_name = $wpdb->prefix . "gallery";
    $results = $wpdb->get_results( "SELECT id, title,image FROM $table_name ORDER BY id DESC" );
    include(WSIGPATH.'/includes/show.php');
 }

if(isset($_GET['action'])){
    $action = $_GET['action'];
}else{
    $action = '';
}

if($action=='' || $action=='show'){
    wsig_get();
}


