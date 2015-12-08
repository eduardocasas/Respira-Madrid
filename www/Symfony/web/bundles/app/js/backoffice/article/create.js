$(document).ready(function() {

    /* -------- Submit Form --------*/
    
    $('#submit_button').click(function(event) {
        event.preventDefault();
        editor.preview();
        $('#article_form_article_extend_html').val($(editor.getElement('previewer').body.innerHTML).html());
        $('#article_form').submit();
    });
    
});