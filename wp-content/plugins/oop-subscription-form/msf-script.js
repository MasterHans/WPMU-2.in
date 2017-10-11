/**
 * Created by SuvorovAG on 07.10.2017.
 */
jQuery(document).ready(function ($) {


        var data = {
            action: 'msf_form_submit'
        };


        //alert(JSON.stringify(data));
        jQuery.post(ajaxurl, data, function (response) {
            //parse response
            //alert('Получено с сервера: ' + response);
        });


});