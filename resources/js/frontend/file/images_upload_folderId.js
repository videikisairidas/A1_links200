import { ENDPOINTS } from '../../_EndPoints.js';
import { showAlert } from '../../_alert.js';
import { fetchAPI } from '../_utils/_fetchAPI.js';
import { initImageSelect } from './_initImageSelect.js';
// import { fetchImageUpload } from '../_utils/_fetchUpload.js';

export function initImageFolderUpload() {
    
    const ImageUploadByFolder = document.getElementById('ImageUploadByFolder');
    const uploadContainer = document.getElementById('uploadContainer');
    if (!ImageUploadByFolder) { return; }
    const folderId = ImageUploadByFolder.getAttribute('data-target');
    // console.log("headerUploadIcon");
   
    ImageUploadByFolder.addEventListener('click', async () => {
        const newURL = `${ENDPOINTS.FILE_IMAGE_VIEW}?template=image&folderId=${folderId}`;
        console.log(newURL);
        const data = await fetchAPI(newURL, 'GET');
        // console.log(data.html);
        if (data.status === 'success') {
            uploadContainer.innerHTML = data.html;
            initImageSelect();
            uploadContainer.classList.add('show');
        }
        
    });
}