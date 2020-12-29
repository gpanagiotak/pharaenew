//(function () {


    /*********************************************************************
     * WALLY GALLERY
     *********************************************************************/

    tinymce.PluginManager.add('wally', function (editor, url) {

        var settings = {
            name: 'wally',
            title: 'Wally Gallery',
            content: false,
            placeholder: 'gallery.png',
            fields: [
                {type: 'image', id: 'cover', label: 'Select Image'},
                {type: 'textbox', id: 'category', label: 'Category Name'},
                {type: 'textbox', id: 'button', label: 'Button Title'},
                {
                    type: 'listbox',
                    id: 'display',
                    label: 'Display Type',
                    values: [{value: 'categories', text: 'Categories'}, {value: 'block', text: 'Thumbnails'}]
                }
            ]
        };

        new generate_shortcode(editor, url, settings);

    });

//});