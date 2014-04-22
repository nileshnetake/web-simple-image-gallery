jQuery(document).ready(function(){
    jQuery("#ws_form_add").submit(wssubmit);
    function wssubmit(){
        var newForm = jQuery(this).serialize();
        var flag = 0;
        jQuery('.required', '#ws_form_add').each(function(){
            var inputVal = jQuery(this).val();
            if(jQuery.trim(inputVal) === ""){
                jQuery(this).addClass("invalid");
                flag = 1;
            }else{
                jQuery(this).removeClass("invalid");
            }
        });
        jQuery("#ws_form_add .invalid").first().focus();
        return flag ? false : true;
    }
});
