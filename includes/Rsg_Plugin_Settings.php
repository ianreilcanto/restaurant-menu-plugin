<?php

include_once 'Rsg_ViewFuntions.php';
/**
 * This is a Settings Page
 */
class Rsg_Plugin_Settings
{
    private $view;

    function __construct()
    {

        //enque style and scripts
         if( is_admin() ) {
                //add_action( 'admin_enqueue_scripts', array( &$this, 'rsg_load_admin_script' ) );
                //add_action( 'admin_enqueue_scripts', array( &$this, 'wp_enqueue_color_picker' ) );
                //add_action('wp_enqueue_scripts', array( $this, 'colpick_scripts' ), 100);
         }
        //admin Menu
        add_action('admin_menu', array($this, 'rsg_add_city'));
        add_action('admin_menu', array($this, 'rsg_add_restaurant')); 
        add_action('admin_menu', array($this, 'rsg_add_menu'));  
    }




    function rsg_load_admin_script() {
       // wp_register_style( 'rsgBootstrap', plugins_url( '../assets/bootstrap/css/bootstrap.css', __FILE__ ), true,null, 'all' );
        wp_register_style( 'rsgStyle', plugins_url( '../assets/css/style.css', __FILE__ ), true,null, 'all' );

        //wp_register_script( 'rsgJquery.1.12.4', plugins_url( '../assets/js/jquery-1.12.4.js', __FILE__ ), array( 'jquery' ),null, true );
        //wp_register_script( 'rsgJquery', plugins_url( '../assets/js/jquery-3.1.1.min.js', __FILE__ ), array( 'jquery' ),null, true );

       // wp_register_script( 'rsgSpectrum', plugins_url( '../lib/spectrum/spectrum.js', __FILE__ ), array( 'jquery' ),null, true );
       // wp_register_script( 'rsgScripts', plugins_url( '../assets/js/scripts.js', __FILE__ ), array( 'jquery' ),null, true );
     
       // wp_enqueue_style( 'rsgBootstrap' );
        wp_enqueue_style( 'rsgStyle' );
        
       // wp_enqueue_script( 'rsgJquery.1.12.4' );
        //wp_enqueue_script( 'rsgJquery' );
        //wp_enqueue_script( 'rsgSpectrum' );
        //wp_enqueue_script( 'rsgScripts' );
    }

    // function colpick_scripts() {
    //     wp_enqueue_style('wp-color-picker');
    //     wp_enqueue_script('iris', admin_url('js/iris.min.js'),array('jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch'), false, 1);
    //     wp_enqueue_script('wp-color-picker', admin_url('js/color-picker.min.js'), array('iris'), false,1);
    //     $colorpicker_l10n = array('clear' => __('Clear'), 'defaultString' => __('Default'), 'pick' => __('Select Color'));
    //     wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', $colorpicker_l10n ); 
    // }

    // function wp_enqueue_color_picker( $hook_suffix ) {
    //     wp_enqueue_style( 'wp-color-picker' );
    //     wp_enqueue_script( 'wp-color-picker');
    //     wp_enqueue_script( 'wp-color-picker-script-handle', plugins_url('../assets/js/wp-color-picker-script.js', __FILE__ ), array( 'farbtastic' ), null, true );
    // }
  
    function rsg_add_city(){
        $view = new Rsg_ViewFuntions();
        add_menu_page('Add City', 'City', 'manage_options', 'menu1', array($view,'rsg_create_city'));
    }
    
    function rsg_add_restaurant(){
        $view = new Rsg_ViewFuntions();
        add_menu_page('Add Restaurant', 'Restaurant', 'manage_options', 'menu2', array($view,'rsg_create_restaurant'));
    }
    
    function rsg_add_menu(){
        $view = new Rsg_ViewFuntions();
        add_menu_page('Add Menu', 'Menu', 'manage_options', 'menu3', array($view,'rsg_create_menu'));
    }

}

