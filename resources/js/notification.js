/**
 * Advanced Toast Notification System
 * Supports multiple types, queuing, and animations
 */

class ToastNotification {
    constructor() {
        this.container = null;
        this.queue = [];
        this.isProcessing = false;
        this.init();
    }

    init() {
        // Create container if not exists
        if (!document.getElementById('toast-container')) {
            this.container = document.createElement('div');
            this.container.id = 'toast-container';
            this.container.className = 'fixed top-4 right-4 z-50 space-y-2 max-w-sm';
            document.body.appendChild(this.container);
        } else {
            this.container = document.getElementById('toast-container');
        }
    }

    show(message, type = 'info', duration = 5000, options = {}) {
        const toast = {
            id: Date.now() + Math.random(),
            message,
            type,
            duration,
            options: {
                closable: true,
                persistent: false,
                ...options
            }
        };

        this.queue.push(toast);
        this.processQueue();
    }

    processQueue() {
        if (this.isProcessing || this.queue.length === 0) return;

        this.isProcessing = true;
        const toast = this.queue.shift();
        this.createToast(toast);

        // Process next toast after a short delay
        setTimeout(() => {
            this.isProcessing = false;
            this.processQueue();
        }, 300);
    }

    createToast(toast) {
        const toastElement = document.createElement('div');
        toastElement.id = `toast-${toast.id}`;
        toastElement.className = this.getToastClasses(toast.type);

        toastElement.innerHTML = `
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    ${this.getIcon(toast.type)}
                </div>
                <div class="ml-3 w-0 flex-1">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                        ${toast.message}
                    </p>
                    ${toast.options.description ? `
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            ${toast.options.description}
                        </p>
                    ` : ''}
                </div>
                ${toast.options.closable ? `
                    <div class="ml-4 flex-shrink-0 flex">
                        <button class="toast-close-btn inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">
                            <span class="sr-only">Tutup</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                ` : ''}
            </div>
        `;

        // Add click handler for close button
        const closeBtn = toastElement.querySelector('.toast-close-btn');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => this.remove(toast.id));
        }

        // Add to container with animation
        this.container.appendChild(toastElement);

        // Trigger animation
        requestAnimationFrame(() => {
            toastElement.classList.add('toast-enter');
        });

        // Auto remove if not persistent
        if (!toast.options.persistent && toast.duration > 0) {
            setTimeout(() => {
                this.remove(toast.id);
            }, toast.duration);
        }

        // Add click to dismiss (optional)
        if (toast.options.clickToClose) {
            toastElement.addEventListener('click', () => this.remove(toast.id));
        }
    }

    getToastClasses(type) {
        const baseClasses = `
            transform transition-all duration-300 ease-in-out
            max-w-sm w-full bg-white dark:bg-gray-800 shadow-lg rounded-lg pointer-events-auto
            ring-1 ring-black ring-opacity-5 overflow-hidden
            translate-x-full opacity-0 toast-enter-start
        `;

        const typeClasses = {
            success: 'border-l-4 border-green-500',
            error: 'border-l-4 border-red-500',
            warning: 'border-l-4 border-yellow-500',
            info: 'border-l-4 border-blue-500',
            default: 'border-l-4 border-gray-500'
        };

        return `${baseClasses} ${typeClasses[type] || typeClasses.default}`;
    }

    getIcon(type) {
        const icons = {
            success: `
                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            `,
            error: `
                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
            `,
            warning: `
                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
            `,
            info: `
                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            `,
            default: `
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            `
        };

        return icons[type] || icons.default;
    }

    remove(toastId) {
        const toastElement = document.getElementById(`toast-${toastId}`);
        if (toastElement) {
            toastElement.classList.add('toast-exit');
            setTimeout(() => {
                if (toastElement.parentNode) {
                    toastElement.parentNode.removeChild(toastElement);
                }
            }, 300);
        }
    }

    removeAll() {
        const toasts = this.container.querySelectorAll('[id^="toast-"]');
        toasts.forEach(toast => {
            toast.classList.add('toast-exit');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        });
        this.queue = [];
    }

    // Convenience methods
    success(message, options = {}) {
        this.show(message, 'success', 5000, options);
    }

    error(message, options = {}) {
        this.show(message, 'error', 7000, options);
    }

    warning(message, options = {}) {
        this.show(message, 'warning', 6000, options);
    }

    info(message, options = {}) {
        this.show(message, 'info', 5000, options);
    }
}

// Global instance
window.toast = new ToastNotification();

// Add CSS for animations
const style = document.createElement('style');
style.textContent = `
    .toast-enter-start {
        transform: translateX(100%);
        opacity: 0;
    }
    
    .toast-enter {
        transform: translateX(0);
        opacity: 1;
    }
    
    .toast-exit {
        transform: translateX(100%);
        opacity: 0;
    }
    
    /* Smooth animations */
    #toast-container > div {
        transition: all 0.3s ease-in-out;
    }
`;
document.head.appendChild(style);

export default ToastNotification;
