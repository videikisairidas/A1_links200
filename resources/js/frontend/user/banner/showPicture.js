export function initShowAvatar() {
    const avatar = document.getElementById('uploadAvatar');
    if (!avatar) { return; }

    const avatarViewButton = document.getElementsByClassName('avatarView')[0];
    const avatarViewBig = document.getElementsByClassName('avatarViewBig')[0];
    avatarViewButton.addEventListener('click', () => {
        avatarViewBig.classList.add('show')
    });
    avatarViewBig.addEventListener('click', () => {
        avatarViewBig.classList.remove('show')
    });
}