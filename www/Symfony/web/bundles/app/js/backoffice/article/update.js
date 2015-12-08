$(document).ready(function() {
    
    /* -------- Delete Article --------*/
    
    $('#delete_button').click(function() {
        $('#delete_wrapper').show();
    });
    $('#delete_no_button').click(function() {
        $('#delete_wrapper').hide();
    });
    $('#delete_yes_button').click(function() {
        $.post(deleteUrl).done(function(res) {
            window.location.href= res;
        });
    });
    
    /* -------- Submit Form --------*/
    
    $('#submit_button').click(function(event) {
        event.preventDefault();
        editor.preview();
        $('#article_form_article_extend_html').val($(editor.getElement('previewer').body.innerHTML).html());
        $('#article_form').submit();
    });
    
});