<?php
/**
 * Plugin Name: Web Simple Image Gallery
 * Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
 * Description: Just add images from backend and display in front side
 * Version: 0.1
 * Author: Nilesh Netake
 * Author URI: http://www.facebook.com/nilesh.netake.5
 * License: GPL2
 */

/*  Copyright 2014  Nilesh Netake  (email : nilesh.netake@weboniselab.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('WSPATH',    plugin_dir_path(__FILE__));
define('WSURL',     plugins_url('', __FILE__));

register_deactivation_hook(__FILE__, 'WS_deactivated');
register_activation_hook(__FILE__, 'WS_activated');

function WS_activated(){
    global $wpdb;
    $table_name = $wpdb->prefix . "gallery";
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id int(11) NOT NULL AUTO_INCREMENT,
            image VARCHAR(500) NOT NULL,
            title VARCHAR(255) NOT NULL,
            created_at DATETIME ,
            modified_at DATETIME,
            UNIQUE KEY id (id)
            );";
        $wpdb->query($sql);
    }
}

function WS_deactivated(){

}

add_action('admin_menu', 'WS_plugin_menu');

function WS_plugin_menu(){

    add_menu_page("Web Simple Image Gallery", "Web Simple Image Gallery", "list_users", "ws-gallery", "WS_gallery", "", "87");

}

function WS_gallery(){

     include(WSPATH.'/includes/crud.php');
}

add_action('admin_print_scripts', 'WS_admin_scripts');
function WS_admin_scripts(){
      wp_enqueue_media();
}


add_action('admin_print_styles', 'WS_admin_styles');

function WS_admin_styles(){
    wp_enqueue_style( 'ws-admin.css', WSURL.'/css/ws-admin.css' );
    wp_enqueue_script( 'validate.js', WSURL.'/js/validate.js');
}

add_action('wp_print_styles', 'WS_print_styles');

function WS_print_styles(){
    $myCssFile = WSURL . '/css/ws.css';
    wp_register_style('ws.css', $myCssFile);
    wp_enqueue_style( 'ws.css');
}


add_action( 'wp_enqueue_scripts', 'WS_print_scripts' );

function WS_print_scripts(){
        wp_enqueue_style( 'fancybox.css', WSURL.'/css/jquery.fancybox.css' );
        wp_enqueue_style( 'ws.css', WSURL.'/css/ws.css' );
        wp_enqueue_script( 'fancybox-init.js', WSURL.'/js/fancybox-init.js');
        wp_enqueue_script( 'fancybox.pack.js', WSURL.'/js/jquery.fancybox.pack.js');

}

function getws_gallery(){
    global $wpdb;
    $output = '';
    $table_name = $wpdb->prefix . "gallery";
    $results = $wpdb->get_results( "SELECT id, title,image FROM $table_name ORDER BY id DESC" );

    if(!empty($results) && count($results) > 0){
        $output.= '<div class="ws">';
        $output.= '<ul class="galleryImages">';
        foreach($results as $key=>$val){
            $image = wp_get_attachment_image( $val->image, 'thumb');
            $image_full = wp_get_attachment_image_src( $val->image, 'full');
            $output.= '<li>';
            $output.= '<a  rel="group" class="fancybox" href="'.$image_full[0].'">';
            $output.= $image;
            $output.= '</a>';
            $output.= '</li>';
        }
        $output.= '</ul>';
        $output.= '</div>';
        return $output;
    }else{
        return 'No images yet';
    }
}

add_shortcode( 'ws_gallery', 'getws_gallery' );