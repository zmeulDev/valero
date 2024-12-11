const tinymceConfig = {
    selector: '#content',
    height: 500,
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
        'insertdatetime', 'media', 'table', 'help', 'wordcount'
    ],
    toolbar: 'undo redo | blocks | ' +
        'bold italic backcolor | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'removeformat | help',
    keep_styles: true,
    forced_root_block: 'p',
    browser_spellcheck: true,
    paste_block_drop: false,
    paste_data_images: true,
    paste_remove_styles_if_webkit: false,
    paste_merge_formats: true,
    init_instance_callback: function(editor) {
        editor.execCommand('mceFocus', false);
    },
    content_style: `
        body { 
            margin: 1rem; 
            max-width: 100%;
            font-size: 16px;
        }
        p { margin: 0; padding: 0.5rem 0; }
    `,
    setup: function(editor) {
        editor.on('NodeChange', function(e) {
            e.preventDefault();
        });
    }
};

export default tinymceConfig; 