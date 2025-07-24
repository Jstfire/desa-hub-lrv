/**
 * Filament Admin-specific Alpine.js initialization
 * This file handles Alpine.js initialization for Filament admin panel
 * ensuring it works with Livewire.
 */

import Alpine from './alpine-plugins';
import './alpine'; // Make sure stores are registered before start

const startAlpine = () => {
    // Check if Alpine is already initialized or running
    if (window.alpineInitialized || (window.Alpine && window.Alpine.version)) {
        return;
    }
    window.alpineInitialized = true;
    Alpine.start();
};

document.addEventListener('DOMContentLoaded', () => {
    // Only proceed if Alpine hasn't been started yet
    if (window.Alpine && window.Alpine.version) {
        return; // Alpine is already running
    }
    
    if (window.Livewire) {
        window.addEventListener('livewire:initialized', startAlpine);
    } else {
        startAlpine();
    }
});

// Fallback to ensure Alpine starts even if livewire:initialized doesn't fire
// But only if Alpine hasn't been started yet
setTimeout(() => {
    if (!window.Alpine || !window.Alpine.version) {
        startAlpine();
    }
}, 50);
