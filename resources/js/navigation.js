import { showNotification } from './utils';

document.addEventListener('DOMContentLoaded', function () {
    setupProfileMenu('profileButton', 'profileMenu');
    setupProfileMenu('mobileProfileButton', 'mobileProfileMenu');
    setupMobileMenu();
});

function setupProfileMenu(buttonId, menuId) {
    const button = document.getElementById(buttonId);
    const menu = document.getElementById(menuId);

    if (button && menu) {
        button.addEventListener('click', (event) => {
            event.stopPropagation();
            menu.classList.toggle('hidden');
        });

        document.addEventListener('click', (event) => {
            if (!button.contains(event.target) && !menu.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
    }
}

function setupMobileMenu() {
    const menuButton = document.getElementById('menuButton');
    const mobileMenu = document.getElementById('mobileMenu');

    if (menuButton && mobileMenu) {
        menuButton.addEventListener('click', function () {
            mobileMenu.classList.toggle('hidden');
        });
    }
}