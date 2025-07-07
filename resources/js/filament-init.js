/**
 * Filament Admin-specific Alpine.js initialization
 * This file handles Alpine.js initialization for Filament admin panel
 * ensuring it works with Livewire.
 */

import Alpine from './alpine-plugins';
import './alpine'; // Make sure stores are registered before start

document.addEventListener('DOMContentLoaded', () => {
    // Ensure Livewire object exists
    window.Livewire = window.Livewire || undefined;

    if (window.alpineInitialized) {
        console.debug('Alpine.js already initialized, skipping initialization in filament-init.js');
        return;
    }

    // For Filament, wait for Livewire to be ready before starting Alpine
    if (window.Livewire) {
        window.addEventListener('livewire:initialized', () => {
            if (!window.alpineInitialized) {
                window.alpineInitialized = true;
                Alpine.start();
            }
        });
        // Fallback: if Livewire doesn't initialize within 2s, start Alpine anyway
        setTimeout(() => {
            if (!window.alpineInitialized) {
                window.alpineInitialized = true;
                Alpine.start();
            }
        }, 2000);
    } else {
        // No Livewire detected, initialize Alpine directly
        window.alpineInitialized = true;
        Alpine.start();
    }
});
