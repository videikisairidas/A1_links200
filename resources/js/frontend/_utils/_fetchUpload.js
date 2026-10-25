import { showAlert } from "../../_alert";
import { ENDPOINTS } from "../../_EndPoints";
import { fetchAPI } from "./_fetchAPI";
// export async function fetchUploadView(endpoint, method = "GET", body = null) {
//     const data = await fetchAPI(endpoint, method, body);

// }
export async function fetchBioUpload(endpoint, body = null, method = "POST", ) {
    const headers = {
        // 'Content-Type': 'multipart/form-data',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    };
    console.log(endpoint);
    try {
        const fetchOptions = {
            method,
            headers,
            body,
        };

        const response = await fetch(endpoint, fetchOptions);

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        return await response.json();

    } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
    }
    
}
// export async function fetchList(endpoint, container, mode = 'append', state) {
//     if (state.isLoading) return;
//     state.isLoading = true;

//     try {
//         //heeerreeeeeeeeeeee
//         const FinalEndpoint = `${endpoint}?search=${encodeURIComponent(state.currentQuery)}&page=${state.currentPage}`;
//         const data = await fetchAPI(FinalEndpoint, 'GET');
//         const htmlContent = data.html;
//         console.log(htmlContent);

//         if (container) {
//             if (mode === 'replace') {
//                 container.innerHTML = htmlContent;
//             } else { // mode === 'append'
//                 container.insertAdjacentHTML('beforeend', htmlContent);
//             }
//         }

//         state.hasMore = htmlContent && htmlContent.trim() !== '';

//         if (!state.hasMore) {
//             console.log('No more data to load.');
//         }
//     } catch (error) {
//         console.error('There was a problem with the fetch operation:', error);
//     } finally {
//         state.isLoading = false;
//     }
// }