import { placesImagesToColumns } from "./__methods.js";
import { imagesList } from "./__variable.js";

export function initResize() {
    
    const ImagesGallery = document.querySelector('#GalleryContainer')

    if (!ImagesGallery) { return; }
    const allColumns = Array.from(ImagesGallery.children);
    
    //obs container
    const OBS_container = document.querySelector('body');

    const updateWidth = () => {
        allColumns.forEach(col => {
            col.innerHTML = '';
        });
        placesImagesToColumns(ImagesGallery, imagesList);
    };
    // Define your breakpoints in ascending order
    const BREAKPOINTS = [600, 800, 1000, 1200];

    let lastZone = null;
    let firstRun = true;
    const ro = new ResizeObserver(entries => {
        if (firstRun) { 
            firstRun = false; return; // ignore initial fire 
        }
        const width = window.innerWidth;
        // Determine which zone the width belongs to
        let zone = BREAKPOINTS.find(bp => width <= bp);
        if (!zone) zone = "above"; // wider than all breakpoints

        console.log(width);
        // Only fire when the zone changes
        if (zone !== lastZone) {
            lastZone = zone;
            updateWidth(); // your callback
        }
    });

    ro.observe(OBS_container);

}