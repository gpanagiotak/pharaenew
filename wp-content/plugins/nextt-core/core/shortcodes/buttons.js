/*
 THIS FILE IS RESPONSIBLE TO CREATE BUTTONS FOR THE TINY NCE EDITOR
 BUTTONS FILE PARENT IS THE REGISTER.PHP FILE IN THIS FOLDER
 */

//(function() {

    // helpers functions
    function getAttr(s, n) {
        n = new RegExp(n + '=\"([^\"]+)\"', 'g').exec(s);
        return n ?  window.decodeURIComponent(n[1]) : '';
    };

    function html( cls, data ,con, url, image) {
        var placeholder = url + '/placeholders/' + image;
        data = window.encodeURIComponent( data );
        content = window.encodeURIComponent( con );
        return '<img src="' + placeholder + '" class="mceItem ' + cls + '" '+ 'data-sh-sh="' + cls + '" ' + 'data-sh-attr="' + data + '" data-sh-content="'+ con+'" data-mce-resize="false" data-mce-placeholder="1" style="cursor: pointer"/>';
    }

    function replaceShortcodes( content, url, image, shortcode ) {
        var regex = new RegExp(/\[xxxx([^\]]*)\]([^\]]*)\[\/xxxx\]/g);

        regex = (regex.toString()).substr(1);
        regex = regex.substr(0, regex.length - 2);
        regex = regex.replace(/xxxx/g, shortcode);
        regex = new RegExp(regex, 'g');

        return content.replace( regex, function( all, attr, con) {
            return html( shortcode, attr , con, url, image);
        });
    }

    function restoreShortcodes( content ) {
        return content.replace( /(?:<p(?: [^>]+)?>)*(<img [^>]+>)(?:<\/p>)*/g, function( match, image ) {
            var data = getAttr( image, 'data-sh-attr' );
            var con = getAttr( image, 'data-sh-content' );
            var sh = getAttr( image, 'data-sh-sh' );
            if ( data ) {
                return '<p>[' + sh + data + ']' + con + '[/'+sh+']</p>';
            }
            return match;
        });
    }


    var popup = popup || {};

    popup = {

        maxImageSelectBox: 10,

        image: {},

        // Open the media select file
        media: function(e) {


            var id = e.control._id;


            console.log('the id', id);


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
                var selectedSize = jQuery('.attachment-display-settings > .setting > .size ').val();
                var json = window.mb.frame.state().get('selection').first().toJSON();
                popup.image[id] = json.sizes[selectedSize].url + '?image_id='+json.id;
                var numID = id.match(/\d/g);
                numID = numID.join("");
                jQuery('#'+'container-image-'+numID+'-body').html('<img src="'+json.url+'" style="height:100%; width:100%">');
                jQuery('#'+'container-image-'+numID).html('<img src="'+json.url+'" style="height:100%; width:100%">');
            });

            window.mb.frame.open();
        }
    };

    // End Function generate_shortcode
    var generate_shortcode = function(editor, url, settings){


        // Add a custom command to tiny mce (we can call this command - function with callCommand method)
        editor.addCommand(settings.name, function(ui, v){



            // Find how many field we have
            var i, image_index = 0, fields = [];

            // Foreach field create the tiny mce pop up elements
            for(i=0; i < settings.fields.length; i++){

                // If this field is an image
                if(settings.fields[i].type == 'image'){

                    // set the image equals to null - this is usefull only on start
                    popup.image["image-"+image_index] = null;

                    // check if the v (value) if is already set, that means we are in edit mode
                    if(v[settings.fields[i].id] != undefined && v[settings.fields[i].id] != null){
                        popup.image["image-"+image_index] = v[settings.fields[i].id];
                    }

                    // Push the fields (this is for a image field)
                    fields.push({type: 'button', name: settings.fields[i].id , text: settings.fields[i].label, onclick: popup.media, id: 'image-' + image_index});
                    fields.push( {type: 'container', html: '', id: 'container-image-' + image_index, style: 'height: 200px; width: 100%;'});
                    settings.fields[i].imageId = 'image-' + image_index;

                }// End if image

                // If this field is an text input
                if(settings.fields[i].type == 'textbox'){

                    // push the fields
                    fields.push({type: 'textbox',  name: settings.fields[i].id, label: settings.fields[i].label, value: v[settings.fields[i].id]});

                } // End if text box

                // If this field is an listbox (select)
                if(settings.fields[i].type == 'listbox'){

                    var listbox_fields = [];
                    for(var k = 0; k < settings.fields[i].values.length; k++){

                        var this_listbox_field = settings.fields[i];

                        if(this_listbox_field.values[k].value == v[settings.fields[i].id]){
                            listbox_fields.push({value: this_listbox_field.values[k].value, text: this_listbox_field.values[k].text, selected: true});
                        }else{
                            listbox_fields.push({value: this_listbox_field.values[k].value, text: this_listbox_field.values[k].text, selected: false});
                        }

                    }
                    fields.push({type: 'listbox', name: settings.fields[i].id, label: settings.fields[i].label, values: listbox_fields});
                }


            } // End For

            // If we have content
            if(settings.content){
                fields.push({type: 'textbox',  name: "contentbet", label: "Content", value: v["contentbet"]});
            }

            // Get the selected content
            var selectionText = tinyMCE.activeEditor.selection.getContent();


            // Open a pop up window and set the properties
            editor.windowManager.open({
                title: settings.title,
                body: fields,
                onsubmit: function(e){
                    editor.focus();

                    // Start to create the shortcode
                    var shortcodeString = '[' + settings.name + ' ';

                    console.log(settings);

                    // For each param create string shortcode
                    var k;
                    for(k=0; k < settings.fields.length; k++){

                        if(settings.fields[k].type != 'image' && settings.fields[k].id != 'contentbet' ){
                            shortcodeString = shortcodeString + settings.fields[k].id + '="' + e.data[settings.fields[k].id ] + '"' + ' ';
                        }else{
                            var imageId = settings.fields[k].imageId;
                            shortcodeString = shortcodeString + settings.fields[k].id + '="' +   popup.image[imageId] + '"' + ' ';
                        }

                    }
                    shortcodeString = shortcodeString + ']';

                    // If this shortcode has content
                    if(settings.content){
                        shortcodeString = shortcodeString + e.data["contentbet"] ;
                        //shortcodeString = shortcodeString + e.data["contentbet"] + selectionText;
                    }

                    // Close the shortcode
                    shortcodeString = shortcodeString + '[/' + settings.name + ']';

                    editor.selection.setContent(shortcodeString);

                }// end of onsubmit method

            }); // End of popup

        }); // End of create command


        // Add button to tiny mce
        editor.addButton(settings.name, {
            text: '',
            title: settings.title,
            icon: settings.name,
            onclick: function() {

                // Create params
                var params = {};
                var p;
                for(p=0; p < settings.fields.length; p++){
                    params[settings.fields[p].id] = '';
                }

                // Call the popup function
                editor.execCommand(settings.name,'', params);

            } // End on click
        });
            


        //replace from shortcode to an image placeholder
        editor.on('BeforeSetcontent', function(event){
            if(settings.placeholder != null)
                event.content = replaceShortcodes( event.content, url, settings.placeholder, settings.name );
        });


        //replace from image placeholder to shortcode
        editor.on('GetContent', function(event){
            if(settings.placeholder != null)
                event.content = restoreShortcodes(event.content, settings.name);
        });

        // When user click on tiny mce placehold should open the shortcode's popup
        editor.on('DblClick',function(e) {
            var cls  = e.target.className.indexOf(settings.name);
            if ( e.target.nodeName == 'IMG' && e.target.className.indexOf(settings.name) > -1 ) {

                //console.log(e.target.attributes['data-sh-attr'].value);
                var title = e.target.attributes['data-sh-attr'].value;

                title = window.decodeURIComponent(title);

                var content = e.target.attributes['data-sh-content'].value;

                // Define the params
                var k;
                var params = {};
                var image_container_counter = 0;
                for(k=0; k < settings.fields.length; k++){
                    params[settings.fields[k].id] = getAttr(title, settings.fields[k].id)
                }

                if(settings.content){
                    params["contentbet"] = content;
                }

                editor.execCommand(settings.name, '', params);

                for(k=0; k < settings.fields.length; k++){
                    if(settings.fields[k].type == 'image'){
                        jQuery("#container-image-"+image_container_counter+'-body').html('<img src="'+getAttr(title, settings.fields[k].id)+'" style="height:100%; width:100%">');
                        image_container_counter++;
                    }
                }

            } // End If
        });
    };

    /*********************************************************************
     * DROP CAP
     *********************************************************************/

        // Drop Cap
    tinymce.PluginManager.add('drop_cap', function( editor, url ) {
        editor.addButton('drop_cap', {
            text: '',
            title: 'Drop Cap',
            icon: 'drop-cap',
            onclick: function() {
                var selectionText = tinyMCE.activeEditor.selection.getContent();

                tinyMCE.activeEditor.selection.setContent( '<span class="shortcode-drop-cap" style="  font-size: 50px;font-weight: 400;float: left;width: 50px;line-height: 80%;">'+selectionText+'</span>' );
            }
        });
    });



    /*********************************************************************
     * HR
     *********************************************************************/

    // hr
    tinymce.PluginManager.add('hr', function( editor, url ) {
        editor.addButton('hr', {
            text: '',
            title: 'Horizontal Line',
            icon: 'hr',
            onclick: function() {
                popup.images = {};
                tinyMCE.activeEditor.selection.setContent( '[hr]');
            }
        });
    });




    /*********************************************************************
     * COL
     *********************************************************************/

    // Col Button
    tinymce.PluginManager.add('col', function( editor, url ) {

        var settings = {
            name: 'col',
            title: 'Bootstrap Col',
            content: true,
            placeholder: null,
            fields: [
                {type: 'textbox', id: 'length', label: 'Bootstrap Length (1,...,12)'},
                {type: 'textbox', id: 'type', label: 'Bootstrap type (md-sm-xs-lg)'},
                {type: 'textbox', id: 'first', label: 'If this element is first (true/false)'},
                {type: 'textbox', id: 'last', label: 'If this element is last (true/false)'}
            ]
        };

        new generate_shortcode(editor, url, settings);

    });




    /*********************************************************************
     * DIV
     *********************************************************************/

    // div
    tinymce.PluginManager.add('div', function( editor, url ) {

        var settings = {
            name: 'div',
            title: 'Create Div',
            content: true,
            placeholder: null,
            fields: [
                {type: 'textbox', id: 'id', label: 'Id of the div'},
                {type: 'textbox', id: 'class', label: 'Add Custom Class'},
                {type: 'textbox', id: 'content', label: 'Div content'}
            ]
        };

        new generate_shortcode(editor, url, settings);

    });



    /*********************************************************************
     * FUNKY BOX BUTTON
     *********************************************************************/

    // Funky Box Button
    tinymce.PluginManager.add('funky_box', function( editor, url ) {

        var settings = {
            name: 'accordion',
            title: 'Accordion',
            content: true,
            placeholder: 'action_box.png',
            fields: [
                {type: 'textbox', id: 'first', label: 'If this element is first (true/false)'},
                {type: 'textbox', id: 'last', label: 'If this element is last (true/false)'},
                {type: 'textbox', id: 'out_col', label: 'Col size (bootstrap)'},
                {type: 'image', id: 'img', text: 'Select Image'},
                {type: 'textbox', id: 'height', label: 'Height ex(400px)'},
                {type: 'textbox', id: 'title', label: 'Add the Title of Accordion'},
                {type: 'textbox', id: 'link', label: 'Link (htt://yourlink.gr)'},
                {type: 'textbox', id: 'content', label: 'Add the Content '},
                {type: 'textbox', id: 'col_size', label: 'Box Col Size (bootstrap col-12)'}
            ]
        };

        new generate_shortcode(editor, url, settings);
    });





    /*********************************************************************
     * ACCORDION
     *********************************************************************/

    // accordion
    tinymce.PluginManager.add('accordion', function( editor, url ) {

        var settings = {
            name: 'accordion',
            title: 'Accordion',
            content: true,
            placeholder: 'accordion.png',
            fields: [
                {type: 'textbox', id: 'first', label: 'If this element is first (true/false)'},
                {type: 'textbox', id: 'last', label: 'If this element is last (true/false)'},
                {type: 'textbox', id: 'title', label: 'Add the Title of Accordion'},
            ]
        };

        new generate_shortcode(editor, url, settings);

    });



    /*********************************************************************
     * TITLE
     *********************************************************************/
    // title
    tinymce.PluginManager.add('title', function( editor, url ) {

        var settings = {
            name: 'title',
            title: 'Title',
            content: true,
            placeholder: 'title.png',
            fields: [
                {type: 'textbox', id: 'type', label: 'The HTML Element Type ex(h1, h2, span)'},
                {type: 'textbox', id: 'classes', label: 'Add Custom Class for the title'},
                {type: 'textbox', id: 'sub', label: 'Add the Subtitle content'},
                {type: 'textbox', id: 'subclass', label: 'Add the Subtitle Class'},
                {type: 'textbox', id: 'subtype', label: 'Add the subtitle HTML Element ex(span)'},
                {type: 'textbox', id: 'subpos', label: 'Subtitle position (start, end, start_out, end_out)'},
            ]
        };

        new generate_shortcode(editor, url, settings);

    });



    /*********************************************************************
     * IMAGE TEXT
     *********************************************************************/
    // imagetext
    tinymce.PluginManager.add('imagetext', function( editor, url ) {

        var settings = {
            name: 'imagetext',
            title: 'Image Text',
            content: true,
            placeholder: 'image_text.png',
            fields: [
                {type: 'image', id: 'img', label: 'Select Image'},
                {type: 'textbox', id: 'imgwidth', label: 'Image Width (400px)'},
                {type: 'textbox', id: 'contentwidth', label: 'Content Width (400px)'}
            ]
        };

        new generate_shortcode(editor, url, settings);

    });



    /*********************************************************************
     * BUTTON
     *********************************************************************/
    // button
    tinymce.PluginManager.add('nexttbutton', function( editor, url ) {

        var settings = {
            name: 'nexttbutton',
            title: 'Button',
            content: true,
            placeholder: 'button.png',
            fields: [
                {type: 'textbox', id: 'class', label: 'Classes'},
                {type: 'textbox', id: 'link', label: 'Link (http://google.com)'},
                {type: 'textbox', id: 'target', label: 'target'}
            ]
        };

        new generate_shortcode(editor, url, settings);
    });



    /*********************************************************************
     * HIDE MORE
     *********************************************************************/
    // Hide More
    tinymce.PluginManager.add('hidemore', function( editor, url ) {

        var settings = {
            name: 'hidemore',
            title: 'Hide More',
            content: true,
            placeholder: 'hidemore.png',
            fields: [
                {type: 'textbox', id: 'title', label: 'Title'},
                {type: 'textbox', id: 'name', label: 'Name (unique)'},
            ]
        };

        new generate_shortcode(editor, url, settings);
    });



    /*********************************************************************
     * TABLE
     *********************************************************************/
    // Table
    tinymce.PluginManager.add('table', function( editor, url ) {

        var settings = {
            name: 'table',
            title: 'Table',
            content: false,
            placeholder: 'table.png',
            fields: [
                {type: 'textbox', label: 'How many rows ', id: 'rows'},
                {type: 'textbox', label: 'Titles separated with pipe ex(T1 | T2) ', id: 'titles'},
                {type: 'textbox', label: 'Content separated with pipe ex(C1 | C2 | C3 | C4 | C5) ', id: 'content'},
            ]
        };

        generate_shortcode(editor, url, settings);

    });



   


    /*********************************************************************
     * POPUP
     *********************************************************************/
    // Popup
    tinymce.PluginManager.add('imglb', function( editor, url ) {

        var settings = {
            name: 'popup',
            title: 'Popup',
            content: true,
            placeholder: 'popup.png',
            fields: [
                {type: 'textbox', label: 'ID', id: 'id'},
                {type: 'textbox', label: 'Title', id: 'title'},
                {type: 'textbox', label: 'Footer', id: 'footer'},
                {type: 'textbox', label: 'Button Text', id: 'buttontext'}
            ]
        };

        generate_shortcode(editor, url, settings);

    });


