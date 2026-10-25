import { ENDPOINTS } from '../../_EndPoints.js';
import { showAlert } from '../../_alert.js';
import { fetchBioUpload } from '../_utils/_fetchUpload.js';
import { initImageSelect } from './_initImageSelect.js';
import { fetchAPI } from '../_utils/_fetchAPI.js';

export function initBioUpload() {
    
    const bioUploadButton = document.getElementById('showAvatarUpload');
    const bannerUploadButton = document.getElementById('showBannerUpload');
    const uploadContainer = document.getElementById('uploadContainer');

    if (!bannerUploadButton || !bioUploadButton ) { return; }

    bioUploadButton.addEventListener('click', async () => {
       
        const newUrl = `${ENDPOINTS.FILE_IMAGE_VIEW}?template=avatar`;
        const data = await fetchAPI(newUrl, 'GET');

        if (data.status === 'success') {
            uploadContainer.innerHTML = data.html;
            initImageSelect();
            uploadContainer.classList.add('show');
        }
    });
    bannerUploadButton.addEventListener('click', async () => {
        
        const newUrl = `${ENDPOINTS.FILE_IMAGE_VIEW}?template=banner`;
        const data = await fetchAPI(newUrl, 'GET');

        if (data.status === 'success') {
            uploadContainer.innerHTML = data.html;
            initImageSelect();
            uploadContainer.classList.add('show');
        }
        
    });
    
    // bioBox
    // initImageSelect();
    
}
 