<div class="city-container">
    <div class="row">
    </div>
    <div class="row">
        <div class="col-md-12">
          <div class="form-horizontal">
            <div class="form-group">
                    <label for="id-restaurant-name" class="col-md-2 col-form-label control-label pad-left">
Namn på restaurang</label>
                    <div class="col-md-10">
                    <input disabled class="form-control" type="text" value="<?php echo isset($values['restaurant_name']) ? $values['restaurant_name'] : "" ?>" id="id-restaurant-name" name="restaurant_name">
                </div>
            </div>
            <!--<div class="form-group">
                    <label for="id-post-address" class="col-md-2 col-form-label control-label pad-left">E-postadress</label>
                    <div class="col-md-10">
                    <input class="form-control" type="text" value="<?php echo isset($values['post-address']) ? $values['post-address'] : "" ?>" id="id-post-address" name="post-address">
                </div>
            </div--!>
            <!--<div class="form-group">
                <label for="id-restaurant-logo" class="col-md-2 col-form-label">Upload Logo</label>
                <div class="col-md-10">
                  <input class="form-control" type="file" id="id-restaurant-logo" name="restaurant_logo">
              </div>
           </div>-->
            <div class="form-group">
                <label for="id-general-text" class="col-md-2 col-form-label control-label pad-left">Grundinfo</label>
                <div class="col-md-10">
                  <textarea class="form-control" name="general_text" id="id-general-text"><?php echo isset($values['general_text']) ? $values['general_text'] : "" ?></textarea>
                  <label id="warning-label" style="color:red;font-weight: 300;display: none;">varning: begränsa 200 tecken</label>
              </div>
          </div>
          <div class="form-group">
              <label for="id-no-menu" class="col-md-2 col-form-label control-label pad-left">Info (om meny saknas)</label>
              <div class="col-md-10">
                <textarea class="form-control" name="no_menu" id="id-no-menu"><?php echo isset($values['no_menu']) ? $values['no_menu'] : "" ?></textarea>
            </div>
          </div>
          <div class="form-group">
                  <label for="id-web-url" class="col-md-2 col-form-label control-label pad-left">Hemsideadress</label>
                  <div class="col-md-10">
                  <input class="form-control" type="text" value="<?php echo isset($values['web_url']) ? $values['web_url'] : "" ?>" id="id-web-url" name="web_url">
              </div>
          </div>
          <div class="form-group">
                  <label for="id-telephone" class="col-md-2 col-form-label control-label pad-left">Telefonnummer</label>
                  <div class="col-md-10">
                  <input class="form-control" type="text" value="<?php echo isset($values['telephone']) ? $values['telephone'] : "" ?>" id="id-telephone" name="telephone">
              </div>
          </div>
          <div class="form-group">
                  <label for="id-address" class="col-md-2 col-form-label control-label pad-left">Adress</label>
                  <div class="col-md-10">
                  <input class="form-control" type="text" value="<?php echo isset($values['address']) ? $values['address'] : "" ?>" id="id-address" name="address">
              </div>
          </div>
        </div>
      </div>
      <div class="row">
      <div class="col-md-12 city-section">
        <h3>Tilldela ort</h3>
      </div>
         <div class="col-md-12">
            <input type="hidden" name="selected_city">
                <table class="table table-hover list">
                    <thead>
                    <tr>
                        <th>Namn på ort</th>
                        <th>Välj</th>
                    </tr>
                    </thead>
                    <tbody>
                         <?php 
                             for($i = 0; $i < count($cities->posts); $i++){
                                    $postId = $cities->posts[$i]->ID;  
                                    $meta = get_post_meta($postId,"values",true);    
                                ?>
                                    <tr id="<?php echo $postId; ?>">
                                        <td><?php echo $meta['city_name']; ?></td>
                                        <td>
                                            <input <?php if(isset($values['selected_city'])){ if(in_array($postId,$values['selected_city'])){ echo "checked"; } } ?> type="checkbox" id="<?php echo $meta['city_name'] ?>" name="selected_city[]"  value="<?php echo $postId ?>">
                                        </td>                      
                                    </tr>
                            <?php
                             }
                        ?>
                    </tbody>
                </table>
            </div>
      </div>
  </div>
</div>

