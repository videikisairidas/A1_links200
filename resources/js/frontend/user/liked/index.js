import { ENDPOINTS } from '../../../_EndPoints.js';
import { delay } from '../../_methods/delay.js';
import { setupLoadScroll } from '../../_utils/_setupLoadScroll.js';
import { fetchImages } from '../../gallery/_fetch_Images.js';
import { imagesList, initImagesList } from '../../gallery/__variable.js';
import { placesImagesToColumns } from '../../gallery/__methods.js';

export function initLikedPage() {
    const likedImages = document.querySelector('#GalleryContainer[data-type="LikedPage"]')

    if (!likedImages) { return; }
    
    console.log("liked categories");
    // variable
    const imagesLoadedContainer = document.getElementById('loadedImagesContainer');
    if (!imagesLoadedContainer) { return; }
    const imagesListOnLoad = Array.from(imagesLoadedContainer.children);
    initImagesList(imagesListOnLoad);
    // variable
    const Scroll_Debounce_Delay = 100;
    let targetUserId = likedImages.getAttribute('data-user');

    const state = {
        currentPage: 1,
        isLoading: false,
        hasMore: true,
    };

    window.addEventListener('load', () => {
        placesImagesToColumns(likedImages, imagesList)
    });

    setupLoadScroll(
        async () => {
            //delay 
            // await delay(800);

            state.isLoading = true;
            // if (!state.isLoading || !state.hasMore) return; 
            state.currentPage ++;
            try {
                const url = ENDPOINTS.LIKED_IMAGES_LIST(targetUserId);
                const data = await fetchImages(url, "GET", state);
                // console.log(data);
                if (data.status === 'success') {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(data.html, 'text/html');
                    const renderView = doc.body.querySelector('#loadedImagesContainer');
                    //avoid if not found
                    if (renderView && renderView.children.length > 0) {
                        const imagesLoadedArray = Array.from(renderView.children); 
                        initImagesList(imagesLoadedArray);
                        await placesImagesToColumns(likedImages, imagesLoadedArray);
                    } else {
                        state.hasMore = false;
                        return;
                    }
                    
                } else {
                    state.hasMore = false;
                }
                console.log(imagesList);
                state.isLoading = false;
            } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
                state.isLoading = false;
            } finally {
                state.isLoading = false;
            }
        },
        () => ({ isLoading : state.isLoading, hasMore : state.hasMore }),
        Scroll_Debounce_Delay,
    );
}