

   $(document).ready(function(){
         tinymce.init({
        selector: '#page_content',
        height: 500,
        plugins: 'advlist autolink lists link image charmap preview anchor ' +
                 'searchreplace visualblocks code fullscreen ' +
                 'insertdatetime media table code help wordcount',
        toolbar: 'undo redo | formatselect | ' +
                 'bold italic underline strikethrough | link image media | ' +
                 'alignleft aligncenter alignright alignjustify | ' +
                 'bullist numlist outdent indent | removeformat | help',
        menubar: 'file edit view insert format tools table help',
        branding: false // Hide "Powered by TinyMCE"
    });
    })

