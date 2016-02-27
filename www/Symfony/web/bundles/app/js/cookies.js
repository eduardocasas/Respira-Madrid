CookieObject = function() {
    this.create = function(name, value, days) {
        var expires;
        if (days) {
            var date = new Date();
            date.setTime(date.getTime()+(days*24*60*60*1000));
            expires = "; expires="+date.toGMTString();
        } else {
            expires = "";
        }
        document.cookie = name+"="+value+expires+"; path=/";
    };
    read = function(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') {
                c = c.substring(1,c.length);
            }
            if (c.indexOf(nameEQ) === 0) {
                return c.substring(nameEQ.length,c.length);
            }
        }
        return null;
    };
};
$(document).ready(function() {

    var Cookie = new CookieObject();
    $('#lssi_wrapper').show();
    $('#logo').css('margin-bottom', $('#cookies_footer_wrapper').css('height'));
    $('#footer').css('bottom', $('#cookies_footer_wrapper').outerHeight());
    $('#wrapper').css('padding-bottom', $('#cookies_footer_wrapper').outerHeight()+$('#footer').outerHeight()+20);
    $('#cookies_footer_wrapper .default_button').click(function() {
        Cookie.create('lssi', '1', 365);
        $('#cookies_footer_wrapper').slideUp("slow", function(){
            $('#logo').css('margin-bottom', 0);
            $('#footer').css('bottom', 0);
            $('#wrapper').css('padding-bottom', $('#footer').outerHeight()+20);
        });
    });
    
});