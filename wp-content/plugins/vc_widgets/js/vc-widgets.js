(function($) {
    $(function() {
        if ('vc_widgets' in window && 'edit' in vc_widgets) {
            var vc_widgets_controls = {};
            $(window).on('resize scroll', function() {
                for (var id in vc_widgets.edit) {
                    if (!(id in vc_widgets_controls)) {
                        vc_widgets_controls[id] = $('<div><a href="' + vc_widgets.edit[id] + '" target="_blank">' + vc_widgets.edit_button + '</a></div>').appendTo('body').hide().css({
                            "top": "0",
                            "left": "0",
                            "width": "0",
                            "height": "0",
                            "z-index": "9999999",
                            "pointer-events": "none",
                            "position": "absolute"
                        });
                        vc_widgets_controls[id].find('a').css({                            
                            "display": "inline-block",
                            "padding": "5px 10px",
                            "color": "black",
                            "font-weight": "bold",
                            "background-color": "white",
                            "box-shadow": "0px 5px 5px rgba(0, 0, 0, 0.1)",
                            "pointer-events": "all"
                        }).on('mouseenter', function() {
                            $(this).parent().css("background-color", "rgba(0, 255, 0, 0.1)");
                        }).on('mouseleave', function() {
                            $(this).parent().css("background-color", "transparent");
                        });
                    }
                    $('#' + id).each(function() {
                        $(vc_widgets_controls[id]).css({
                            "top": $(this).offset().top,
                            "left": $(this).offset().left,
                            "width": $(this).outerWidth(),
                            "height": $(this).outerHeight(),
                        }).show();
                    });
                }
            });
            $(window).trigger('scroll');
        }
    });
})(window.jQuery);