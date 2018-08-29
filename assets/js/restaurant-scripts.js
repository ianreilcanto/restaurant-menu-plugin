 //restaurants
    $(function(){

        var generalTxt = $("#id-general-text");
        var warningLabel = $("#warning-label");
        generalTxt.attr("maxlength","200");

        var myString = generalTxt.val();
        // var withoutSpace = myString.replace(/ /g,"");
        //var length = withoutSpace.length;
        var length = generalTxt.val().length;

        generalTxt.val(myString.substring(0, 200));
        //console.log(length);

        generalTxt.on("keyup",function(){
           $length = $(this).val().length;

            if($length >= 200 )
            {
                generalTxt.css("border-color", "red");
                warningLabel.show();
            }else
            {
                generalTxt.css("border-color", "#ccc");
                warningLabel.hide();
            }

        });


    });