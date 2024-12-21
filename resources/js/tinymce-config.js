const tinymceConfig = {
    selector: '#content',
    height: 500,
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
        'insertdatetime', 'media', 'table', 'help', 'wordcount', 'codesample'
    ],
    toolbar: 'undo redo | blocks | ' +
        'bold italic backcolor | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'removeformat | codesample | help',
    keep_styles: true,
    forced_root_block: 'p',
    browser_spellcheck: true,
    paste_block_drop: false,
    paste_data_images: true,
    paste_remove_styles_if_webkit: false,
    paste_merge_formats: true,
    content_style: `
        body { 
            margin: 1rem; 
            max-width: 100%;
            font-size: 16px;
        }
        p { margin: 0; padding: 0.5rem 0; }
        pre { background: #f4f4f4; padding: 1rem; border-radius: 4px; }
        code { font-family: monospace; }
    `,
    setup: function(editor) {
        editor.on('paste', function(e) {
            e.preventDefault();
            const text = e.clipboardData.getData('text/plain');
            
            // Split content into blocks by double newlines
            const blocks = text.split(/\n\n+/);
            const converter = new showdown.Converter();
            
            // Process each block
            const processedBlocks = blocks.map(block => {
                // Check if block looks like code
                const isCode = /^[ \t]/.test(block) || block.includes('\n ') || block.includes('\n\t');
                
                if (isCode) {
                    // Wrap code blocks
                    return `<pre><code>${block.replace(/</g, '&lt;').replace(/>/g, '&gt;')}</code></pre>`;
                } else {
                    // Convert Markdown blocks
                    return converter.makeHtml(block);
                }
            });
            
            // Join blocks and insert
            editor.insertContent(processedBlocks.join('\n\n'));
        });
    }
};

export default tinymceConfig;