import { delay } from '../_methods/delay.js';
function waitForImageLoad(element) {
    return new Promise((resolve) => {
        const img = element.tagName === 'IMG' ? element : element.querySelector('img');
        if (!img) return resolve();

        if (img.complete) {
            resolve();
        } else {
            img.onload = () => resolve();
            img.onerror = () => resolve(); // Resolve even on error to prevent hanging
        }
    });
}

function getShortestVisibleColumn(activeColumns) {
    let shortest = activeColumns[0];
    let minHeight = shortest.offsetHeight;
    
    for (let i = 1; i < activeColumns.length; i++) {
        const height = activeColumns[i].offsetHeight;
        if (height < minHeight) {
            shortest = activeColumns[i];
            minHeight = height;
        }
    }
    return shortest;
}

export async function placesImagesToColumns(objectContainer, imagesList) {
    // active columns
    console.log('imagesList', imagesList);
    const activeCols = Array.from(objectContainer.children).filter(col => 
        window.getComputedStyle(col).display !== 'none'
    );
    
    await Promise.all(imagesList.map(image => waitForImageLoad(image)));
    await delay(100);
    let i = 0;
    // let sec = 0;
    for (const image of imagesList) {
        // 1. Get the shortest column *right now*
        const shortestColumn = getShortestVisibleColumn(activeCols);

        // 2. Prepare the item
        const item = image.cloneNode(true);
        // item.classList.remove('image-fade-in', 'animated');
        item.style.visibility = 'hidden'; 

        // 3. Place it
        shortestColumn.appendChild(item);

        /**
         * 4. THE FIX: Force Reflow & Wait
         * We trigger offsetHeight to force a style calculation,
         * then we wait for a frame/delay to ensure the column's 
         * height actually updates in the DOM.
         */
        void item.offsetHeight; 
        
        // Let the browser "breath" and update heights
        await delay(100); // 50-100ms is usually enough to prevent column stacking bugs

        // 5. Trigger Animation
        item.style.visibility = 'visible';
        // item.style.animationDelay = `${i * 1}s`;
        item.classList.add('image-fade-in', 'animated');

        i++;
    }
}