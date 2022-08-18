<?php

add_action( 'wp_head', function () { ?>
<script>
    jQuery(document).on("ready", function(){
        var meta_key = 'eu_extra';
        var form_id = jQuery('input[name=form_id]').val();
        var eu_extra_form_field = '#um_field_'+form_id+'_'+meta_key;
        var input_field = meta_key+'-'+form_id;
        var european = ["Austria","Belgium","Bulgaria","Croatia","Cyprus","Czechia","Denmark","Estonia","Finland","France","Germany","Greece","Hungary","Ireland","Italy","Latvia","Lithuania","Luxembourg","Malta","Netherlands","Poland","Portugal","Romania","Slovakia","Slovenia","Spain","Sweden"];

        var hide=true;
        jQuery('.um-error').each(function(i, obj) {
            if(jQuery(obj).attr('name')==input_field)hide=false;
        });
        if(hide)jQuery(eu_extra_form_field).hide();

        jQuery(function(){
            jQuery("#country").on("change", function() {
                onselection(this);
            });
        })
        
        function isEuropean(country){
            return european.indexOf(country)>=0;
        }

        function onselection(select){

            if(isEuropean(select.value)){
                jQuery('input[name='+input_field+']').val("");
                jQuery(eu_extra_form_field).show();
            } else {
                jQuery(eu_extra_form_field).hide();                
                jQuery('input[name='+input_field+']').val("#NotEU#");
            }
        }
    });
</script>
<?php } );

add_filter( 'um_add_user_frontend_submitted', 'um_add_user_frontend_submitted_eu_extra_field', 10, 1 );

function um_add_user_frontend_submitted_eu_extra_field( $args ) {

    if( in_array( '#NotEU#', $args )) {
        $key = array_search( '#NotEU#', $args );
        $args[$key] = '';
        if( isset( $args['submitted'][$key] )) $args['submitted'][$key] = '';
    }

    return $args;
}
