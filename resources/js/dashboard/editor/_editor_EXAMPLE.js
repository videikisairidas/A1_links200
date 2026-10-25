export function initEditor() {
    const form = document.querySelector(".createForm");
    if (!form) {
        return;
    }

    const editorContainer = document.querySelector("#editor");
    if (!editorContainer) {
        return;
    }

    form.addEventListener("submit", function (e) {
        e.preventDefault();
        const textarea = form.querySelector('textarea[name="content"]');
        console.log("yess click");
        textarea.value = editorContainer
            .querySelector(".ql-editor")
            .innerHTML.trim();

        if (textarea.value === "" || textarea.value === "<p><br></p>") {
            alert("Content cannot be empty.");
            return false;
        }
        form.submit();
    });

    // load editor
    // const quill = new Quill('#editor', {
    //   modules: {
    //     syntax: true,
    //     toolbar: '#toolbar-container',
    //   },
    //   placeholder: 'Compose an epic...',
    //   theme: 'snow',
    // });
    const toolbarOptions = [
      ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
      ['blockquote', 'code-block'],
      ['link', 'image'],

      [{ 'header': 1 }, { 'header': 2 }],               // custom button values
      [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
      [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
      [{ 'direction': 'rtl' }],                         // text direction

      [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
      [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

      [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
      [{ 'font': [] }],
      [{ 'align': [] }],

      ['clean']                                         // remove formatting button
    ];
    const quill = new Quill('#editor', {
      modules: {
        toolbar: {
          container: toolbarOptions,
          handlers: {
            'image': imageHandler
          }
        }

      },
      theme: 'snow'
      
    });

    function imageHandler() {
      const input = document.createElement('input');
      input.setAttribute('type', 'file');
      input.setAttribute('accept', 'image/*');
      input.click();

      input.onchange = async () => {
        const file = input.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('image', file);

        const res = await fetch("{{ route('quill.upload') }}", {
          method: "POST",
          headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
          },
          body: formData
        });

        const data = await res.json();

        const range = quill.getSelection(true);
        quill.insertEmbed(range.index, 'image', data.url);
        quill.setSelection(range.index + 1);
      };
    }

}
