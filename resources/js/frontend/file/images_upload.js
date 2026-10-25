import { ENDPOINTS } from '../../_EndPoints.js';
import { showAlert } from '../../_alert.js';
import { fetchAPI } from '../_utils/_fetchAPI.js';
import { initImageSelect } from './_initImageSelect.js';
// import { fetchImageUpload } from '../_utils/_fetchUpload.js';

export function initImageUpload() {
    
    const headerUploadIcon = document.getElementById('headerUploadIcon');
    const uploadContainer = document.getElementById('uploadContainer');
    if (!headerUploadIcon) { return; }

    // console.log("headerUploadIcon");

    headerUploadIcon.addEventListener('click', async () => {
        const newURL = `${ENDPOINTS.FILE_IMAGE_VIEW}?template=image`;
        const data = await fetchAPI(newURL, 'GET');
        // console.log(data.html);
        if (data.status === 'success') {
            uploadContainer.innerHTML = data.html;
            initImageSelect();
            uploadContainer.classList.add('show');
        }
        
    });
}