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
        WS_add();
    }
}

function WS_add(){
    include(WSPATH.'/includes/add.php');
}


function WS_get() {
    global $wpdb;
    $table_name = $wpdb->prefix . "gallery";
    $results = $wpdb->get_results( "SELECT id, title,image FROM $table_name" );
    include(WSPATH.'/includes/show.php');
 }

function WS_delete(){

}
WS_get();

