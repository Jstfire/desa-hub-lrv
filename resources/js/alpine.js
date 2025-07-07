/**
 * Alpine.js Core Setup
 * This file initializes Alpine.js and registers all required plugins
 * It is loaded once and handles all Alpine.js configuration
 * 
 * IMPORTANT: This file only PREPARES Alpine.js, it does NOT start it.
 * Starting Alpine.js is handled in app.js and filament-init.js to ensure
 * proper Livewire integration.
 */


// Use global Alpine (from alpine-plugins.js)
const Alpine = window.Alpine;

// Register core stores on alpine:init
document.addEventListener('alpine:init', () => {
    // Sidebar store (required for Filament)
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

            // Navigation group functionality (support both naming conventions)
            isGroupCollapsed(group) {
                return this.collapsedGroups[group] ?? false;
            },
            groupIsCollapsed(group) {
                return this.collapsedGroups[group] ?? false;
            },
            toggleCollapsed(group) {
                this.collapsedGroups[group] = !this.isGroupCollapsed(group);
            },
            toggleCollapsedGroup(group) {
                this.collapsedGroups[group] = !this.groupIsCollapsed(group);
            }
        });
    }

    // Theme store
    if (!Alpine.store('theme')) {
        Alpine.store('theme', {
            mode: localStorage.getItem('theme') || 'system',

            toggle() {
                this.mode = this.mode === 'dark' ? 'light' : 'dark';
                localStorage.setItem('theme', this.mode);
                this.refreshMode();
            },

            refreshMode() {
                const isDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (this.mode === 'dark' || (this.mode === 'system' && isDarkMode)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
        });
    }

    // Notifications store
    if (!Alpine.store('notifications')) {
        Alpine.store('notifications', {
            notifications: [],
            add(notification) {
                this.notifications.push(notification);

                // Auto-remove after timeout if specified
                if (notification.timeout) {
                    setTimeout(() => {
                        this.remove(notification);
                    }, notification.timeout);
                }
            },
            remove(notification) {
                this.notifications = this.notifications.filter(n => n !== notification);
            }
        });
    }
});


