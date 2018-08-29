<?php 
    global $post;
    //$noImage = wp_normalize_path( WP_PLUGIN_DIR ).'/assets/img/no-image-available.jpg';
    $noImage = plugin_dir_url( __FILE__ ) . 'assets/img/no-image-available.jpg';
   // echo wp_normalize_path( WP_PLUGIN_DIR );
    $args = array( 
            'post_type' => 'restaurants',
             'post_status' => 'published',
             'posts_per_page' => 1000
            );
    $restaurants = new WP_Query( $args );

    $args = array( 
            'post_type' => 'restaurantmenu',
            'post_status' => 'published',
            'posts_per_page' => 1000
        );
    $menu = new WP_Query( $args );

    $restaurants_value = array();
    $menu_value = array();

    //get city meta 
    $city_meta = get_post_meta($post->ID,"values",true);

    //get restaurant
    for($i = 0; count($restaurants->posts) > $i; $i++){
        $postId = $restaurants->posts[$i]->ID;  
        $meta = get_post_meta($postId,"values",true);

        $selected_city = $meta['selected_city'];

        if($selected_city){

            if(in_array($post->ID,$selected_city))
        {

            array_push($restaurants_value,$meta);
        }
        }
        
    }

    //get menu
    for( $i = 0; count($menu->posts) > $i; $i++ ){

        $postId = $menu->posts[$i]->ID;
        $meta = get_post_meta($postId,"values",true);  
        
        if($meta['city_menu'] == $post->ID)
        {
            array_push($menu_value,$meta);
        }
    }

// echo "<pre>";
//     print_r($restaurants_value);
// echo "</pre>";

function weekOfMonth($date) {
    //Get the first day of the month.
    $firstOfMonth = strtotime(date("Y-m-01", $date));
    //Apply above formula.
    return intval(date("W", $date)) - intval(date("W", $firstOfMonth)) + 1;
  }
?>
<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veckans-lunch.se</title>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Lily+Script+One" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url( __FILE__ ) ?>city-style.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <style type="text/css">
        @font-face {
            font-family: helvetica-condensed;
            src: url('<?php echo  plugin_dir_url( __FILE__ )."assets/helvetica-condensed.ttf"; ?>');
        }
    </style>
    
  
    <!-- <?php //echo $city_meta['font1']; ?> -->
</head>
<body style="background:<?php echo $city_meta['background_color']; ?>;color:<?php echo $city_meta['font_color'];?>;>
    <div class="container">
        <div class="header">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-xs-12">
                  <a href="http://veckans-lunch.se/"> <div class="city-logo">
                         <?php echo get_the_post_thumbnail($post->ID,'small') ?>   
                         	<div id="site-title" ><h1><?php echo get_bloginfo( 'name' ); ?></h1></div></a>               
                   </div>
			
            </div>
            <div class="row">
                    <div class="col-lg-6 col-md-12 col-xs-12">
                        <div>
                            <nav>
                                <div>
                                    <ul class="navbar-nav weekday-nav">
                                        <li class="nav-item day1">
                                            <a class="nav-link " href="#">Måndag</a>
                                        </li>
                                        <li class="nav-item day2">
                                            <a class="nav-link" href="#">Tisdag</a>
                                        </li>
                                        <li class="nav-item day3">
                                            <a class="nav-link" href="#">Onsdag</a>
                                        </li>
                                        <li class="nav-item day4">
                                            <a class="nav-link" href="#">Torsdag</a>
                                        </li>
                                        <li class="nav-item day5">
                                            <a class="nav-link" href="#">Fredag</a>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="body">
			<div class="adserver-corner">
				<div class="small_ad_text"><p >ANNONS</p></div>
					<?php 
							global $post;
							$cityID = $post->ID;
							if($cityID==86){
								$cty = 'avesta';
							}elseif($cityID==22){
								$cty = 'borlange';
							}elseif($cityID==17){
								$cty = 'falun';
							}elseif($cityID==576){
								$cty = 'hedemora/sater';
							}
							dynamic_sidebar('topBanner-'.$cty); 						
				?>
			</div>
