
<div
wire:ignore
>
        <textarea id="{{ $htmlId }}" ></textarea>
    </div>

    @script
    <script>

    const getLang =() =>{
        const storedLang = localStorage.getItem('language');
switch (storedLang) {
  case 'Ar':
    return 'ar';
  case 'En':
    return 'en';
  case 'Fr': // Handle 'fr' explicitly for clarity
    return 'fr_FR';
  default:
    return 'fr_FR'; // Default to 'fr_FR' if no match or missing localStorage value
}
    }
     $wire.on('initialize-tiny-mce', () => {
     tinymce.init({
     selector: `#{{ $htmlId }}`,
    plugins: 'code table lists ',
    toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table ',
    language: getLang(),
    setup: function (editor) {
     const updateContent = (content) => {
    editor.setContent(content);
    editor.save();
    };
     editor.on('init', function () {
    updateContent(`{!! $content !!}`);
    });
    editor.on('MouseLeave', ()=>{
        @this.call('setContent',editor.getContent());
    });
    },
    });
     });
    </script>
    @endscript
