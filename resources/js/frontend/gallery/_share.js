import { showAlert } from "../../_alert";


export function initShare() {
    const initGalleryContainer = document.querySelector('#GalleryContainer');
    const galleryContainer = document.querySelector('#GalleryContainer[data-type="gallery"]');
    const LikedImagesGallery = document.querySelector('#GalleryContainer[data-type="LikedPage"]');
    const folderImagesGallery = document.querySelector('#GalleryContainer[data-type="folderImages"]');
    const shareButton = document.getElementById('shareBtn');
    // submissions share
    const submissionsGallery = document.querySelector('#GalleryContainer[data-type="submissionImages"]');

    if (galleryContainer || LikedImagesGallery || folderImagesGallery || submissionsGallery) {
        initGalleryContainer.addEventListener('click', async (event) => {
            const shareButton = event.target.closest('.shareButton');
            if (!shareButton) { return; }

            const url = shareButton.getAttribute('data-url');
            console.log(url);

            if (navigator.share) {
                await navigator.share({
                    url: url
                });
            } else {
                // alert('Sharing not supported on this browser');
                navigator.clipboard.writeText(url).then(() => {
                    showAlert('Copied a link', 'success');
                    // console.log("Copied:", url);
                });
            }
        });
    }
    // image PAGe SHARE button
    if (shareButton) {
        shareButton.addEventListener('click', async (e) => {
            const url = e.target.getAttribute('data-url');
            if (navigator.share) {
                await navigator.share({
                    url: url
                });
            } else {
                // alert('Sharing not supported on this browser');
                navigator.clipboard.writeText(url).then(() => {
                    showAlert('Copied a link', 'success');
                });
            }
        });
    }
    //submission share
    // if (submissionsGallery) {
    //     initGalleryContainer.addEventListener('click', async (event) => {
    //         const shareButton = event.target.closest('.shareButton');
    //         if (!shareButton) { return; }
    //         const url = shareButton.getAttribute('data-url');
    //         console.log(url);

    //         if (navigator.share) {
    //             await navigator.share({
    //                 url: url
    //             });
    //         } else {
    //             alert('Sharing not supported on this browser');
    //         }
    //     });
    // }

}
