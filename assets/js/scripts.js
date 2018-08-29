
//wp-styles
jQuery(function() {
    jQuery("#my-meta-box").removeClass("postbox");
});


jQuery(function() {
    var selectCity = jQuery('select#city');
    var selectRestaurant = jQuery('select#restaurant');
    var optionRestaurant = selectRestaurant.find('option.res-options');

    optionRestaurant.hide();


    selectCity.on("change", function() {

        var selectedCity = jQuery(this).val();

        optionRestaurant.hide();
        selectRestaurant.find("option." + selectedCity).show();
    });

});

//cities
jQuery(function() {
        var btnGenerate = jQuery(".generate_pdf");
        var btnInfo = jQuery(".city_info");
        var containerForCity = jQuery(".city-container");
        var containerForGeneratePdf = jQuery(".containerGeneratePdf");

        btnGenerate.on("click", function() {

            containerForCity.hide();
            containerForGeneratePdf.show();

        });

        btnInfo.on("click", function() {

            containerForCity.show();
            containerForGeneratePdf.hide();

        })


    })
    //google Font
jQuery(function() {
    var googleFontApiUrl = "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyAoU3R6S_5Pt4kSuH43JFLVdo1s3uR5GAI";
    var firstSelector = jQuery('#g-font-1');
    var secondSelector = jQuery('#g-font-2');

    var head = jQuery('html').find('head');
    head.append('<style type="text/css" class="font-face"></style>');

    var styleContainer = jQuery('style.font-face');

    jQuery.ajax({
        dataType: "json",
        url: googleFontApiUrl,
        success: function(data) {
            jQuery.each(data.items, function(index, value) {

                styleContainer.append('@font-face{ font-family : ' + value.family + '; src : url(' + value.files.regular + ');}')

                firstSelector.append('<option style="font-family:' + value.family + ';">' + value.family + '</option>');
                //secondSelector.append('<option style="font-family:' + value.family + ';">' + value.family + '</option>');
            });
        }
    });
});

   