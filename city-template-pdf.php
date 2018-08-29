<?php

require_once(plugin_dir_path( __FILE__ ).'includes/tcpdf/tcpdf.php');

define('CHARSET', 'ISO-8859-1');

global $post;


$doc = new DOMDocument();

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

        if($meta){
            $selected_city = $meta['selected_city'];


            if($selected_city)
            {
                if(in_array($post->ID,$selected_city))
                {
                    array_push($restaurants_value,$meta);
                }
            }
        }
        
    }

    //get menu
    for( $i = 0; count($menu->posts) > $i; $i++ ){

        $postId = $menu->posts[$i]->ID;
        $meta = get_post_meta($postId,"values",true);  
        
        if($meta){
                if($meta['city_menu'] == $post->ID)
            {
                array_push($menu_value,$meta);
            }
        }
    
    }
function weekOfMonth($date) {
    //Get the first day of the month.
    $firstOfMonth = strtotime(date("Y-m-01", $date));
    //Apply above formula.
    return intval(date("W", $date)) - intval(date("W", $firstOfMonth)) + 1;
  }

$numberOfMenu = count($menu_value);
$offset = 0;
$firstColPercentage = .17;

$secColPercentage = .84;
$height = isset($_GET['rowHeight']) ? $_GET['rowHeight'] : 31;
$defaultHeight = 5;


$pageWidth = isset($_GET['width']) ? $_GET['width'] : 242;
$pageHeight = $height * (count($restaurants_value) + 1) - 4;
$pageOrientation = ($pageWidth > $pageHeight ) ? "L" : "P";

$firstColWidth = ($pageWidth - $offset) * $firstColPercentage;
$secColWidth = ($pageWidth - $offset) * $secColPercentage;


//$custom_layout = array($pageWidth, $pageHeight);

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

  $page_format = array(
            'MediaBox' => array ('llx' => 0, 'lly' => 0, 'urx' => $pageWidth - 8, 'ury' => $pageHeight),
            'CropBox' => array ('llx' => 0, 'lly' => 30 , 'urx' => $pageWidth, 'ury' => $pageHeight),
            'BleedBox' => array ('llx' => 0, 'lly' => 0, 'urx' => $pageWidth, 'ury' => $pageHeight),
            'TrimBox' => array ('llx' => 0, 'lly' => 0, 'urx' => $pageWidth, 'ury' => $pageHeight),
            'ArtBox' => array ('llx' => 0, 'lly' => 0, 'urx' => $pageWidth, 'ury' => $pageHeight),
            'Dur' => 5,
            'trans' => array(
                'D' => 1.5,
                'S' => 'Split',
                'Dm' => 'V',
                'M' => 'O'
            ),
            //'Rotate' => 90,
            'PZ' => 1
        ); 
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetFooterMargin(0);


//$pdf->SetFont("helveticacondensed", "R",7, “,"false");
//$pdf->SetFont('verdana', 'B', 6, '', false);
//$pdf->SetFont('times', 'R', 7, '', false);

$fontname = TCPDF_FONTS::addTTFfont(plugin_dir_path( __FILE__ ).'/assets/helveticacdlt.ttf', 'TrueTypeUnicode', '', 96);
$pdf->SetFont($fontname, 'R',7, '', false);

// $fontname = TCPDF_FONTS::addTTFfont(plugin_dir_path( __FILE__ ).'/assets/helvetica-condensed.ttf', 'TrueTypeUnicode', '', 96);
// $pdf->SetFont($fontname, 'R',7, '', false);

$pdf->AddPage($pageOrientation,$page_format,false,false); 

$pdf->setCellHeightRatio(0.95);
// set cell padding
$pdf->setCellPaddings(2.5, 2.5, 3, 2);
// set cell margins
$pdf->setCellMargins(0,0, 0,0);



//content
$contentPadding = 1;
$contentPercentage = .20;

$contentWidth = $secColWidth * $contentPercentage - 3;
$contentHeight = $height - 2;

$contentXPos =  $firstColWidth + $contentPadding;
$contentYPos =  $contentPadding;


$tableYPos = $offset;
$contactContainerPosY = $height -6;

