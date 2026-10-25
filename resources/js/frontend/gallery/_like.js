
import { fetchAPI } from "../_utils/_fetchAPI";
import { showAlert } from "../../_alert";
import { ENDPOINTS } from "../../_EndPoints";

// data-type like/unlike
export function initLike() {
    const galleryContainer = document.querySelector('#GalleryContainer');
    if (!galleryContainer) { return; }

    console.log(galleryContainer);
    // like
    galleryContainer.addEventListener('click', async (event) => {
        const likeButton = event.target.closest('.likeContainer[data-type="like"]');
        
        if (!likeButton) { return; }

        const imageId = likeButton.getAttribute('data-image-id');
        console.log(ENDPOINTS.IMAGE_ADD_LIKE(imageId)) ;
        const data = await fetchAPI(`${ENDPOINTS.IMAGE_ADD_LIKE(imageId)}`, 'POST', null, true);
        console.log(imageId);
        if (data.status === 'success') {
            showAlert(data.message, 'success');
            likeButton.closest('.likeContainer').classList.add('show');
            likeButton.closest('.likeContainer').dataset.type = 'unlike';
        }
    });
    // unlike
    galleryContainer.addEventListener('click', async (event) => {
        const unlikeButton = event.target.closest('.likeContainer[data-type="unlike"]');
        if (!unlikeButton) { return; }

        const imageId = unlikeButton.getAttribute('data-image-id');
        const data = await fetchAPI(`${ENDPOINTS.IMAGE_REMOVE_LIKE(imageId)}`, 'DELETE', null, true);
        console.log(imageId);
        if (data.status === 'success') {
            showAlert(data.message, 'success');
            unlikeButton.closest('.likeContainer').classList.remove('show');
            unlikeButton.closest('.likeContainer').dataset.type = 'like';
        }
    });
}