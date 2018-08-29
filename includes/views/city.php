<div class="form-group">
  <div class="btn btn-primary city_info">Ort info</div>
  <div class="btn btn-primary generate_pdf">Generera pdf</div>
</div>
<div class="city-container">
  <div class="row">
      <div class="col-md-12 col-lg-6">
        <div class="form-horizontal">
          <div class="form-group">
                <label for="id-city-name" class="col-md-3 control-label pad-left">Ortens namn</label>
                <div class="col-md-9">
                 <input type="hidden" name="restaurantInCity" value="">
                  <input disabled class="form-control" type="text" value="<?php echo isset($values['city_name']) ? $values['city_name'] : "" ?>" id="id-city-name" name="city_name">
              </div>
          </div>
        </div>
        <div class="form-horizontal">
          <div class="form-group">
                <label for="id-general-text" class="col-md-3 control-label pad-left">Text info vänster sida</label>
                <div class="col-md-9">
                  <textarea class="form-control" name="general_text_left" id="id-general-text-left"><?php echo isset($values['general_text_left']) ? $values['general_text_left'] : "" ?></textarea>
              </div>
          </div>
          <div class="form-group">
                <label for="id-general-text" class="col-md-3 control-label pad-left">Text info höger sida</label>
                <div class="col-md-9">
                  <textarea class="form-control" name="general_text_right" id="id-general-text-right"><?php echo isset($values['general_text_right']) ? $values['general_text_right'] : "" ?></textarea>
              </div>
          </div>
        </div>
        <div class="form-horizontal">
          <div class="form-group">
                <label for="example-text-input" class="col-md-3 control-label pad-left">Bakgrundsfärg</label>
                <div class="col-md-4">
                 <input name="background_color" id="link-color" type="text" value="<?php echo isset($values['background_color']) ? $values['background_color'] : "" ?>" />
              </div>
          </div>
        </div>
      </div>
  </div>
  <div class="row">
      <div class="col-md-12 col-lg-10">
          <div class="col-md-3">
              <h5>heading</h5>
              <div class="col-md-12">
               is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make 
              </div>
          </div>
          <div class="col-md-3">
            <h5>Font</h5>
            <div class="col-md-12">
            is simply dummy text of the printing and typesetting industry.
            </div>
          </div>
          <div class="col-md-3">
            <h5>Font</h5>
            <div class="col-md-12">
               <select style="font-family : <?php echo isset($values['font1']) ? $values['font1'] : "" ?>" class="custom-select" id="g-font-1" name="font1">
                  <option selected>Select Font</option>
                  <?php if(isset($values['font1']) && $values['font1'] != "Select Font"){ ?>
                    <option selected style="<?php echo $values['font1'] ?>"><?php echo $values['font1'] ?></option>
                  <?php } ?>
              </select>
            </div>
          </div>
      </div>
  </div>
  <div class="row">
      <div class="col-md-12 col-lg-12 pad-left">
          <!-- <div class="col-md-3"></div> -->
          <div class="col-md-12 pad-left">
              <div class="form-group">
                <label for="example-text-input" class="col-md-3 control-label pad-left">Color</label>
                <div class="col-md-4">
                  <input name="font_color" id="link2-color" type="text" value="<?php echo isset($values['font_color']) ? $values['font_color'] : '' ?>"/>
              </div>
          </div>
          </div>
      </div>
  </div>
  <div class="row">
      <div class="col-md-12 col-lg-10">
          <div class="col-md-3">
              <h5>Antal tecken dagens meny</h5>
              <div class="col-md-12">
              Vi rekommenderar ett typsnitt som 
är condensed om ni avser att 
generera en pdf till dagspress
              </div>
          </div>
          <div class="col-md-9">
              <input class="form-control" name="number_chars" type="text" value="<?php echo isset($values['number_chars']) ? $values['number_chars'] : '' ?>" id="example-text-input">  
          </div>
          </div>
      </div>
  </div>
</div>
<div class="containerGeneratePdf" style="display:none">
   <div class="row">
      <div class="col-md-6">
            <div class="form-horizontal">
              <div class="form-group">
                <label for="id-city-name" class="col-md-3 col-form-label pad-left">City Name</label>
                <div class="col-md-9">
                  <?php echo isset($values['city_name']) ? $values['city_name'] : ""; ?>
                </div>
              </div>
            </div>
        <!--     <div class="form-horizontal">
              <div class="form-group">
                  <label for="id-general-text" class="col-md-3 control-label pad-left">Radhöjd:</label>
                  <div class="col-md-9">
                      <input class="form-control" name="pdf_row_height" id="id-general-text" value="<?php echo isset($values['pdf_row_height']) ? $values['pdf_row_height'] : ""; ?>">
                  </div>
              </div>
            </div>
             <div class="form-horizontal">
              <div class="form-group">
                  <label for="id-general-text" class="col-md-3 control-label pad-left">Sidbredd:</label>
                  <div class="col-md-9">
                      <input class="form-control" name="pdf_width" id="id-general-text" value="<?php echo isset($values['pdf_width']) ? $values['pdf_width'] : ""; ?>">
                  </div>
              </div>
            </div> -->
            <div class="form-horizontal">
              <div class="form-group">
                <a class="btn btn-primary" style="margin-bottom:15px;" target="_blank" href="<?php echo get_permalink(); ?>?action=generate_pdf&width=<?php echo 250; //$values['pdf_width']; ?>&rowHeight=<?php echo 33; //$values['pdf_row_height']; ?>">Generate</a>
                <a class="btn btn-primary" style="margin-bottom:15px;" target="_blank" href="<?php echo get_permalink(); ?>?action=nextweek&width=<?php echo 250 //$values['pdf_width']; ?>&rowHeight=<?php echo 33;//$values['pdf_row_height']; ?>">Generate Next Week</a>
              </div>
            </div>
      </div>
  </div>
</div>



