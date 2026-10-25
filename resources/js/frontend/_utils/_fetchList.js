import { fetchAPI } from './_fetchAPI.js';

// const state = {
//     currentPage: 1,
//     isLoading: false,
//     hasMore: true,
//     currentQuery: '',
// };

export async function fetchList(endpoint, container, mode = 'append', state) {
    if (state.isLoading) return;
    state.isLoading = true;
    // console.log(endpoint);
    try {
        //heeerreeeeeeeeeeee
        let params = [];
        if (state.currentQuery) {
            params.push(`search=${encodeURIComponent(state.currentQuery)}`);
        }
        if (state.currentPage) {
            params.push(`page=${state.currentPage}`);
        }
        const FinalEndpoint = `${endpoint}?${params.join('&')}`;
        
        console.log(FinalEndpoint);
        const data = await fetchAPI(FinalEndpoint, 'GET');
        const htmlContent = data.html;
        console.log(htmlContent);

        if (container) {
            if (mode === 'replace') {
                container.innerHTML = htmlContent;
            } else { // mode === 'append'
                container.insertAdjacentHTML('beforeend', htmlContent);
            }
        }

        state.hasMore = htmlContent && htmlContent.trim() !== '';

        if (!state.hasMore) {
            console.log('No more data to load.');
        }
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
    } finally {
        state.isLoading = false;
    }
}