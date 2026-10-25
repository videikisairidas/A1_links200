import { ENDPOINTS } from '../../_EndPoints.js';
import { fetchList } from '../_utils/_fetchList.js';

export function initUserSearch() {
    const searchInput = document.getElementById('userSearchInput');
    const resultsBox = document.getElementById('userSearchResults');
    
    if (!searchInput || !resultsBox) { return; }
    // console.log(searchInput, resultsBox);
    // 
    const queryLength = 4;
    const SearchDelay = 500;
    const state = {
        currentQuery: '',
    }

    searchInput.addEventListener( 'keyup', function () {
        const query = searchInput.value.trim();
        if (query.length >= queryLength) {
            state.currentQuery = query;
            fetchList(ENDPOINTS.USER_SEARCH, resultsBox, 'replace', state);
        }
    }, SearchDelay);

    // userSearchIcon click to toggle search box/component
    const userSearchIcon = document.getElementById('userSearchIcon');
    const userSearchComponent = document.getElementById('userSearchComponent');
    
    if (userSearchIcon && userSearchComponent) {
        userSearchIcon.addEventListener('click', function () {
            userSearchComponent.classList.toggle('active');
            searchInput.focus();
        });
    }
    // close with close button
    document.getElementById('userSearchClose').addEventListener('click', function () {
        userSearchComponent.classList.remove('active');
        resultsBox.innerHTML = '';
        searchInput.value = '';
    });
}