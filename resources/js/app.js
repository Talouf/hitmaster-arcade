import './bootstrap';
import Alpine from 'alpinejs';
import './navigation';
import './cart';
import './product-lazy-load'

window.Alpine = Alpine;
Alpine.start();

window.addEventListener('pageshow', function(event) {
    if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
        window.location.reload(); // Force la page à se recharger si elle provient du cache
    }
});