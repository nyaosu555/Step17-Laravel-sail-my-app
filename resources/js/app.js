import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const messageBox = document.getElementById('flash-message');

if(messageBox) {
    requestAnimationFrame(() => {
        messageBox.classList.remove('-translate-y-full');
        messageBox.classList.add('translate-y-0');
        messageBox.classList.add('opacity-100');

    });

    setTimeout(() => {
        messageBox.classList.remove('opacity-100', 'translate-y-0');
        messageBox.classList.add('opacity-0', '-translate-y-full');
        setTimeout(() => {
            messageBox.remove();
        }, 500);
    }, 7000);
}
