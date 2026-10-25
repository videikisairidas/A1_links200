import { showAlert } from "../../_alert";
export function initImageSelect() {
    const imageUploadContainer = document.getElementById('ImageUploadContainer');
    console.log("initImageSelect 111");
    if (!imageUploadContainer) { return; }
    let selectedFile = null;
    console.log("initImageSelect");
    const previewImage = imageUploadContainer.querySelector('#preview');
    const fileInput = imageUploadContainer.querySelector('#fileInput');
    const imageBox = imageUploadContainer.querySelector('#ImageUploadBox');
    const closeButton = imageUploadContainer.querySelector('#bioUploadClose');

    function resetUploadState() {
        selectedFile = null;
        previewImage.src = '/assets/images/default-upload.png';
        fileInput.value = '';
        // bioBox
    }
    function showImage(file) {
        if (!file || !file.type.startsWith('image/')) {
            resetUploadState();
            return;
        }
        const reader = new FileReader();
        reader.onload = function (e) {
            previewImage.src = e.target.result;
        };
        reader.readAsDataURL(file);
        selectedFile = file;
    }

    // click select
    imageBox.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', (e) => {
        if (!e.target.files || e.target.files.length === 0) {
            return;
        }
        selectedFile = e.target.files[0];
        showImage(selectedFile);
    });
    //drag annd drop image
    imageBox.addEventListener('dragover', (e) => {
        e.preventDefault();
        imageBox.classList.add('dragover');
    });
    imageBox.addEventListener('dragleave', () => {
        imageBox.classList.remove('dragover');
    });
    imageBox.addEventListener('drop', (e) => {
        e.preventDefault();
        imageBox.classList.remove('dragover');
        selectedFile = e.dataTransfer.files[0];
        showImage(selectedFile);
    });

    // prevent submit
    document.getElementById('ImageUploadForm').addEventListener('submit', (e) => {
        const action = e.target.getAttribute('action');

        if (action === '#' || action === '' || action === null || !selectedFile ) {
            e.preventDefault();
            showAlert('Upload doesnt work right now try again, reload page', 'danger');
            return false;
        }
    });
    //close 
    closeButton.addEventListener('click', () => {
        // console.log('close');
        let elemParent = imageUploadContainer.closest('#uploadContainer');
        elemParent.classList.remove('show');
        elemParent.innerHTML = '';
    });
    
}