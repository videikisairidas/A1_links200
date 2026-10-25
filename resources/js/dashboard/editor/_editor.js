export function initEditor() {
    const form = document.querySelector(".editorForm");

    if (!form) {return;}

    // load editor
    const toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
        ['blockquote', 'code-block'],
        ['link', 'image'],
            // custom button values
        [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
        [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
        [{ 'direction': 'rtl' }],                         // text direction

        [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

        [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
        [{ 'font': [] }],
        [{ 'align': [] }],

        ['clean'] 
    ];

    const editorContainer = document.querySelector("#editor");
    const editorContainer2 = document.querySelector("#editor2");



    if (editorContainer) {
        console.log("init editor 1");
        const quill = new Quill('#editor', {
            modules: {
                toolbar: {
                    container: toolbarOptions,
                    // handlers: {
                    //     'image': imageHandler
                    // }
                },
            },
            placeholder: 'Compose an epic...',
            theme: 'snow',
        });
    }
    
    if (editorContainer2) {
        console.log("init editor 2");
        const quill2 = new Quill('#editor2', {
            modules: {
                toolbar: {
                    container: toolbarOptions,
                },
            },
            placeholder: 'Compose an epic...',
            theme: 'snow',
        });
    }

    form.addEventListener("submit", function (e) {
        e.preventDefault();
        const textarea = form.querySelector('textarea[class="hiddenContent"]');
        const content = editorContainer.querySelector(".ql-editor").innerHTML.trim();

        textarea.value = content;

        if (content === "" || content === "<p><br></p>") {
            alert("Content cannot be empty.");
            return false;
        }
        if (editorContainer2) {
            const textarea2 = form.querySelector('textarea[class="hiddenContent2"]');
            const content2 = editorContainer2.querySelector(".ql-editor").innerHTML.trim();

            textarea2.value = content2;

            if (content2 === "" || content2 === "<p><br></p>") {
                alert("Content cannot be empty.");
                return false;
            }
        }
        form.submit();
    });
}