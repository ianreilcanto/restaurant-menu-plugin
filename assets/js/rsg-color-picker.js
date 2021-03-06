/*!
* Iris Color Picker Demo Script
* @author: Rachel Baker ( rachel@rachelbaker.me )
*/
(function($) {
    "use strict";
    function pickColor(color) {
        $("#link-color").val(color);
    }
    function toggle_text() {
        var link_color = $("#link-color");
        if ("" === link_color.val().replace("#", "")) {
            link_color.val(default_color);
            pickColor(default_color);
        } else pickColor(link_color.val());
    }
    var default_color = "fbfbfb";
    $(document).ready(function() {
        var link_color = $("#link-color");
        link_color.wpColorPicker({
            change: function(event, ui) {
                pickColor(link_color.wpColorPicker("color"));
            },
            clear: function() {
                pickColor("");
            }
        });
        $("#link-color").click(toggle_text);
        toggle_text();
    });
})(jQuery);

(function($) {
    "use strict";
    function pickColor(color) {
        $("#link2-color").val(color);
    }
    function toggle_text() {
        var link_color = $("#link2-color");
        if ("" === link_color.val().replace("#", "")) {
            link_color.val(default_color);
            pickColor(default_color);
        } else pickColor(link_color.val());
    }
    var default_color = "fbfbfb";
    $(document).ready(function() {
        var link_color = $("#link2-color");
        link_color.wpColorPicker({
            change: function(event, ui) {
                pickColor(link_color.wpColorPicker("color"));
            },
            clear: function() {
                pickColor("");
            }
        });
        $("#link2-color").click(toggle_text);
        toggle_text();
    });
})(jQuery);

//https://github.com/rachelbaker/iris-color-picker-demo