//})();

















































































































































///*
//    THIS FILE IS RESPONSIBLE TO CREATE BUTTONS FOR THE TINY NCE EDITOR
//    BUTTONS FILE PARENT IS THE REGISTER.PHP FILE IN THIS FOLDER
// */
//
//(function() {
//
//    // helpers functions
//    function getAttr(s, n) {
//        n = new RegExp(n + '=\"([^\"]+)\"', 'g').exec(s);
//        return n ?  window.decodeURIComponent(n[1]) : '';
//    };
//
//    function html( cls, data ,con, url, image) {
//        var placeholder = url + '/placeholders/' + image;
//        data = window.encodeURIComponent( data );
//        content = window.encodeURIComponent( con );
//        return '<img src="' + placeholder + '" class="mceItem ' + cls + '" ' + 'data-sh-attr="' + data + '" data-sh-content="'+ con+'" data-mce-resize="false" data-mce-placeholder="1" style="cursor: pointer"/>';
//    }
//
//    function replaceShortcodes( content, url, image, shortcode ) {
//        var regex = new RegExp(/\[xxxx([^\]]*)\]([^\]]*)\[\/xxxx\]/g);
//        regex = (regex.toString()).substr(1);
//        regex = regex.substr(0, regex.length - 2);
//        regex = regex.replace(/xxxx/g, shortcode);
//        regex = new RegExp(regex, 'g');
//
//        return content.replace( regex, function( all, attr, con) {
//            return html( shortcode, attr , con, url, image);
//        });
//    }
//
//    function restoreShortcodes( content, shortcode ) {
//        return content.replace( /(?:<p(?: [^>]+)?>)*(<img [^>]+>)(?:<\/p>)*/g, function( match, image ) {
//            var data = getAttr( image, 'data-sh-attr' );
//            var con = getAttr( image, 'data-sh-content' );
//            if ( data ) {
//                return '<p>[' + shortcode + data + ']' + con + '[/'+shortcode+']</p>';
//            }
//            return match;
//        });
//    }
//
//
//    var popup = popup || {};
//
//    popup = {
//
//        maxImageSelectBox: 10,
//
//        image: {},
//
//        // Open the media select file
//        media: function(e) {
//
//            var id = e.control._id;
//
//            window.mb = window.mb || {};
//
//            window.mb.frame = wp.media({
//                frame: 'post',
//                state: 'insert',
//                library : {
//                    type : 'image'
//                },
//                multiple: false
//            });
//
//            window.mb.frame.on('insert', function() {
//                var json = window.mb.frame.state().get('selection').first().toJSON();
//                popup.image[id] = json.url;
//                jQuery('#'+'container-'+id+'-body').html('<img src="'+json.url+'" style="height:100%; width:100%">');
//            });
//
//            window.mb.frame.open();
//        }
//    };
//
//
//    // Col Button
//    tinymce.PluginManager.add('col_button', function( editor, url ) {
//        editor.addButton('col_button', {
//            text: '',
//            title: 'Bootstrap Col',
//            icon: 'col-icon',
//            onclick: function() {
//                popup.images = {};
//                var selectionText = tinyMCE.activeEditor.selection.getContent();
//
//                // Open the window manager
//                editor.windowManager.open({
//                    title: 'Bootstrap Col',
//                    body: [
//                        {type: 'textbox', name: 'length', label: 'Bootstrap Length (1,...,12)'},
//                        {type: 'textbox', name: 'type', label: 'Bootstrap type (md-sm-xs-lg)'},
//                        {type: 'textbox', name: 'first', label: 'If this element is first (true/false)'},
//                        {type: 'textbox', name: 'last', label: 'If this element is last (true/false)'},
//                    ],
//                    onsubmit: function(e) {
//                        editor.focus();
//                        editor.selection.setContent('[col length="' + e.data.length + '" type="' + e.data.type + '" first="' + e.data.first + '" last="' + e.data.last + '"]'+selectionText+'[/col]');
//                    }
//                });
//                //tinyMCE.activeEditor.selection.setContent( '[col length="1" type="md" first="true" last="false"]'+selectionText+'[/col]');
//            }
//        });
//    });
//
//    // Funky Box Button
//    tinymce.PluginManager.add('funky_box', function( editor, url ) {
//        editor.addButton('funky_box', {
//            text: '',
//            title: 'Funky Box',
//            icon: 'funky-box',
//            onclick: function() {
//                popup.images = {};
//                var selectionText = tinyMCE.activeEditor.selection.getContent();
//
//                // Open the window manager
//                editor.windowManager.open({
//                    title: 'Accordion',
//                    body: [
//                        {type: 'textbox', name: 'first', label: 'If this element is first (true/false)'},
//                        {type: 'textbox', name: 'last', label: 'If this element is last (true/false)'},
//                        {type: 'textbox', name: 'out_col', label: 'Col size (bootstrap)'},
//                        {type: 'button', name: 'img', text: 'Select Image', onclick: popup.media},
//                        {type: 'textbox', name: 'height', label: 'Height ex(400px)'},
//                        {type: 'textbox', name: 'title', label: 'Add the Title of Accordion'},
//                        {type: 'textbox', name: 'link', label: 'Link (htt://yourlink.gr)'},
//                        {type: 'textbox', name: 'content', label: 'Add the Content '},
//                        {type: 'textbox', name: 'col_size', label: 'Box Col Size (bootstrap col-12)'}
//                    ],
//                    onsubmit: function(e) {
//                        editor.focus();
//                        editor.selection.setContent('[activebox_maker first="' + e.data.first + '" last="' + e.data.last + '" out_col="' + e.data.out_col + '" img="' + e.data.img + '" height="' + e.data.height + '" title="' + e.data.title + '" link="' + e.data.link + '" content="' + e.data.content + '" col_size="' + e.data.col_size + '"]');
//                    }
//                });
//                //editor.insertContent('[activebox_maker first="true" last="false" out_col="6" img="image path" height="480px" title="Our Story" link="http://www.google.com" content="Add text here" col_size="12"]');
//            }
//        });
//    });
//
//    // Drop Cap
//    tinymce.PluginManager.add('drop_cap', function( editor, url ) {
//        editor.addButton('drop_cap', {
//            text: '',
//            title: 'Drop Cap',
//            icon: 'drop-cap',
//            onclick: function() {
//                var selectionText = tinyMCE.activeEditor.selection.getContent();
//
//                tinyMCE.activeEditor.selection.setContent( '<span class="shortcode-drop-cap" style="  font-size: 50px;font-weight: 400;float: left;width: 50px;line-height: 80%;">'+selectionText+'</span>' );
//            }
//        });
//    });
//
//    // accordion
//    tinymce.PluginManager.add('accordion', function( editor, url ) {
//        editor.addButton('accordion', {
//            text: '',
//            title: 'Accordion',
//            icon: 'accordion',
//            onclick: function() {
//                popup.images = {};
//                var selectionText = tinyMCE.activeEditor.selection.getContent();
//
//                // Open the window manager
//                editor.windowManager.open({
//                    title: 'Accordion',
//                    body: [
//                        {type: 'textbox', name: 'first', label: 'If this element is first (true/false)'},
//                        {type: 'textbox', name: 'last', label: 'If this element is last (true/false)'},
//                        {type: 'textbox', name: 'title', label: 'Add the Title of Accordion'},
//                        {type: 'textbox', name: 'content', label: 'Add the Content of Accordion'},
//                    ],
//                    onsubmit: function(e) {
//                        editor.focus();
//                        editor.selection.setContent('[accordion first="' + e.data.first + '" last="' + e.data.last + '" title="' + e.data.title + '"]'+ e.data.content+selectionText+'[/accordion]');
//                    }
//                });
//
//                //tinyMCE.activeEditor.selection.setContent( '[accordion first="true" last="false" title="The_Title"]'+selectionText+'[/accordion]');
//            }
//        });
//    });
//
//    // title
//    tinymce.PluginManager.add('title', function( editor, url ) {
//        editor.addButton('title', {
//            text: '',
//            title: 'Title',
//            icon: 'title',
//            onclick: function() {
//                popup.images = {};
//                var selectionText = tinyMCE.activeEditor.selection.getContent();
//
//                // Open the window manager
//                editor.windowManager.open({
//                    title: 'Title',
//                    body: [
//                        {type: 'textbox', name: 'type', label: 'The HTML Element Type ex(h1, h2, span)'},
//                        {type: 'textbox', name: 'classes', label: 'Add Custom Class for the title'},
//                        {type: 'textbox', name: 'sub', label: 'Add the Subtitle content'},
//                        {type: 'textbox', name: 'subclass', label: 'Add the Subtitle Class'},
//                        {type: 'textbox', name: 'subtype', label: 'Add the subtitle HTML Element ex(span)'},
//                        {type: 'textbox', name: 'subpos', label: 'Subtitle position (start, end, start_out, end_out)'},
//                    ],
//                    onsubmit: function(e) {
//                        editor.focus();
//                        editor.selection.setContent('[title type="' + e.data.type + '"  classes="' + e.data.classes + '"  sub="' + e.data.sub + '"  subclass="' + e.data.subclass + '"  subtype="' + e.data.subtype + '"  subpos="' + e.data.subpos + '"]'+selectionText+'[/title]');
//                    }
//                });
//
//                //tinyMCE.activeEditor.selection.setContent( '[title type="h1"  classes="general_title title_type_1"  sub="Sub Title"  subclass="the-class"  subtype="small"  subpos="start, end, start_out, end_out"]'+selectionText+'[/title]');
//            }
//        });
//    });
//
//    // div
//    tinymce.PluginManager.add('div', function( editor, url ) {
//        editor.addButton('div', {
//            text: '',
//            title: 'Create Div',
//            icon: 'div',
//            onclick: function() {
//                popup.images = {};
//                var selectionText = tinyMCE.activeEditor.selection.getContent();
//
//                // Open the window manager
//                editor.windowManager.open({
//                    title: 'Div',
//                    body: [
//                        {type: 'textbox', name: 'id', label: 'Id of the div'},
//                        {type: 'textbox', name: 'class', label: 'Add Custom Class'},
//                        {type: 'textbox', name: 'content', label: 'Div content'}
//                    ],
//                    onsubmit: function(e) {
//                        editor.focus();
//                        editor.selection.setContent('[div class="' + e.data.class + '" id="' + e.data.id + '"]'+ e.data.content + selectionText+'[/div]');
//                    }
//                });
//
//                //tinyMCE.activeEditor.selection.setContent( '[div class="the_class" id="id"]'+selectionText+'[/div]');
//            }
//        });
//    });
//
//    // gallery
//    tinymce.PluginManager.add('group_gallery', function( editor, url ) {
//        editor.addButton('group_gallery', {
//            text: '',
//            title: 'Display Gallery',
//            icon: 'group_gallery',
//            onclick: function() {
//                popup.images = {};
//                var selectionText = tinyMCE.activeEditor.selection.getContent();
//
//                // Open the window manager
//                editor.windowManager.open({
//                    title: 'Display Gallery',
//                    body: [
//                        {type: 'textbox', name: 'category', label: 'Add Slider Category'},
//                        {type: 'textbox', name: 'class', label: 'Add Custom Class for each image'}
//                    ],
//                    onsubmit: function(e) {
//                        editor.focus();
//                        editor.selection.setContent('[group_gallery category="' + e.data.category + '" class="' + e.data.class +'"][/group_gallery]');
//                    }
//                });
//
//                //tinyMCE.activeEditor.selection.setContent( '[group_gallery category="the_category" class="the_class"][/group_gallery]');
//            }
//        });
//    });
//
//    // imagetext
//    tinymce.PluginManager.add('imagetext', function( editor, url ) {
//        editor.addButton('imagetext', {
//            text: '',
//            title: 'Image Text',
//            icon: 'imagetext',
//            onclick: function() {
//                popup.images = {};
//                var selectionText = tinyMCE.activeEditor.selection.getContent();
//
//                // Open the window manager
//                editor.windowManager.open({
//                    title: 'Image Text',
//                    body: [
//                        {type: 'button', name: 'image_url', text: 'Select Image', onclick: popup.media},
//                        {type: 'textbox', name: 'imgwidth', label: 'Image Width (400px)'},
//                        {type: 'textbox', name: 'contentwidth', label: 'Content Width (400px)'},
//                        {type: 'textbox', name: 'content', label: 'Content'}
//
//                    ],
//                    onsubmit: function(e) {
//                        editor.focus();
//                        editor.selection.setContent('[imagetext img="' + popup.image["image-1"] + '" imgwidth="' + e.data.imgwidth + '" contentwidth="' + e.data.contentwidth + '"]'+ e.data.content + selectionText+'[/imagetext]');
//                    }
//                });
//
//                //tinyMCE.activeEditor.selection.setContent( '[imagetext img="image_url" imgwidth="400px" contentwidth="400px"]'+selectionText+'[/imagetext]');
//            }
//        });
//    });
//
//    // button
//    tinymce.PluginManager.add('nexttbutton', function( editor, url ) {
//
//        editor.addButton('nexttbutton', {
//            text: '',
//            title: 'Button',
//            icon: 'nexttbutton',
//            onclick: function() {
//                popup.images = {};
//                var selectionText = tinyMCE.activeEditor.selection.getContent();
//
//                // Open the window manager
//                editor.windowManager.open({
//                    title: 'Button',
//                    body: [
//                        {type: 'textbox', name: 'class', label: 'Classes'},
//                        {type: 'textbox', name: 'link', label: 'Link (http://google.com)'},
//                        {type: 'textbox', name: 'title', label: 'Title'}
//
//                    ],
//                    onsubmit: function(e) {
//                        editor.focus();
//                        editor.selection.setContent('[button class="' + e.data.class + '" link="' + e.data.link + '"]'+ e.data.title + selectionText+'[/button]');
//                    }
//                });
//                //tinyMCE.activeEditor.selection.setContent( '[button class="nextt_button" link="http://"]'+selectionText+'[/button]');
//            }
//        });
//    });
//
//    // Hide More
//    tinymce.PluginManager.add('hidemore', function( editor, url ) {
//
//        editor.addButton('hidemore', {
//            text: '',
//            title: 'Hide More',
//            icon: 'hidemore',
//            onclick: function() {
//                popup.images = {};
//                var selectionText = tinyMCE.activeEditor.selection.getContent();
//
//                // Open the window manager
//                editor.windowManager.open({
//                    title: 'Hide More',
//                    body: [
//                        {type: 'textbox', name: 'title', label: 'Title'},
//                        {type: 'textbox', name: 'name', label: 'Name (unique)'},
//                        {type: 'textbox', name: 'content', label: 'Content'},
//                    ],
//                    onsubmit: function(e) {
//                        editor.focus();
//                        editor.selection.setContent('[hidemore title="' + e.data.title + '" name="' + e.data.name + '"]'+ e.data.content + selectionText+'[/hidemore]');
//                    }
//                });
//                //tinyMCE.activeEditor.selection.setContent( '[hidemore title="hide_more_title" name="just_an_id"]'+selectionText+'[/hidemore]');
//            }
//        });
//    });
//
//    // Table
//    tinymce.PluginManager.add('table', function( editor, url ) {
//        editor.addButton('table', {
//            text: '',
//            title: 'Table',
//            icon: 'table',
//            onclick: function() {
//                popup.images = {};
//                var selectionText = tinyMCE.activeEditor.selection.getContent();
//
//                // Open the window manager
//                editor.windowManager.open({
//                    title: 'Table',
//                    body: [
//                        {type: 'textbox', name: 'rows', label: 'How many rows ?'},
//                        {type: 'textbox', name: 'titles', label: 'Titles separated with pipe ex(T1 | T2)'},
//                        {type: 'textbox', name: 'content', label: 'Content separated with pipe ex(C1 | C2 | C3 | C4 | C5)'}
//                    ],
//                    onsubmit: function(e) {
//                        editor.focus();
//                        editor.selection.setContent('[table rows="' + e.data.rows + '" titles="' + e.data.title + '" content="' + e.data.content + '"][/table]');
//                    }
//                });
//
//                //tinyMCE.activeEditor.selection.setContent( '[table rows="2" titles="title 1 | title 2" content="content 1| content 2| content 3| content4"]'+selectionText+'[/table]');
//            }
//        });
//    });
//
//
//
//
//    var generate_shortcode = function(editor, url, settings){
//
//
//        editor.addCommand('imglb', function(ui, v) {
//            popup.image["image-0"] = v.image_url;
//
//
//            // Open the window manager
//            editor.windowManager.open({
//                title: 'Image Lightbox',
//                body: [
//                    {type: 'textbox', name: 'name', label: 'name', value: v.name},
//                    {type: 'button', name: 'image_url', text: 'Select Image', onclick: popup.media, id: 'image-0'},
//                    {type: 'container', html: '', id: 'container-image-0', style: 'height: 200px; width: 100%; background: url("'+popup.image["image-0"]+'" 100% 100%) '}
//                ],
//                onsubmit: function(e) {
//                    editor.focus();
//                    editor.selection.setContent('[imglb url="' + popup.image["image-0"] + '" name="' + e.data.name + '"][/imglb]');
//                }
//            });
//
//
//        });
//
//        editor.addButton('imglb', {
//            text: '',
//            title: 'Image LightBox',
//            icon: 'imglb',
//            onclick: function() {
//                popup.images = {};
//                var selectionText = tinyMCE.activeEditor.selection.getContent();
//
//                editor.execCommand('imglb','',{
//                    name : '',
//                    image_url : '',
//                    content: content
//                });
//
//                //tinyMCE.activeEditor.selection.setContent('[imglb url="http://thelink" name="the name"][/imglb]')
//            }
//        });
//
//
//        //replace from shortcode to an image placeholder
//        editor.on('BeforeSetcontent', function(event){
//            event.content = replaceShortcodes( event.content, url, 'test.png', 'imglb' );;
//        });
//
//
//        //replace from image placeholder to shortcode
//        editor.on('GetContent', function(event){
//            event.content = restoreShortcodes(event.content, 'imglb');
//        });
//
//        editor.on('DblClick',function(e) {
//            var cls  = e.target.className.indexOf('imglb');
//            if ( e.target.nodeName == 'IMG' && e.target.className.indexOf('imglb') > -1 ) {
//
//                //console.log(e.target.attributes['data-sh-attr'].value);
//                var title = e.target.attributes['data-sh-attr'].value;
//
//                title = window.decodeURIComponent(title);
//                //console.log(title);
//
//                var content = e.target.attributes['data-sh-content'].value;
//
//                editor.execCommand('imglb','',{
//                    name : getAttr(title,'name'),
//                    image_url : getAttr(title,'url'),
//                    content: content
//                });
//                console.log(getAttr(title,'image_url'));
//                jQuery("#container-image-0").html('<img src="'+getAttr(title,'url')+'" style="height:100%; width:100%">');
//
//            }
//        });
//    }
//
//
//    // Image Lightbox
//    tinymce.PluginManager.add('imglb', function( editor, url ) {
//
//        var settings = {
//            name: 'imglb',
//            content: false,
//            fields: [
//                {type: 'textbox', label: 'name'},
//                {type: 'image', label: 'Select Image'}
//            ]
//        };
//
//        generate_shortcode(editor, url);
//
//
//    });
//
//    // hr
//    tinymce.PluginManager.add('hr', function( editor, url ) {
//        editor.addButton('hr', {
//            text: '',
//            title: 'Horizontal Line',
//            icon: 'hr',
//            onclick: function() {
//                popup.images = {};
//                tinyMCE.activeEditor.selection.setContent( '[hr]');
//            }
//        });
//    });
//
//
//
//})();
