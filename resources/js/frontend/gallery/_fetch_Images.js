import { fetchAPI } from '../_utils/_fetchAPI.js';

export async function fetchImages(endpoint, method = "GET", state) {
    try {
        let params = [];
        //submission
        if (state.competitionId) {
            params.push(`competitionId=${state.competitionId}`);
        }
        //folder
        if (state.folderId) {
            params.push(`folderId=${state.folderId}`);
        }
        if (state.currentPage) {
            params.push(`page=${state.currentPage}`);
        }

        const FinalEndpoint = `${endpoint}?${params.join('&')}`;
        console.log(FinalEndpoint);
        const data = await fetchAPI(FinalEndpoint, method);
        
        return data;
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
    }
}