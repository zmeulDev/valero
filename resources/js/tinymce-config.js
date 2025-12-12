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
    paste_remove_styles_if_webkit: true,
    paste_webkit_styles: 'none',
    paste_retain_style_properties: 'none',
    paste_merge_formats: true,
    paste_preprocess: function(plugin, args) {
        // Remove font families, colors, and other inline styles from pasted content
        args.content = args.content
            .replace(/style="[^"]*font-family:[^;"]*;?[^"]*"/gi, '')
            .replace(/style="[^"]*font-size:[^;"]*;?[^"]*"/gi, '')
            .replace(/style="[^"]*color:[^;"]*;?[^"]*"/gi, '')
            .replace(/style="[^"]*background-color:[^;"]*;?[^"]*"/gi, '')
            .replace(/face="[^"]*"/gi, '')
            .replace(/color="[^"]*"/gi, '')
            .replace(/style=""/gi, '');
    },
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
            // Check if pasting HTML content (from Word, Google Docs, etc.)
            const htmlData = e.clipboardData.getData('text/html');
            
            // If HTML is available, let TinyMCE handle it naturally
            if (htmlData && htmlData.trim()) {
                return; // Let default paste behavior handle HTML
            }
            
            // Only handle plain text paste
            e.preventDefault();
            const text = e.clipboardData.getData('text/plain');
            
            if (!text || !text.trim()) return;
            
            // Convert plain text to HTML preserving structure
            const lines = text.split('\n');
            let html = '';
            let inList = false;
            let currentIndentLevel = 0;
            
            lines.forEach((line, index) => {
                // Detect bullet points (*, -, •, ★, ✦, etc.)
                const bulletMatch = line.match(/^(\s*)([*\-•★✦]+)\s*(.*)$/);
                
                if (bulletMatch) {
                    const indent = bulletMatch[1].length;
                    const content = bulletMatch[3];
                    
                    if (!inList) {
                        html += '<ul>';
                        inList = true;
                        currentIndentLevel = indent;
                    } else if (indent > currentIndentLevel) {
                        html += '<ul>';
                        currentIndentLevel = indent;
                    } else if (indent < currentIndentLevel) {
                        html += '</ul>';
                        currentIndentLevel = indent;
                    }
                    
                    html += `<li>${content || ''}</li>`;
                } else {
                    // Close any open lists
                    if (inList) {
                        html += '</ul>';
                        inList = false;
                        currentIndentLevel = 0;
                    }
                    
                    // Regular paragraph
                    if (line.trim()) {
                        // Preserve leading spaces/tabs for indented paragraphs
                        const leadingSpaces = line.match(/^(\s+)/);
                        if (leadingSpaces && leadingSpaces[1].length >= 4) {
                            // Treat as preformatted if heavily indented (4+ spaces)
                            html += `<pre>${line.replace(/</g, '&lt;').replace(/>/g, '&gt;')}</pre>`;
                        } else {
                            html += `<p>${line}</p>`;
                        }
                    } else if (index < lines.length - 1) {
                        // Empty line creates paragraph break
                        html += '<p><br></p>';
                    }
                }
            });
            
            // Close any remaining open lists
            if (inList) {
                html += '</ul>';
            }
            
            editor.insertContent(html);
        });
    }
};

export default tinymceConfig;