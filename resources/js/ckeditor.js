import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
ClassicEditor
    .create(document.querySelector('.ckeditor'), {
        height: '300px'
    })
    .then(editor => {
        console.log(editor);
    })
    .catch(error => {
        console.error(error);
    });
ClassicEditor
    .create(document.querySelector('.ckeditor_second'), {
        height: '300px'
    })
    .then(editor => {
        console.log(editor);
    })
    .catch(error => {
        console.error(error);
    });
