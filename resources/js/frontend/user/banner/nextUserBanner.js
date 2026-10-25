import { ENDPOINTS } from '../../../_EndPoints.js';
import { fetchAPI } from '../../_utils/_fetchAPI.js';
import { showAlert } from '../../../_alert.js';
// import { fetchButton, fetchButton_WithDeleteParent } from '../../_utils/_fetchButton.js';
// import { fetchList } from '../../_utils/_fetchList.js';

// next user banner js
export function initNextUserBanner() {
    const bannerListContainer = document.getElementById('ProfileBannerLines');
    const nextUserProfileAction = document.getElementsByClassName('profileCurrentActions')[0];
    if (!bannerListContainer ) { return; }

    // on other user porfile
    const IsNextUser = nextUserProfileAction.getElementsByTagName('*').length > 0;
    if ( !IsNextUser ) { return; }

    const needCSRF = true;
    //friends status/add/delete/waiting/sent
    const friendsBannerActions = document.getElementById('profileFriendshipActions');

    const addFriendButton = friendsBannerActions.querySelector('.add-friend');
    const deleteFriendButton = friendsBannerActions.querySelector('.unFriend');

    //add friend
    addFriendButton.addEventListener('click', async (event) => {
        let userId = event.target.getAttribute('data-target-user-id');
        console.log(userId);
        const response = await fetchAPI(ENDPOINTS.SEND_FRIEND_REQUEST(userId), 'POST', null, needCSRF);
        if (response.status === 'success') {
            showAlert(response.message, 'success');
            friendsBannerActions.setAttribute('data-friendship', 'pending');
        }
    });
    //delete friend
    deleteFriendButton.addEventListener('click', async (event) => {
        let userId = event.target.getAttribute('data-target-user-id');
        console.log(userId);
        const response = await fetchAPI(ENDPOINTS.DELETE_FRIEND(userId), 'DELETE', null, needCSRF);
        if (response.status === 'success') {
            showAlert(response.message, 'success');
            friendsBannerActions.setAttribute('data-friendship', 'none');
        }
    });

    // //unfollow/follow
    // const followBannerActions = document.getElementById('bannerFollowerActions');

    // let targetUserId = bannerFollowerActions.getAttribute('data-target-user-id');

    // const followButton = followBannerActions.querySelector('.Follow');
    // const unfollowButton = followBannerActions.querySelector('.UnFollow');
    
    // followButton.addEventListener('click', async () => {
    //     const response = await fetchAPI(ENDPOINTS.FOLLOW(targetUserId), 'POST', null, needCSRF);
    //     if (response.status === 'success') {
    //         showAlert(response.message, 'success');
    //         followBannerActions.setAttribute('data-follower', 'UnFollow');
    //     }
    // });
    // unfollowButton.addEventListener('click', async () => {
    //     const response = await fetchAPI(ENDPOINTS.UNFOLLOW(targetUserId), 'DELETE', null, needCSRF);
    //     if (response.status === 'success') {
    //         showAlert(response.message, 'success');
    //         followBannerActions.setAttribute('data-follower', 'Follow');
    //     }
    // });
    
}