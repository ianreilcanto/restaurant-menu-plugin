<?php 

class Rsg_Menu_Settings{
     function __construct()
    {
          if( is_admin()) {
                add_action( 'admin_enqueue_scripts', array( &$this, 'rsg_load_admin_script' ) );
             }
              add_action( 'init', array( $this, 'custom_post_type'), 0 );
              add_action('add_meta_boxes', array( $this, 'add_custom_meta_boxes'), 10, 2);
              add_action('save_post_restaurantmenu', array( $this, 'get_meta_save'));
    }

    function rsg_load_admin_script() {

        global $post_type;
        global $pagenow;

        wp_register_style( 'rsgStyle', plugins_url( '../assets/css/style.css', __FILE__ ), true,null, 'all' );
        
        wp_enqueue_style( 'rsgStyle' );

        if($post_type == 'restaurantmenu' && $pagenow != 'edit.php' ){

            wp_register_script( 'rsgJquery.1.12.4', plugins_url( '../assets/js/jquery-1.12.4.js', __FILE__ ), array( 'jquery' ),null, true );

            wp_register_script('ckeditor',  plugins_url( '../assets/js/ckeditor/ckeditor.js', __FILE__ ),array(),null, true);

            wp_register_script( 'rsgScripts', plugins_url( '../assets/js/scripts.js', __FILE__ ), array( 'jquery' ),null, true );

             wp_register_script( 'rsgMenuScripts', plugins_url( '../assets/js/menu-scripts.js', __FILE__ ), array( 'jquery' ),null, true );


            wp_enqueue_script( 'rsgJquery.1.12.4' );
            wp_enqueue_script( 'ckeditor' );
            wp_enqueue_script( 'rsgScripts' );
            wp_enqueue_script( 'rsgMenuScripts' );

        }
            
    }

     function custom_post_type() {

        $labels = array(
            'name'                => _x( 'Meny', 'Post Type General Name', 'twentythirteen' ),
            'singular_name'       => _x( 'Meny', 'Post Type Singular Name', 'twentythirteen' ),
            'menu_name'           => __( 'Meny', 'twentythirteen' ),
            'all_items'           => __( 'Alla meny', 'twentythirteen' ),
            'view_item'           => __( 'Visa meny', 'twentythirteen' ),
            'add_new_item'        => __( 'Lägg till ny meny', 'twentythirteen' ),
            'add_new'             => __( 'Lägg till ny meny', 'twentythirteen' ),
            'edit_item'           => __( 'Redigera menyn', 'twentythirteen' ),
            'update_item'         => __( 'Uppdateringsmeny', 'twentythirteen' ),
            'search_items'        => __( 'Sökmeny', 'twentythirteen' ),
            'not_found'           => __( 'Not Found', 'twentythirteen' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'twentythirteen' ),
        );
            
        $args = array(
            'label'               => __( 'restaurantmenu', 'twentythirteen' ),
            'description'         => __( 'Menu Post Page', 'twentythirteen' ),
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
        
        register_post_type( 'restaurantmenu', $args );

    }

    function add_custom_meta_boxes($post){
        add_meta_box(
            'my-meta-box',
            __( 'Menu Page Information' ),
            array($this,'render_my_meta_box'),
            'restaurantmenu',
            'normal',
            'default'
        );
    }

    function render_my_meta_box($post){

        wp_nonce_field( basename(__FILE__), 'restaurantmenu_fields_nonce' );

        $values = get_post_meta($post->ID,"values",true);

       // $args = array( 'post_type' => 'restaurants');
        $args = array( 
            'post_type' => 'restaurants',
             'post_status' => 'published',
             'posts_per_page' => 1000
            );

        $restaurants = new WP_Query( $args );

        //$args = array( 'post_type' => 'cities');
        $args = array( 
            'post_type' => 'cities',
             'post_status' => 'published',
             'posts_per_page' => 1000
            );

        $cities = new WP_Query( $args );

        $restaurants_value = array();
        $city_restaurants = array();

        $weeks = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");


      // print_r($values);
        
        for($j=0; count($cities->posts) > $j; $j++){

            //echo $cities->posts[$j]->ID.'<br>';

            for($i = 0; count($restaurants->posts) > $i; $i++){
                $postId = $restaurants->posts[$i]->ID;  
                $meta = get_post_meta($postId,"values",true);

              if($meta){
                    $selected_city = $meta['selected_city'];

                   if($selected_city){
                        if(in_array($cities->posts[$j]->ID,$selected_city))
                        {
                
                            array_push($restaurants_value,$meta);
                        }
                   }
              }
      
            }

              array_push($city_restaurants,array($cities->posts[$j]->ID => $restaurants_value));

              $restaurants_value = array();


        }
        

       include_once 'views/menu.php';

    }

   
    function get_meta_save($post_id){

        $is_autosave = wp_is_post_autosave( $post_id );

        if(!isset( $_POST['restaurantmenu_fields_nonce'] ) || !wp_verify_nonce( $_POST['restaurantmenu_fields_nonce'], basename( __FILE__ ) ) ){
            return;
        }

        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
            return;
        }

        if(!current_user_can( 'edit_post', $post_id )){
            return;
        }

        update_post_meta($post_id, 'values', $_POST);

    }


}