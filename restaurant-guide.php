<?php
/*
Plugin Name: Restaurant Guide
Version: 1.0
Author: Ian Reil Canto
*/

// include_once 'includes/Rsg_Plugin_Settings.php';
// include_once 'lib/tcpdf/tcpdf.php';

include_once 'includes/Rsg_City_Settings.php';
include_once 'includes/Rsg_Restaurant_Settings.php';
include_once 'includes/Rsg_Menu_Settings.php';

//$run = new Rsg_Plugin_Settings();
$city = new Rsg_City_Settings();
$restaurant = new Rsg_Restaurant_Settings();
$rsg_menu = new Rsg_Menu_Settings();


function get_custom_post_type_template($single_template) {
     global $post;

     if ($post->post_type == 'cities') {
          if($_GET["action"]=="generate_pdf")
          {
              $single_template =  plugin_dir_path( __FILE__ ) . '/city-template-pdf.php';
          }elseif($_GET["action"] == "nextweek"){
              $single_template =  plugin_dir_path( __FILE__ ) . '/city-template-pdf-next.php';
          }
          else{
                $single_template =  plugin_dir_path( __FILE__ ) . '/city-template.php';
          }
          
     }
     return $single_template;
}
add_filter( 'single_template', 'get_custom_post_type_template' );
