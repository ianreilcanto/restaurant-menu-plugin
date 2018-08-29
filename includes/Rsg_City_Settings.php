<?php

include_once 'Rsg_ViewFuntions.php';
require_once('tcpdf/tcpdf.php');

class Rsg_City_Settings 
{
     function __construct()
    {

        //enque style and scripts
         if( is_admin()) {
                add_action( 'admin_enqueue_scripts', array( &$this, 'rsg_load_admin_script' ) );
         }

        // add_submenu_page('edit.php?post_type=cities', __('Test Settings','menu-test'), __('Test Settings','menu-test'), 'manage_options', 'testsettings', 'mt_settings_page');

        add_action( 'init', array( $this, 'custom_post_type'), 0 );
        // add_action( 'add_meta_boxes_city', array( $this, 'adding_custom_meta_boxes') );
        add_action('add_meta_boxes', array( $this, 'add_custom_meta_boxes'), 10, 2);
        add_action('save_post_cities', array( $this, 'get_meta_save'));

        register_activation_hook( _FILE_, array($this,'insert_page'));
    }

     function rsg_load_admin_script() {

         global $post_type;
         global $pagenow;

        wp_register_style( 'rsgBootstrap', plugins_url( '../assets/bootstrap/css/bootstrap.css', __FILE__ ), true,null, 'all' );
        wp_register_style( 'rsgStyle', plugins_url( '../assets/css/style.css', __FILE__ ), true,null, 'all' );
     
        wp_enqueue_style( 'rsgBootstrap' );
        wp_enqueue_style( 'rsgStyle' );
        
        if($post_type == 'cities' && $pagenow != 'edit.php' ){

            wp_enqueue_script( 'wp-color-picker' );
            // load the minified version of custom script
            wp_enqueue_script( 'rsg-color-picker', plugins_url( '../assets/js/rsg-color-picker.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ), '1.1', true );

             wp_register_script( 'rsgScripts', plugins_url( '../assets/js/scripts.js', __FILE__ ), array( 'jquery' ),null, true );

            wp_enqueue_style( 'wp-color-picker' );      
            wp_enqueue_script( 'rsgScripts' );

        }
           
    }

    function insert_page(){
     $new_page_id = wp_insert_post( array(
             //'post_title'     => 'Valencia Page',
            'post_type'      => 'cities',
             'post_name'      => 'blog',
            //'comment_status' => 'closed',
            //    'ping_status'    => 'closed',
            // 'post_content'   => '',
            'post_status'    => 'publish',
           // 'post_author'    => get_user_by( 'id', 1 )->user_id,
            'menu_order'     => 0,
            // Assign page template
            'page_template'  => 'views/front-end.php'
        ) );
}


    function custom_post_type() {

    // Set UI labels for Custom Post Type
        $labels = array(
            'name'                => _x( 'Ort', 'Post Type General Name', 'twentythirteen' ),
            'singular_name'       => _x( 'Ort', 'Post Type Singular Name', 'twentythirteen' ),
            'menu_name'           => __( 'Orter', 'twentythirteen' ),
            'all_items'           => __( 'Alla Orter', 'twentythirteen' ),
            'view_item'           => __( 'View Ort', 'twentythirteen' ),
            'add_new_item'        => __( 'Skapa ny Ort', 'twentythirteen' ),
            'add_new'             => __( 'Skapa ny Ort', 'twentythirteen' ),
            'edit_item'           => __( 'Redigera Ort', 'twentythirteen' ),
            'update_item'         => __( 'Upddatera Ort', 'twentythirteen' ),
            'search_items'        => __( 'Sök Ort', 'twentythirteen' ),
            'not_found'           => __( 'Not Found', 'twentythirteen' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'twentythirteen' ),
        );
            
        $args = array(
            'label'               => __( 'cities', 'twentythirteen' ),
            'description'         => __( 'City Post Page', 'twentythirteen' ),
            'labels'              => $labels,
            'supports'            => array('title','thumbnail',),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
        );
        
        register_post_type( 'cities', $args );

    }



function add_custom_meta_boxes($post){
    add_meta_box(
        'my-meta-box',
        __( 'Information on orten' ),
        array($this,'render_my_meta_box'),
        'cities',
        'normal',
        'default'
    );
}


function render_my_meta_box($post){

    wp_nonce_field( basename(__FILE__), 'cities_fields_nonce' );

    $values = get_post_meta($post->ID,"values",true);
    $weeks = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
    include_once 'views/city.php';

}

function get_meta_save($post_id){

    $is_autosave = wp_is_post_autosave( $post_id );

    if(!isset( $_POST['cities_fields_nonce'] ) || !wp_verify_nonce( $_POST['cities_fields_nonce'], basename( __FILE__ ) ) ){
        return;
    }

    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
        return;
    }

      

    $_POST['city_name'] = get_post( $post_id )->post_title;

    if(!current_user_can( 'edit_post', $post_id )){
        return;
    }
   
    update_post_meta($post_id, 'values', $_POST);
   

}

}
