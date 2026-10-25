import { ENDPOINTS } from '../../../_EndPoints.js';
import { alertYesNo } from '../../../_alertYesNo.js';
// import { fetchList } from '../_utils/_fetchList.js';
import { fetchImages } from '../../gallery/_fetch_Images.js';
import { debounce, setupLoadScroll } from '../../_utils/_setupLoadScroll.js';
import { imagesList, initImagesList } from "../../gallery/__variable.js";
import { placesImagesToColumns } from "../../gallery/__methods.js";
import { delay } from '../../_methods/delay.js';

export function initFolderDetailsImages() {
    const folderImagesGallery = document.querySelector('#GalleryContainer[data-type="folderImages"]');
    const imagesLoadedContainer = document.getElementById('loadedImagesContainer');

    if (!folderImagesGallery) { return; }

    // varables 
    if (!imagesLoadedContainer) { return; }
    const imagesListOnLoad = Array.from(imagesLoadedContainer.children);
    initImagesList(imagesListOnLoad);
    
    const Scroll_Debounce_Delay = 100;
    const targetFolderId = folderImagesGallery.getAttribute('data-target');
    let data;

    const state = {
        currentPage: 1,
        isLoading: false,
        hasMore: true,
        folderId: targetFolderId
    };

    window.addEventListener('load', () => {
        placesImagesToColumns(folderImagesGallery, imagesList)
    });

    setupLoadScroll(
        async () => {
            //delay 
            await delay(800);

            state.isLoading = true;
            if (!state.isLoading || !state.hasMore) return; 
        
            state.currentPage ++;

            data =  await fetchImages(ENDPOINTS.FOLDER_IMAGES_LIST, "GET", state);
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
                await placesImagesToColumns(folderImagesGallery, imagesLoadedArray);
                
            } else {
                state.hasMore = false;
            }
            // console.log(imagesList);
            state.isLoading = false;
        },
        () => ({ isLoading : state.isLoading, hasMore : state.hasMore }),
        Scroll_Debounce_Delay,
    );
    
}