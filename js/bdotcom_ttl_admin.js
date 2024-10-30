(function($) {
    $(function() {

        $("#bdotcom_ttl_right_opener").click(function() {
            $("#bdotcom_ttl_right").toggle("slow");
            $("#bdotcom_ttl_destination_popup_wrapper").hide();            
        });
        
        $("#bdotcom_ttl_destination_popup_wrapper").click(function() {
            $("#bdotcom_ttl_destination_popup_wrapper").fadeOut();            
        });
        
        $("#bdotcom_ttl_destination").on("input", function(){
            $("#bdotcom_ttl_destination_popup_wrapper").fadeOut();    
        });
        
        /****************  autocomplete  *****************/

        $.ajax({
            //bdotcom_ttl_objectL10n.json_keyword_path set in bdotcom_ttl_style_and_script.php
            url: bdotcom_ttl_objectL10n.json_keyword_path,
            dataType: "json",
            data: function(request) {
                term: request.term;
            },
            success: function(data) {
                var json_data = $.map(data, function(item) {
                    return {
                        label: item.word,
                        value: item.link
                    };
                });
                $("#bdotcom_ttl_destination").autocomplete({
                    source: json_data,
                    minlength: 2,
                    focus: function(event, ui) {
                        $("#bdotcom_ttl_destination").val(ui.item.label );
                        return false;
                    },
                    select: function(event, ui) {
                        $("#bdotcom_ttl_destination").val(ui.item.label); // display the selected text
                        $( "#bdotcom_ttl_destination_popup" ).html( "<span id='bdotcom_ttl_destination_popup_link'>" + ui.item.value + "?aid=" + bdotcom_ttl_objectL10n.aff_id + "</span>" ); // save selected id to hidden input
                        $("#bdotcom_ttl_destination_popup_wrapper, #bdotcom_ttl_destination_popup").fadeIn();                        
                        return false;
                    }
                });//$("#bdotcom_ttl_destination").autocomplete({
            }//success: function(data) {
        });//$.ajax({

    }); //$(function() {

})(jQuery);