import { ENDPOINTS } from '../../../_EndPoints.js';
import { fetchButton, fetchButton_WithDeleteParent } from '../../_utils/_fetchButton.js';
import { alertYesNo } from '../../../_alertYesNo.js';
import { fetchList } from '../../_utils/_fetchList.js';
import { debounce, setupLoadScroll } from '../../_utils/_setupLoadScroll.js';


export function initFriends() {
    const friendsSearchInput = document.getElementById('friendsSearchInput');
    const friendsListContainer = document.getElementById('friends-list');
   
    if (!friendsSearchInput && !friendsListContainer) { return; }
    
    // variables
    let queryLength = 4;
    const SearchDelay = 500;
    const Scroll_Debounce = 300;

    const state = {
        currentPage: 1,
        isLoading: false,
        hasMore: true,
        currentQuery: '',
    };

    // seach friends by name/username/email
    friendsSearchInput.addEventListener('keyup', debounce(() => {
        const newQuery = friendsSearchInput.value.trim();
        if (newQuery !== state.currentQuery && newQuery.length >= queryLength) {
            console.log(newQuery);
            state.currentQuery = newQuery;
            state.currentPage = 1; 
            state.hasMore = true; 
            fetchList(ENDPOINTS.FRIENDS_LIST, friendsListContainer, 'replace', state);
        }
    }, SearchDelay));
    
    //scroll load more
    setupLoadScroll(
        () => {
            state.currentPage++;
            fetchList(ENDPOINTS.FRIENDS_LIST, friendsListContainer, 'append', state)
        },
        () => ({ isLoading : state.isLoading, hasMore : state.hasMore }),
        Scroll_Debounce,
    );

    // delete friend
    friendsListContainer.addEventListener('click', (event) => {
        const target = event.target;
        if (target.classList.contains('delete-friend-button')) {
            const friendId = target.getAttribute('data-friend-id');
            const targerParent = target.closest('[data-card]');
            alertYesNo('Are you sure you want to delete this friend?', 'Confirm Deletion')
            .then(confirmed => {
                if (confirmed) {
                    // deleteFriend(friendId, target);
                    fetchButton_WithDeleteParent(ENDPOINTS.DELETE_FRIEND(friendId), 'DELETE', targerParent);
                }
            });
        }
    });
  
}



    