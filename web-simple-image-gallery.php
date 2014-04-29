<?php
/**
 * Plugin Name: Web Simple Image Gallery
 * Plugin URI: https://github.com/nileshnetake/web-simple-image-gallery
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


define('WSIGPATH',    plugin_dir_path(__FILE__));
define('WSIGURL',     plugins_url('', __FILE__));

register_deactivation_hook(__FILE__, 'wsig_deactivated');
register_activation_hook(__FILE__, 'wsig_activated');

function wsig_activated(){
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

function wsig_deactivated(){

}

add_action('admin_menu', 'wsig_plugin_menu');

function wsig_plugin_menu(){

    add_menu_page("Web Simple Image Gallery", "Web Simple Image Gallery", "list_users", "wsig-gallery", "wsig_gallery", "", "87");

}

function wsig_gallery(){

     include(WSIGPATH.'/includes/crud.php');
}

add_action('admin_print_scripts', 'wsig_admin_scripts');
function wsig_admin_scripts(){
      wp_enqueue_media();
}


add_action('admin_print_styles', 'wsig_admin_styles');

function wsig_admin_styles(){
    wp_enqueue_style( 'wsig-admin.css', WSIGURL.'/css/wsig-admin.css' );
    wp_enqueue_script( 'validate.js', WSIGURL.'/js/validate.js');
}

add_action('wp_print_styles', 'wsig_print_styles');

function wsig_print_styles(){
    $myCssFile = WSIGURL . '/css/wsig.css';
    wp_register_style('wsig.css', $myCssFile);
    wp_enqueue_style( 'wsig.css');
}


add_action( 'wp_enqueue_scripts', 'wsig_print_scripts' );

function wsig_print_scripts(){
        wp_enqueue_style( 'prettyPhoto.css', WSIGURL.'/css/prettyPhoto.css' );
        wp_enqueue_style( 'wsig.css', WSIGURL.'/css/wsig.css' );
        wp_enqueue_script( 'fancybox-init.js', WSIGURL.'/js/preetyphoto-init.js');
        wp_enqueue_script( 'preetyPhoto.js', WSIGURL.'/js/jquery.prettyPhoto.js');

}

function wsig_get_gallery(){
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
            $output.= '<a  rel="prettyPhoto[pp_gal]"  href="'.$image_full[0].'">';
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

add_shortcode( 'wsig_gallery', 'wsig_get_gallery' );