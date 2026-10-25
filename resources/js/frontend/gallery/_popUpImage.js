import { ENDPOINTS } from '../../_EndPoints';
import { fetchAPI } from '../_utils/_fetchAPI';

export function initPopUpImage() {
    const imagePopUpContainer = document.querySelector('#imagePopUpContainer');
    const closeButton = imagePopUpContainer.querySelector('.close');

    document.addEventListener('click', function(e) {
        const popImageButton = e.target.closest('.popImageButton');

        if (!popImageButton) { return; }

        console.log('pop image button clicked');
        const imageId = popImageButton.getAttribute('data-image-id');
        console.log('imageId:', imageId);

        fetchAPI(ENDPOINTS.IMAGE_PAGE_DETAILS(imageId), 'GET', null, true)
        .then(data => {
            if (data.status === 'success') {
                console.log('Received HTML:', data.html);
                imagePopUpContainer.classList.add('show');
                imagePopUpContainer.insertAdjacentHTML('beforeend', data.html);
            }
        });
    });
    closeButton.addEventListener('click', function() {
        imagePopUpContainer.classList.remove('show');
        imagePopUpContainer.querySelector(' div').remove();
    });
}