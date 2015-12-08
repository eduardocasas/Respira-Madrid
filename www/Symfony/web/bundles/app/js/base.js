/*
 * Convert HTML Forms data to JSON
 * source: http://stackoverflow.com/questions/1184624/convert-form-data-to-javascript-object-with-jquery/1186309#1186309
 */

$.fn.serializeObject = function() {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

/* -------------- Loading Header Indicators -------------- */

Loading = function() {
    this.element;
    this.saved_message;
    this.error_message;
    var warning;
    var that = this;
    this.start = function(item) {
        this.removeErrorMessage();
        this.saved_message.css('display', 'none');
        this.element.css('display', 'block');
        if (item != undefined) {
            item.prop('disabled', true);
        }
        return this;
    }
    this.stop = function(item, text) {
        clearTimeout(warning);
        this.element.css('display', 'none');
        if (item != undefined) {
            item.prop('disabled', false);
        }
        if (text != undefined) {
            clearSavedDataMessage();
            if (typeof text == 'boolean') {
                text = saved_data_text;
            }
            this.saved_message.text(text).css('display', 'block').hide().fadeIn();
        }
        return this;
    }
    this.displayErrorMessage = function(message_collection) {
        if( typeof message_collection === 'string' ) {
            message_collection = [message_collection];
        }    
        var messages = '';
        var margin_top;
        for (var index in message_collection) {
            messages += '<span>'+message_collection[index]+'</span>';
        }
        this.error_message.append(messages);
        switch ($('span', this.error_message).length) {
            case 1:
                margin_top = '-30px';
                break;
            case 2:
                margin_top = '-40px';
                break;
            default:
                margin_top = '-50px';
                break;
        }
        this.error_message.css({'display': 'block', 'margin-top': margin_top}).hide().fadeIn();
        return this;
    }
    this.removeErrorMessage = function() {
        this.error_message.html('').css('display', 'none');
        return this;
    }
    clearSavedDataMessage = function() {
        warning = setTimeout(
            function() { that.saved_message.fadeOut() },
            1000*3
        );
    }
};

var Loading = new Loading();

$(document).ready(function() {
    
    if (typeof(jQuery().chosen) != 'undefined') {
        $('select').chosen();
    }
    
    Loading.element = $('#loading');
    Loading.saved_message = $('#saved_data_message');
    Loading.error_message = $('#error_data_message');

    $('#display_sidebar_button').click(function() {
        $('#sidebar').toggle();
        window.scrollTo(0, 0);
    });
    if ($(window).width() <= 1200) {
        $('#wrapper').css('padding-bottom', $('#footer').outerHeight()+20);
    }
});