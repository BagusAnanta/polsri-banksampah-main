<link href="/styles.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css"
/>
<script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css" />


@props(['name', 'id', 'defaultvalue'])
<div {{ $attributes->merge(['class' => '']) }}>

<div id="toolbar-container">
  <span class="ql-formats">
    <select class="ql-font"></select>
    <select class="ql-size"></select>
  </span>
  <span class="ql-formats">
    <button class="ql-bold"></button>
    <button class="ql-italic"></button>
    <button class="ql-underline"></button>
    <button class="ql-strike"></button>
  </span>
  <span class="ql-formats">
    <select class="ql-color"></select>
    <select class="ql-background"></select>
  </span>
  <span class="ql-formats">
    <button class="ql-script" value="sub"></button>
    <button class="ql-script" value="super"></button>
  </span>
  <span class="ql-formats">
    <button class="ql-header" value="1"></button>
    <button class="ql-header" value="2"></button>
    <button class="ql-blockquote"></button>
    <button class="ql-code-block"></button>
  </span>
  <span class="ql-formats">
    <button class="ql-list" value="ordered"></button>
    <button class="ql-list" value="bullet"></button>
    <button class="ql-indent" value="-1"></button>
    <button class="ql-indent" value="+1"></button>
  </span>
  <span class="ql-formats">
    <button class="ql-direction" value="rtl"></button>
    <select class="ql-align"></select>
  </span>
  <span class="ql-formats">
    <button class="ql-link"></button>
  </span>
  <span class="ql-formats">
    <button class="ql-clean"></button>
  </span>
</div>
    <div class="mb-10" id="{{ $id }}"></div>
    <input type="hidden" name="{{ $name }}" id="quill-editor-area-{{ $name }}" value="{{ old($name, $defaultvalue) }}" />

    @push('scripts')
    <script defer>
        document.addEventListener('DOMContentLoaded', () => {
            if (document.getElementById('{{ $id }}')) {
                const editor = new Quill('#{{ $id }}', {
                    modules: {
                        toolbar: '#toolbar-container',
                        syntax: {
                            highlight: text => hljs.highlightAuto(text).value
                        },
                        formula: true
                    },
                    placeholder: 'Tulis artikel disini...',
                    theme: 'snow'
                });
                const quillEditor = document.getElementById('quill-editor-area-{{ $name }}');
                
                // Set default value if it's not empty
                const defaultValue = quillEditor.value.trim(); 
                if (defaultValue) {
                    editor.clipboard.dangerouslyPasteHTML(defaultValue); 
                }
                
                // Sync Quill with the hidden input
                editor.on('text-change', function() {
                    quillEditor.value = editor.root.innerHTML;
                });

                quillEditor.addEventListener('input', function() {
                    editor.root.innerHTML = quillEditor.value;
                });
            }
        });
    </script>
    @endpush
</div>