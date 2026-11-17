import './bootstrap';
import './toast';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

if (document.querySelector('[data-cashier-notifications]')) {
    import('./cashier-order-notifications.js');
}
