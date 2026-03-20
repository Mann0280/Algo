import './bootstrap';
import './firebase';
import './toast';
import { initNotifications } from './notifications';
import { testFirebase } from './firebase';

document.addEventListener('DOMContentLoaded', () => {
    // Only init notifications if the CSRF token is present (implies a page that needs it or authenticated)
    // Actually, better check if Auth user is present via a global variable if we had one.
    // For now, init always, the server-side call handles authentication.
    initNotifications();

    // Verification Test: Only runs if ?test_firebase is in the URL
    if (new URLSearchParams(window.location.search).has('test_firebase')) {
        testFirebase();
    }
});
