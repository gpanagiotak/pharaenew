/**
 * Created by christospapidas on 020715--.
 */
jQuery(function($){


    jQuery('.hotel_logo_button').click(function(){
        window.mb = window.mb || {};

        window.mb.frame = wp.media({
            frame: 'post',
            state: 'insert',
            library : {
                type : 'image'
            },
            multiple: false
        });

        window.mb.frame.on('insert', function() {
            var json = window.mb.frame.state().get('selection').first().toJSON();
            jQuery(".hotel_logo_img").attr('src', json.url);
            jQuery(".media_logo_val").attr('value', json.url);
        });

        window.mb.frame.open();
    });


});