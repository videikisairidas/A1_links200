const WEBAPI_BASE = '/admin';

export const ENDPOINTS = {

    // user search  
    // USER_SEARCH: '/user-search',
    EDIT_CATEGORY: (categoryId) => `${WEBAPI_BASE}/categories/${categoryId}/update`,
    
};

export default ENDPOINTS;