for( $i = 0; count($restaurants_value) > $i; $i++)
{  
    // table
    $pdf->MultiCell($firstColWidth, $height ,'', 1, 'L', 0, 0, $offset, $tableYPos, true);
    $pdf->MultiCell($secColWidth - $offset, $height,'', 1, 'L', 0, 0, $offset + $firstColWidth, $tableYPos, true);

    $img = wp_get_attachment_image_src($restaurants_value[$i]['_thumbnail_id'],'large')[0];


    $isRender = true;

    $extention = end(explode('.', $img));

    if($img){

     if($extention == 'svg'){   

                $svgfile = simplexml_load_file($img);
                $attr = $svgfile->attributes();
               
                $imageRatio = .70;  
                $imageWidth = $attr->width;
                $imageHeight = $attr->height;

                $fColHeight = $contentHeight - 10;

                $ratioArr = array( $firstColWidth / $imageWidth, $fColHeight / $imageHeight );
                $ratio = min($ratioArr);
           
                if($imageWidth > $imageHeight)
                {
                    $shrinkedImageWidth = ($imageWidth * $ratio) * $imageRatio;
                    $shrinkedImageHeight = ($imageHeight * $ratio) * $imageRatio;
                }else{

                    $shrinkedImageWidth = $imageWidth * $ratio;
                    $shrinkedImageHeight = $imageHeight * $ratio;
            }
        }else{

            if(getimagesize($img)){

                $imageSize = getimagesize($img);
                $imageRatio = .70;  
                $imageWidth = $imageSize[0];
                $imageHeight = $imageSize[1];

                $ext = explode("/",$imageSize['mime']);
                $shrinkedImageWidth = 0;
                $shrinkedImageHeight = 0;

                $fColHeight = $contentHeight - 11;

                $ratioArr = array( $firstColWidth / $imageWidth, $fColHeight / $imageHeight );
                $ratio = min($ratioArr);
           
                if($imageWidth > $imageHeight)
                {
                    $shrinkedImageWidth = ($imageWidth * $ratio) * $imageRatio;
                    $shrinkedImageHeight = ($imageHeight * $ratio) * $imageRatio;
                }else{

                    $shrinkedImageWidth = $imageWidth * $ratio;
                    $shrinkedImageHeight = $imageHeight * $ratio;
                }

            }else
            {
                $isRender = false;
            }
        }       
       
    }else{
        $isRender = false;
    }

    if($img && $isRender)
    {
            $imageXpo = (($firstColWidth - $shrinkedImageWidth) / 2) + ($offset);
            $imageYpo = $tableYPos + $contentPadding + 2;

        if($extention == 'svg'){
            $imageYpo = $imageYpo - 2;
            $pdf->ImageSVG($img, $imageXpo, $imageYpo, $shrinkedImageWidth, $shrinkedImageHeight,'','','',0,false);
        }else{        
            $pdf->Image($img, $imageXpo, $imageYpo, $shrinkedImageWidth, $shrinkedImageHeight, $ext[2], '', '', true, 150, '', false, false, 0, false, false, false);
        }
    }

    //contact
    $pdf->MultiCell($firstColWidth, $defaultHeight + 1,$restaurants_value[$i]['address']."\n".' '.$restaurants_value[$i]['telephone']."\n".$restaurants_value[$i]['web_url'], 0, 'C', 0, 0, $offset, $contactContainerPosY - 10, true);

    // //content
    $pdf->MultiCell($secColWidth - 10, $defaultHeight,$restaurants_value[$i]["general_text"], 0, 'L', 0, 0,($offset + $firstColWidth) + $contentPadding, $tableYPos + $height - 10 + 3, true);
    
    $week = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday");
    $weekValues = array("Monday" => null, "Tuesday" => null, "Wednesday" => null, "Thursday" => null, "Friday" => null);
    $nowDate = strtotime(date("Y-m-d"));
    $nowWeekDay = getdate($nowDate);
    $nowWeekNumber =  weekOfMonth($nowDate);
    for( $j = 0; count($menu_value) > $j; $j++)
    {
        
         if($menu_value[$j]['restaurant_menu'] == $restaurants_value[$i]["ID"]){


          //assign value
            foreach($weekValues as $key => $value)
            {
                for( $l = 0; count($menu_value[$j]['menu_list']) > $l; $l++){
                    $timestamp = strtotime($menu_value[$j]['menu_date'][$l]);
                    $weekDay = getdate($timestamp); 
                    $weekNumber = weekOfMonth($timestamp); 

                    $weekNumber = weekOfMonth($timestamp); 
                    $nowWeekNum = date("W", $nowDate);
                    $menuDateWeekNumber = date("W",$timestamp);  
                    
                    if($nowWeekNum == $menuDateWeekNumber && $key == $weekDay['weekday'])
                    {
                        $weekValues[$key] = $menu_value[$j]['menu_list'][$l];
                    }
                   
                }
            }

        $specialChar = array( 
                                "&amp;" => "&",
                                "&auml;" => "ä",
                                "&Auml;" => "Ä",
                                "&ouml;" => "ö",
                                "&Ouml;" => "Ö",
                                "&eacute;" => "é",
                                "&Eacute;" => "É",
                                "&aring;" => "å",
                                "&Aring;" => "Å",
                                "&egrave;" => "È",
                                "&egrave;" => "è",
                                "&agrave;" => "à",
                                "&Agrave;" => "À",
                                "&Ocirc;" => "Ô",
                                "&ocirc;" => "ô",
                                "&nbsp;" => " "
                                //"<li>" => "•  "
                    );
       
     
        $menuList = array();

           foreach($weekValues as $key => $value)
           {
               
           // echo $value;
                if(!empty($value) && isset($value) && $value != null)
                {

                    //$value = strip_tags($value, '<ul></ul>');

                    //$value = utf8_decode($value);

                

                   if ( strpos( $value, "<li>" ) == false ) {

                        foreach ($specialChar as $key => $charValue) {
                           if( strpos( $value, $key ) !== false ) {
                                   $value = str_replace($key,$charValue, $value);
                                }
                        }

                       $value = trim(strip_tags($value));

                          $pdf->MultiCell($contentWidth + 2, $contentHeight - $contentPadding,"\n  ".$value, 0, 'L', 0, 0, $contentXPos - 3,$contentYPos - 4, true);
                   }else{

                        $doc->loadHTML($value);
                    $liList = $doc->getElementsByTagName('li');
                    $liValues = array();
                    foreach ($liList as $li) {
                        $liValues[] = "• ".$li->nodeValue;
                    }
                        $prevY = $contentYPos;
                        $count = 0;

                        foreach ($liValues as $key => $menuLi) {
                            // store current object
                            $pdf->startTransaction();

                                $lines = $pdf->MultiCell($contentWidth, $contentHeight - $contentPadding,"\n".$menuLi, 0, 'L', 0, 0, $contentXPos ,$contentYPos - 3, true) - 1;
                            $pdf = $pdf->rollbackTransaction();

                               if($lines == 2){
                                $addPosY = 5;
                            }elseIf($lines == 3){
                                $addPosY = 7.5;
                            }elseIf($lines == 4){
                                $addPosY = 10.5;
                            }elseif($lines == 5){
                                $addPosY = 12.5;
                            }elseif($lines == 6){
                                $addPosY = 15.5;
                            }elseif($lines == 7){
                                $addPosY = 17.5;
                            }elseif($lines == 8){
                                $addPosY = 19.5;
                            }elseif($lines == 9){
                                $addPosY = 21.5;
                            }elseif($lines == 10){
                                $addPosY = 23.5;
                            }else{
                                $addPosY = 2.5;
                            }
                            $line = 0;
                            $prevLine = $addPosY;
                            $contentYPosDot = $count == 0 ? $contentYPos - 1 : $contentYPos - 4 + $addPosY -1;



                             $pdf->MultiCell($contentWidth, $contentHeight - $contentPadding,"\n".$menuLi, 0, 'L', 0, 0, $contentXPos - 1,$contentYPos - 4, true);

                             //$pdf->MultiCell($contentWidth, $contentHeight - $contentPadding,"•", 0, 'L', 0, 0, $contentXPos -1.5 ,$contentYPosDot, true);

                              // $pdf->MultiCell($contentWidth, $contentHeight - $contentPadding,"•", 0, 'J', 0, 0, $contentXPos - 1 ,$contentYPosDot, true);
                         
                            //get height of the text then add it on the content Ypos
                            $contentYPos += $prevLine;
                            $count++;
                        }

                        $count = 0;
                        $contentYPos = $prevY;

                   }

                   
                    
                    

                    $contentXPos += ( $contentWidth + $contentPadding );


                }else
                {


                    $cellHeight = $contentHeight - $contentPadding - 5;

                    $pdf->MultiCell($contentWidth, $cellHeight,"\n".trim(strip_tags($restaurants_value[$i]['no_menu'])), 0, 'L', 0, 0, $contentXPos ,$contentYPos - 4, true);
                    $contentXPos += ( $contentWidth + $contentPadding );
                }

              //  $displayValue = "";
           }
                        
         }

       
    }

    
    $tableYPos += $height;
    $contactContainerPosY += $height;
    $contentYPos += $height;
    $contentXPos = $offset + $firstColWidth + $contentPadding;

}



if( $pdf->getNumPages() > 1){
    $lastPage = $pdf->getPage();
    $pdf->deletePage(2);
}

$pdf->Output('example_010.pdf', 'I');


