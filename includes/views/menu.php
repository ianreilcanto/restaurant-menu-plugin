<?php $limit = array(); ?>
<div id="main-form" class="row">
    <div class="form-inline">
        <div class="form-group">
            <label for="city">Ort:</label>
            <select class="custom-select" name="city_menu" id="city">
              <option class="select">Välj stad</option>
              <?php 
                    for( $i=0; count($city_restaurants) > $i; $i++){

                        $metaCity = get_post_meta(key($city_restaurants[$i]),"values",true);
                        $number_chars = $metaCity["number_chars"];
                        array_push($limit,$metaCity['city_name']."=".$number_chars);
                        //$limit .= $metaCity['city_name']."=".$number_chars.;

                        ?>
                         <option class="<?php echo key($city_restaurants[$i]) ?>" value="<?php echo key($city_restaurants[$i]); ?>" <?php echo isset($values["city_menu"]) ? ($values["city_menu"] == key($city_restaurants[$i]) ) ?   "selected": "" : "" ?> ><?php echo $metaCity['city_name']; ?></option>
                        <?php
                    }
              ?>
          </select>
        </div>
        <div class="form-group">
            <label for="restaurant">Restaurang:</label>
            <select class="custom-select" id="restaurant" name="restaurant_menu" value="<?php echo isset($values["restaurant_menu"]) ? $values["restaurant_menu"] : "" ?>">
              <option>Välj restaurang</option>
               <?php 
                    for( $i=0; count($city_restaurants) > $i; $i++){       
                       foreach ($city_restaurants[$i] as $restaurant_value) {

                            for($j=0; count($restaurant_value) > $j; $j++)
                            {
                                ?>
                                    <option class="<?php echo key($city_restaurants[$i]); ?> res-options" value="<?php echo $restaurant_value[$j]['ID']; ?>" <?php echo isset($values["restaurant_menu"]) ? ($values["restaurant_menu"] == $restaurant_value[$j]['ID'] ) ?   "selected": "" : "" ?>><?php echo $restaurant_value[$j]['restaurant_name'];  ?></option>
                                <?php
                            }
                       }
                    }
              ?>
          </select>
        </div>
    </div>
</div>

<?php if(!isset($values['menu_date'])){ ?>
     <input id="number-menu-id" type="hidden" name="number-menu" value="0">
    <div class="row menus" style="border:1px solid #000 !important;padding:10px;border-radius:5px;margin-top:5px !important;">
        <div class="col-md-12">
            <div class="col-md-4 pull-right">
                <div attr-id="1" class="col-md-1 pull-right btn btn-default remove" style="width:35px;height:32px;margin-left:10px">
                <i class="glyphicon glyphicon-minus"></i>
                </div>
                <div attr-id="1" class="col-md-1 pull-right btn btn-default copy" style="width:35px;height:32px">
                    <i class="glyphicon glyphicon-duplicate"></i>
                </div>
            </div>
            <br>
            <div class="col-md-12 form-group">
                <label for="id-date" class="col-md-2 col-form-label">Meny datum:</label>
                <div class="col-md-5">
                    <input class="form-control" type="date"  id="id-date" name="menu_date[]">
                </div>
            </div>
            <div class="col-md-12 form-group">
                <label for="id-menu-list" class="col-md-2 col-form-label">Meny:</label>
                <div class="col-md-5">
                    <textarea  class="form-control menu-txt" type="date"  id="id-menu-list" name="menu_list[]"></textarea>
                </div>
            </div>
            <br>
        </div>
    </div>
<?php } ?>
<?php if(isset($values["menu_date"])){ ?>
    <input id="number-menu-id" type="hidden" name="number-menu" value="<?php echo count($values["menu_date"]); ?>">
    <?php for( $i = 0; count($values["menu_date"]) > $i; $i++ ){ ?>
        <div id="menu_<?php echo $i ?>" class="row menus" style="border:1px solid #000 !important;padding:10px;border-radius:5px;margin-top:5px !important;">
            <div class="col-md-12">
                <div class="col-sm-9 col-md-10 col-lg-7">
                    <div class="form-group col-md-12">
                        <label for="id-date" class="col-md-3 col-form-label">Meny datum:</label>
                        <div class="col-md-9">
                                <input class="form-control" type="date"  id="id-date" name="menu_date[]" value="<?php echo isset($values['menu_date'][$i]) ? $values['menu_date'][$i] : '' ?>">
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="id-menu-list" class="col-md-3 col-form-label">Meny:</label>
                            <div class="col-md-9">
                                <textarea  class="form-control menu-txt" type="date"  id="id-menu-list-<?php echo $i; ?>" name="menu_list[]"><?php echo isset($values['menu_list'][$i]) ? $values['menu_list'][$i] : '' ?></textarea>
                            </div>
                    </div>
                </div>
                <div class="col-md-2 col-lg-2 col-lg-offset-3">
                    <div attr-id="menu_<?php echo $i ?>" class="col-md-1 pull-right btn btn-default remove" style="width:35px;height:32px;margin-left:10px">
                    <i class="glyphicon glyphicon-minus"></i>
                    </div>
                    <div attr-id="menu_<?php echo $i ?>" class="col-md-1 pull-right btn btn-default copy" style="width:35px;height:32px">
                        <i class="glyphicon glyphicon-duplicate"></i>
                    </div>
                </div>                   
            </div>
        </div>
    <?php } ?>
<?php } ?>

<div class="append-here">
</div>
<br>
<div class="row">
    <div attr-id=1 class="col-md-12 btn btn-default add-menu"> Lägg till meny </div>
</div>
<input id="char-limit" type="hidden" name="city-char-limit" value="<?php echo join(",",$limit); ?>">