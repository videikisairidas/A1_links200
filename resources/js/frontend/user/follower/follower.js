import { ENDPOINTS } from '../../../_EndPoints.js';
import { fetchButton, fetchButton_WithDeleteParent } from '../../_utils/_fetchButton.js';
import { alertYesNo } from '../../../_alertYesNo.js';
import { fetchList } from '../../_utils/_fetchList.js';
import { debounce, setupLoadScroll } from '../../_utils/_setupLoadScroll.js';

export function initFollowers() {
    const followListContainer = document.getElementById('follow-list'); 

    if (!followListContainer) {return; }
    //variables
    const Scroll_Debounce = 500;
    const targetUserId = parseInt(followListContainer.getAttribute('data-user-id'));
    
    // scroll variables
    const state = {
        currentPage: 1,
        isLoading: false,
        hasMore: true,
    };
    
    setupLoadScroll(
        () => {
            state.currentPage ++;
            if (followListContainer.getAttribute('data-page') === 'followers') {
                fetchList(ENDPOINTS.FOLLOWERS_LIST(targetUserId), followListContainer, 'append', state);
            }

            if (followListContainer.getAttribute('data-page') === 'following') {
                fetchList(ENDPOINTS.FOLLOWING_LIST(targetUserId), followListContainer, 'append', state);
            }
        },
        () => ({ isLoading : state.isLoading, hasMore : state.hasMore }),
        Scroll_Debounce,
    );
    // delete follow
    followListContainer.addEventListener('click', (event) => {
        const buttonDeleteFollow = event.target.closest('.delete-follow-button');
        
        if (!buttonDeleteFollow) {return; }

        const userId = buttonDeleteFollow.getAttribute('data-user-id');
        const targerParent = buttonDeleteFollow.closest('[data-card]');
        fetchButton_WithDeleteParent(ENDPOINTS.DELETE_FOLLOWER(userId), 'DELETE', targerParent);
    });

}