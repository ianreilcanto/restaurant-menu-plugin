<?php

class Rsg_Restaurant_Settings{



     function __construct(){

           if( is_admin()) {
                add_action( 'admin_enqueue_scripts', array( &$this, 'rsg_load_admin_script' ) );
         }

        add_action( 'init', array( $this, 'custom_post_type'), 0 );
      //  add_action( 'add_meta_boxes_restaurant', array( $this, 'adding_custom_meta_boxes') );
        add_action('add_meta_boxes', array( $this, 'add_custom_meta_boxes'), 10, 2);
        add_action('save_post_restaurants', array( $this, 'get_meta_save'));
     }


    function rsg_load_admin_script() {

        global $post_type;
        global $pagenow;

        wp_register_style( 'rsgStyle', plugins_url( '../assets/css/style.css', __FILE__ ), true,null, 'all' );
        
        wp_enqueue_style( 'rsgStyle' );

        if($post_type == 'restaurants' && $pagenow != 'edit.php' ){

            wp_register_script( 'rsgJquery.1.12.4', plugins_url( '../assets/js/jquery-1.12.4.js', __FILE__ ), array( 'jquery' ),null, true );
            wp_register_script( 'rsgScripts', plugins_url( '../assets/js/scripts.js', __FILE__ ), array( 'jquery' ),null, true );

            wp_enqueue_script( 'rsgJquery.1.12.4' );
            wp_enqueue_script( 'rsgScripts' );

        }
            
    }

    function custom_post_type() {

        $labels = array(
            'name'                => _x( 'Restaurangen', 'Post Type General Name', 'twentythirteen' ),
            'singular_name'       => _x( 'Restaurangen', 'Post Type Singular Name', 'twentythirteen' ),
            'menu_name'           => __( 'Restaurants', 'twentythirteen' ),
            'all_items'           => __( 'Alla Restauranger', 'twentythirteen' ),
            'view_item'           => __( 'Visa restaurang', 'twentythirteen' ),
            'add_new_item'        => __( 'Lägg till ny restaurang', 'twentythirteen' ),
            'add_new'             => __( 'Lägg till ny restaurang', 'twentythirteen' ),
            'edit_item'           => __( 'Redigera restaurang', 'twentythirteen' ),
            'update_item'         => __( 'Uppdatera restaurang', 'twentythirteen' ),
            'search_items'        => __( '
Sök Restaurang', 'twentythirteen' ),
            'not_found'           => __( 'Not Found', 'twentythirteen' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'twentythirteen' ),
        );
            
        $args = array(
            'label'               => __( 'restaurants', 'twentythirteen' ),
            'description'         => __( 'Restaurant Post Page', 'twentythirteen' ),
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
        
        register_post_type( 'restaurants', $args );

    }

    function add_custom_meta_boxes($post){
    add_meta_box(
        'my-meta-box',
        __( 'Information om restaurangen' ),
        array($this,'render_my_meta_box'),
        'restaurants',
        'normal',
        'default'
    );
}


function render_my_meta_box($post){

    wp_nonce_field( basename(__FILE__), 'restaurants_fields_nonce' );

    $values = get_post_meta($post->ID,"values",true);

  $args = array( 'post_type' => 'cities');
  $cities = new WP_Query( $args );
  
    
    include_once 'views/restaurant.php';

}

function get_meta_save($post_id){

    $is_autosave = wp_is_post_autosave( $post_id );

    if(!isset( $_POST['restaurants_fields_nonce'] ) || !wp_verify_nonce( $_POST['restaurants_fields_nonce'], basename( __FILE__ ) ) ){
        return;
    }

    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
        return;
    }

    if(!current_user_can( 'edit_post', $post_id )){
        return;
    }

    
    $_POST['restaurant_name'] = get_post( $post_id )->post_title;

  
    update_post_meta($post_id, 'values', $_POST);


}

}