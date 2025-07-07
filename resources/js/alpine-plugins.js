/**
 * Alpine.js Plugins Configuration
 * 
 * This file registers all required Alpine.js plugins for Filament and frontend use.
 * To avoid double-registration, we check if Alpine is already available globally.
 */

import AlpineCore from 'alpinejs';
import persist from '@alpinejs/persist';
import focus from '@alpinejs/focus';
import collapse from '@alpinejs/collapse';
import intersect from '@alpinejs/intersect';

// Only register Alpine and plugins ONCE globally
if (!window.Alpine) {
    AlpineCore.plugin(persist);
    AlpineCore.plugin(focus);
    AlpineCore.plugin(collapse);
    AlpineCore.plugin(intersect);
    window.Alpine = AlpineCore;
}

const Alpine = window.Alpine;
export default Alpine;
