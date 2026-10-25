import { ENDPOINTS } from '../../../_EndPoints.js';
import { showAlert } from '../../../_alert.js';
import { fetchAPI } from '../../_utils/_fetchAPI.js';
import { fetchButton_WithDeleteParent } from '../../_utils/_fetchButton.js';
import { fetchList } from '../../_utils/_fetchList.js';
import { debounce, setupLoadScroll } from '../../_utils/_setupLoadScroll.js';

export function initFriendMyRequests() {
    const searchNewFriendInput = document.getElementById('search-new-friend-input');
    const searchNewFriendList = document.getElementById('search-new-friend-list');
    const myRequestListContainer = document.getElementById('friend-my-requests-list');
   
    if (!myRequestListContainer) {return; }
    //variables
    let queryLength = 4;
    const SearchDelay = 500;
    const Scroll_Debounce = 300;
    
    // scroll variables
    const state = {
        currentPage: 1,
        isLoading: false,
        hasMore: true,
    };

    // search new friend
    searchNewFriendInput.addEventListener('keyup', debounce(() => {
        const newQuery = searchNewFriendInput.value.trim();
        if (newQuery.length >= queryLength) {
            state.currentQuery = newQuery;
            fetchList(ENDPOINTS.NEW_FRIENDS_SEARCH, searchNewFriendList, 'replace', state);
        }
    }, SearchDelay));

    // add friend
    searchNewFriendList.addEventListener('click', async (event) => {
        const target = event.target;
        if (target.classList.contains('add-friend-button')) {
            const userId = target.getAttribute('data-user-id');
            const targerParent = target.closest('[data-card]');
            try {
                const needCSRF = true;
                const response = await fetchAPI(ENDPOINTS.SEND_FRIEND_REQUEST(userId), 'POST', null, needCSRF);

                if (response.status === 'success') {
                    showAlert(response.message, 'success');
                    //remove add-friend-button
                    targerParent.querySelector('.add-friend-button').remove();
                    myRequestListContainer.prepend(targerParent);
                } else {
                    showAlert(response.message, 'error');
                }
                return response;
            } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
            }
        }
    });

    // scroll load more
    setupLoadScroll(
        () => {
            state.currentPage ++;
            fetchList(ENDPOINTS.FRIEND_MY_REQUESTS_LIST, myRequestListContainer, 'append', state);
        },
        () => ({ isLoading : state.isLoading, hasMore : state.hasMore }),
        Scroll_Debounce,
    );

    // delete my friends requests( my send request)
    myRequestListContainer.addEventListener('click', async (event) => {
        const target = event.target;
        if (target.classList.contains('delete-request-button')) {
            const userId = target.getAttribute('data-user-id');
            const targerParent = target.closest('[data-card]');
            fetchButton_WithDeleteParent(ENDPOINTS.DELETE_FRIEND_REQUEST(userId), 'DELETE', targerParent);
        }
    });

}