<!--             <div class="row" style="margin-top: 35px !important;">
                <div class="col-lg-6 col-md-6 col-xs-6 restaurant-introduction gen-left">
                </div>
                <div class="col-lg-6 col-md-6 col-xs-6 restaurant-introduction gen-right">
                </div>
            </div> -->
			
            <div class="row" style="text-align:center; margin-top: 20px !important;">
                <h1 class="title-for-restaurant">
                    <span class="day-menu"></span> Lunch i <span class="city-name-label"><?php echo $city_meta['city_name']; ?></span><span class="week-number"></span>
                </h1>
            </div>
            <div class="row" style="margin-top: 31px !important">
                <?php for( $i = 0; count($restaurants_value) > $i; $i++){ ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="col-md-12 restaurant-cards">
                            <div class="col-md-12 rs-section card-image">
                                <h3><!-- <?php echo $restaurants_value[$i]['restaurant_name']; ?> --></h3>
                                <div class="image-container">
                                    <?php $image = wp_get_attachment_image_src($restaurants_value[$i]['_thumbnail_id'],'large')[0]; ?>
                                    <img src="<?php  echo (!empty($image)) ? $image : $noImage; ?>" > 
                                </div>
                            </div>
                            <div class="col-md-12 rs-section card-menu">
                                <?php 

                                $week = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday");
                                $nowDate = strtotime(date("Y-m-d"));
                                $nowWeekDay = getdate($nowDate);
                                $nowWeekNumber =  weekOfMonth($nowDate);

                                    for($j = 0; count($menu_value) > $j; $j++ ){
                                    
                                        if($menu_value[$j]['restaurant_menu'] == $restaurants_value[$i]["ID"])
                                        {
                                            for( $k = 0; count($menu_value[$j]['menu_list']) > $k; $k++){                                                                                
                                                $timestamp = strtotime($menu_value[$j]['menu_date'][$k]);
                                                $weekDay = getdate($timestamp);                             
                                                 $weekNumber = weekOfMonth($timestamp); 
                                                 $nowWeekNum = date("W", $nowDate);
                                                 $menuDateWeekNumber = date("W",$timestamp);    
                                               if($nowWeekNum == $menuDateWeekNumber)
                                                {
                                                      $key = array_search($weekDay['weekday'],$week);
                                                      unset($week[$key]);
                                                ?>
                                                    <div class="col-md-12 <?php echo $weekDay['weekday']; ?>" style="display:<?php echo $weekDay['weekday'] == 'Monday' ? 'block' : 'none';  ?>">
                                                        <?php  echo $menu_value[$j]['menu_list'][$k]; 
                                                                                                  
                                                       ?>
                                                    </div>
                                                <?php
                                               }                                                         
                                            }

                                            $week = array_values(array_filter($week));

                                            if(count($week) > 0)
                                            {
                                               for($z= 0; count($week) > $z; $z++)
                                               {
                                                   ?>
                                                    <div class="col-md-12 <?php echo $week[$z]; ?>" style="display:<?php echo $week[$z] == 'Monday' ? 'block' : 'none';  ?>">
                                                        <?php  echo $restaurants_value[$i]['no_menu'];                
                                                        ?>
                                                    </div>
                                                <?php
                                               }
                                            }
                                             
                                        }
                                    }
                                ?>
                            </div>
                            <div class="col-md-12 rs-section general-text">
                                <?php echo $restaurants_value[$i]['general_text']; ?>
                            </div>  
                            <div class="col-md-12 address">
                                <?php echo $restaurants_value[$i]['address']; ?><br>
                                 <a href="tel:<?php echo $restaurants_value[$i]['telephone']; ?>"><?php echo $restaurants_value[$i]['telephone']; ?></a><br>
                                <a target="_blank" href="//<?php echo $restaurants_value[$i]['web_url']; ?>"><?php echo $restaurants_value[$i]['web_url']; ?></a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>

	<?php get_sidebar( 'content-bottom' ); ?>

</html>




<script>
        //front-end

        $(function(){

          
    
            var day1 = $(".day1");
            var day2 = $(".day2");
            var day3 = $(".day3");
            var day4 = $(".day4");
            var day5 = $(".day5");

            var monday = $('.Monday');
            var tuesday = $('.Tuesday');
            var wednesday = $('.Wednesday');
            var thursday = $('.Thursday');
            var friday = $('.Friday');
  
            day1.on("click",function(){         
                monday.show();
                tuesday.hide();
                wednesday.hide();
                thursday.hide();
                friday.hide();

                day1.addClass('day-active');
                day2.removeClass('day-active');  
                day3.removeClass('day-active');    
                day4.removeClass('day-active');    
                day5.removeClass('day-active');    

                var value = $(this).text().trim();
                $('.day-menu').html(value);
                 
               
            });

             day2.on("click",function(){               
                monday.hide();
                tuesday.show();
                wednesday.hide();
                thursday.hide();
                friday.hide();

                day1.removeClass('day-active');
                day2.addClass('day-active');  
                day3.removeClass('day-active');    
                day4.removeClass('day-active');    
                day5.removeClass('day-active');  

                var value = $(this).text().trim();
                $('.day-menu').html(value);
  
            });

             day3.on("click",function(){               
                monday.hide();
                tuesday.hide();
                wednesday.show();
                thursday.hide();
                friday.hide();

                day1.removeClass('day-active');
                day2.removeClass('day-active');  
                day3.addClass('day-active');    
                day4.removeClass('day-active');    
                day5.removeClass('day-active');  

                 var value = $(this).text().trim();
                $('.day-menu').html(value);
            });

             day4.on("click",function(){               
                monday.hide();
                tuesday.hide();
                wednesday.hide();
                thursday.show();
                friday.hide();

                day1.removeClass('day-active');
                day2.removeClass('day-active');  
                day3.removeClass('day-active');    
                day4.addClass('day-active');    
                day5.removeClass('day-active');  

                 var value = $(this).text().trim();
                $('.day-menu').html(value);
            });

             day5.on("click",function(){               
                monday.hide();
                tuesday.hide();
                wednesday.hide();
                thursday.hide();
                friday.show();

                day1.removeClass('day-active');
                day2.removeClass('day-active');  
                day3.removeClass('day-active');    
                day4.removeClass('day-active');    
                day5.addClass('day-active');  

                 var value = $(this).text().trim();
                $('.day-menu').html(value);
            });

            //general text
            var leftValue = '<?php echo $city_meta['general_text_left']; ?>';
            var rightValue = '<?php echo $city_meta['general_text_right']; ?>';
            $('.gen-left').html(leftValue);
            $('.gen-right').html(rightValue);


            Date.prototype.getWeekNumber = function(){
                var d = new Date(+this);
                d.setHours(0,0,0,0);
                d.setDate(d.getDate()+4-(d.getDay()||7));
                return Math.ceil((((d-new Date(d.getFullYear(),0,1))/8.64e7)+1)/7);
            };

             var weekNumber = new Date().getWeekNumber();

            //title
            //  var weekNumber = (0 | new Date().getDate() / 7)+1;
            $('.week-number').html(" - vecka "+weekNumber);
            

            var date = new Date();         //timestamp
            var day = date.getDay(); 

            $('.day'+day).find('a').click();

            for(var i = 1; i <= 5; i++ )
            {
                if(i < day && day != 6)
                {
                    $('.day'+i).addClass('day-inactive');
                }
            }


            // if(day == 6){

            //       for(var i = 1; i <= 5; i++ )
            //     {
            //         if(i < day)
            //         {
            //             $('.day'+i).addClass('day-active');
            //         }
            //     }
            // }



            $('.day-inactive').css('pointer-events', 'none');
        });

            //google Font
            // $(function() {
            //     var googleFontApiUrl = "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyAoU3R6S_5Pt4kSuH43JFLVdo1s3uR5GAI";
            //     var firstSelector = $('#g-font-1');
            //     var secondSelector = $('#g-font-2');

            //     var head = $('html').find('head');
            //     head.append('<style type="text/css" class="font-face"></style>');

            //     var styleContainer = $('style.font-face');

            //     $.ajax({
            //         dataType: "json",
            //         url: googleFontApiUrl,
            //         success: function(data) {
            //             $.each(data.items, function(index, value) {

            //                 //console.log(value.files.regular);
            //                 styleContainer.append('@font-face{ font-family : ' + value.family + '; src : url(' + value.files.regular + ');}')
            //             });
            //         }
            //     });
            // });
            
</script>