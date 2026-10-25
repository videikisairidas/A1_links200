export function initLogout() {
    const logoutButton = document.getElementById('logoutButton');
    const logoutButton2 = document.getElementById('m-logoutButton');
    console.log("logoutButton");
    if (logoutButton) {
        logoutButton.addEventListener('click', () => {
            document.getElementById('logout-form').submit();
        });
    }
    if (logoutButton2) {
        logoutButton.addEventListener('click', () => {
            document.getElementById('m-logout-form').submit();
        });
    }
}
