
jQuery(function(){

   

    $numberOfMenu = $("#number-menu-id").val();

    if($numberOfMenu == 0)
    {
         $default = $("#id-menu-list");

        if($default)
        {
            CKEDITOR.replace( 'id-menu-list' );
        }
    }

    for (var i = 0; i < $numberOfMenu; i++) {
      CKEDITOR.replace( 'id-menu-list-'+i);
    }
});



jQuery(function() {
    var addBtn = jQuery(".add-menu");
    var appendValue = jQuery(".append-here");

    addBtn.on("click", function() {
        // var rowValue = jQuery("#menu_" + 1);
        //STILL BROKEN - IT WILL COPY ONCE THERE IS ALREADY DATA
        jQuerylimitValues = jQuery("#char-limit");
        var selected = jQuery("#city").find('option:selected').text();  
        var cityArray = cityAndValue(jQuerylimitValues.val());

        var limit = GetCityLimitValue(selected, cityArray);

        var rowId = jQuery(this).attr('attr-id');

       
        var rowValue = jQuery("#" + rowId);
        if( rowValue.find("#id-date").val() == null){
            rowValue = jQuery('.menus');
        }
     

        appendValue.append("<div class='row' style='border:1px solid #000 !important;padding:10px;border-radius:5px;margin-top:5px !important;'>" + rowValue.html() + "</div>");
        rowValue = jQuery('.append-here');
        rowValue.find("#id-date").val('');
        rowValue.find("#id-menu-list").val('');
        rowValue.find("#id-menu-list").attr('maxlength',limit);
        rowValue.find("textarea").attr("id","id-menu-list");

        $default = $("#id-menu-list");

        if($default)
        {
            CKEDITOR.replace( 'id-menu-list' );
        }

        appendValue.find("#cke_id-menu-list-0").hide();


        function cityAndValue(limitValue)
        {
            var cityValue = limitValue.split(',');

            return cityValue;
        }

        function GetCityLimitValue(city, cityArray)
        {
            var value = 0;      
            for(i = 0; i < cityArray.length; i++)
            {
                var cityValue = cityArray[i].split('=');
                if(cityValue[0] == city)
                {
                    value = cityValue[1];
                }
            }

            return value;
        }

 
});

jQuery(function(){
    var removeBtn = jQuery(".remove");

    removeBtn.on("click", function() {
        var rowId = jQuery(this).attr('attr-id');

        console.log(rowId);

        var rowValue = jQuery("#" + rowId);

        rowValue.find("#id-date").val(null);
        rowValue.find("#id-menu-list").val(null);
        rowValue.find("#day-of-week").val(null);

        rowValue.remove();
    });
});

jQuery(function(){  
    var copyBtn = jQuery(".copy");


    copyBtn.on("click", function() {
        var rowId = jQuery(this).attr('attr-id');
        var rowValue = jQuery("#" + rowId);
        appendValue.append("<div class='row' style='border:1px solid #000 !important;padding:10px;border-radius:5px;margin-top:5px !important;'>" + rowValue.html() + "</div>");

    });
});

jQuery(function(){
        jQuerylimitValues = jQuery("#char-limit");
        jQuerytextArea = jQuery("textarea.menu-txt");
        jQuerycity = jQuery("#city :selected");

        jQuerycitySelection = jQuery("select#city");
        jQueryrestaurantSelection = jQuery("select#restaurant");

        var limit = 0;

        jQuerycitySelection.on('change',function(){
            var selected = jQuery(this).find('option:selected').text();  
            var cityArray = cityAndValue(jQuerylimitValues.val());
            if(selected != 'Välj stad')
            {
                limit = GetCityLimitValue(selected, cityArray);
            }
        });  

        jQuerytextArea.on('change keyup paste', function(){
            var cityArray = cityAndValue(jQuerylimitValues.val());
            //limit = GetCityLimitValue(jQuerycity.text(), cityArray);
            //console.log(limit);
            jQuery(this).attr('maxlength',limit);
            //add border color
        });


        function cityAndValue(limitValue)
        {
            var cityValue = limitValue.split(',');

            return cityValue;
        }

        function GetCityLimitValue(city, cityArray)
        {
            var value = 0;      
            for(i = 0; i < cityArray.length; i++)
            {
                var cityValue = cityArray[i].split('=');
                if(cityValue[0] == city)
                {
                    value = cityValue[1];
                }
            }

            return value;
        }


    });
});
