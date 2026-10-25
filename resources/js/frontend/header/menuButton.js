
export function initMenuButton() {
    const footer = document.getElementById('headerMobile');
    const button = document.getElementById('mobileMenuIcon');
    const closeButton = document.getElementById('mobileMenuClose');

    button.addEventListener('click', () => {
        footer.classList.add('active');
    });

    closeButton.addEventListener('click', () => {
        footer.classList.remove('active');
    });
}