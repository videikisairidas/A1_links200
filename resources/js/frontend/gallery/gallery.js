import { imagesList, initImagesList } from './__variable';
import { delay } from '../_methods/delay';
import { placesImagesToColumns } from './__methods';
import { setupLoadScroll } from '../_utils/_setupLoadScroll';
import { fetchImages } from './_fetch_Images';
import { ENDPOINTS } from '../../_EndPoints';
import { initGalleryFilter } from './_filter';

export function initGallery() {
    const galleryImages = document.querySelector('#GalleryContainer[data-type="gallery"]');

    if (!galleryImages) { return; }
    initGalleryFilter();
    
    // variable
    const imagesLoadedContainer = document.getElementById('loadedImagesContainer');
    if (!imagesLoadedContainer) { return; }
    const imagesListOnLoad = Array.from(imagesLoadedContainer.children);
    initImagesList(imagesListOnLoad);

    const Scroll_Debounce_Delay = 300;
    let data;

    const state = {
        currentPage: 1,
        isLoading: false,
        hasMore: true,
    };
    // console.log("state 1")
    window.addEventListener('load', () => {
        placesImagesToColumns(galleryImages, imagesList)
    });

    setupLoadScroll(
        async () => {
            //delay 
            await delay(800);
            state.isLoading = true;
            if (!state.isLoading || !state.hasMore) return; 
            state.currentPage++;

            data = await fetchImages(`${ENDPOINTS.GALLERY_IMAGES_LIST}`, 'GET', state);
            // console.log(data);
            if (data.status === 'success') {
                const parser = new DOMParser();
                const doc = parser.parseFromString(data.html, 'text/html');
                const renderView = doc.body.querySelector('#loadedImagesContainer');
                //avoid if not found
                if (!renderView) {
                    state.hasMore = false;
                    return;
                }

                const imagesLoadedArray = Array.from(renderView.children); 
                initImagesList(imagesLoadedArray);
                await placesImagesToColumns(galleryImages, imagesLoadedArray);
            } else {
                state.hasMore = false;
            }
            state.isLoading = false;
        },
        () => ({ isLoading : state.isLoading, hasMore : state.hasMore }),
        Scroll_Debounce_Delay,
    );
    
}