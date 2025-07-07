/**
 * This script fixes Alpine.js sidebar-related function issues in Filament.
 * It ensures all required Filament sidebar functions are available with consistent naming.
 */

// Import our Alpine.js store registration (no default export)
import './alpine';
const Alpine = window.Alpine;

// Define the sidebar fix function before Alpine initialization
document.addEventListener('alpine:init', () => {
    // Register the sidebar store if it doesn't exist already
    if (!Alpine.store('sidebar')) {
        Alpine.store('sidebar', {
            isOpen: window.innerWidth >= 1024,
            collapsedGroups: Alpine.$persist({}).as('sidebar-collapsed-groups'),

            // Core sidebar functionality
            toggle() {
                this.isOpen = !this.isOpen;
            },
            open() {
                this.isOpen = true;
            },
            close() {
                this.isOpen = false;
            },

            // Support both naming conventions for group collapse
            groupIsCollapsed(group) {
                return this.collapsedGroups[group] ?? false;
            },
            isGroupCollapsed(group) {
                return this.collapsedGroups[group] ?? false;
            },

            // Support both naming conventions for toggling groups
            toggleCollapsedGroup(group) {
                this.collapsedGroups[group] = !this.collapsedGroups[group];
            },
            toggleCollapsed(group) {
                this.collapsedGroups[group] = !this.collapsedGroups[group];
            }
        });
    } else {
        // The store exists, ensure it has all required functions
        const sidebar = Alpine.store('sidebar');

        // Add missing functions if necessary
        if (!sidebar.isGroupCollapsed) {
            sidebar.isGroupCollapsed = function (group) {
                return this.collapsedGroups[group] ?? false;
            };
        }

        if (!sidebar.groupIsCollapsed) {
            sidebar.groupIsCollapsed = function (group) {
                return this.collapsedGroups[group] ?? false;
            };
        }

        if (!sidebar.toggleCollapsed) {
            sidebar.toggleCollapsed = function (group) {
                this.collapsedGroups[group] = !this.collapsedGroups[group];
            };
        }

        if (!sidebar.toggleCollapsedGroup) {
            sidebar.toggleCollapsedGroup = function (group) {
                this.collapsedGroups[group] = !this.collapsedGroups[group];
            };
        }
    }

    console.debug('Filament sidebar functions configured successfully');
});
