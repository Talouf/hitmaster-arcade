import { showNotification } from './utils';

document.addEventListener('DOMContentLoaded', function () {
    setupProfileMenu('profileButton', 'profileMenu');
    setupProfileMenu('mobileProfileButton', 'mobileProfileMenu');
    setupMobileMenu();
});

function setupProfileMenu(buttonId, menuId) {
    const button = document.getElementById(buttonId);
    const menu = document.getElementById(menuId);

    button.addEventListener('click', () => menu.classList.toggle('hidden'));

    document.addEventListener('click', (event) => {
        if (!button.contains(event.target) && !menu.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });
}

function setupMobileMenu() {
    document.getElementById('menuButton').addEventListener('click', function () {
        document.getElementById('mobileMenu').classList.toggle('hidden');
    });
}