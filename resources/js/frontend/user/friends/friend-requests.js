import { ENDPOINTS } from '../../../_EndPoints.js';
import { fetchButton, fetchButton_WithDeleteParent } from '../../_utils/_fetchButton.js';
import { fetchList } from '../../_utils/_fetchList.js';
import { debounce, setupLoadScroll } from '../../_utils/_setupLoadScroll.js';

export function initFriendRequests() {
    const friendRequestsListContainer = document.getElementById('friend-requests-list');

   
    if (!friendRequestsListContainer) {return; }
    //variables
    const Scroll_Debounce = 300;
    
    // scroll variables
    const state = {
        currentPage: 1,
        isLoading: false,
        hasMore: true,
    };

    setupLoadScroll(
        () => {
            state.currentPage ++;
            fetchList(ENDPOINTS.FRIEND_REQUESTS_LIST, friendRequestsListContainer, 'append', state);
        },
        () => ({ isLoading : state.isLoading, hasMore : state.hasMore }),
        Scroll_Debounce,
    );

    // accept friendship
    friendRequestsListContainer.addEventListener('click', (event) => {
        const target = event.target;
        if (target.classList.contains('accept-request-button')) {
            const userId = target.getAttribute('data-user-id');
            const targerParent = target.closest('[data-card]');
            fetchButton_WithDeleteParent(ENDPOINTS.ACCEPT_FRIEND_REQUEST(userId), 'POST', targerParent);
        }
    });
    // decline friendship
    friendRequestsListContainer.addEventListener('click', (event) => {
        const target = event.target;
        if (target.classList.contains('delete-request-button')) {
            const userId = target.getAttribute('data-user-id');
            const targerParent = target.closest('[data-card]');
            fetchButton_WithDeleteParent(ENDPOINTS.DELETE_FRIEND_REQUEST(userId), 'DELETE', targerParent);
        }
    });
}
