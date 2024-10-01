import { showNotification } from './utils';

document.addEventListener('DOMContentLoaded', function () {
    setupProfileMenu('profileButton', 'profileMenu');
    setupProfileMenu('mobileProfileButton', 'mobileProfileMenu');
    setupMobileMenu();
    setupSearch();
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

function setupSearch() {
    const searchInput = document.getElementById('searchInput');
    const searchIcon = document.getElementById('searchIcon');
    const searchButton = document.getElementById('searchButton');

    searchInput.addEventListener('focus', () => searchInput.classList.add('w-64'));
    searchInput.addEventListener('blur', () => searchInput.classList.remove('w-64'));

    searchIcon.addEventListener('click', () => {
        searchInput.classList.toggle('w-0');
        searchInput.classList.toggle('w-48');
        searchButton.classList.toggle('hidden');
        searchInput.focus();
    });
}