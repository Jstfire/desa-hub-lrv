import './bootstrap';

// Import our centralized Alpine.js store registration (no default export)
import './alpine';
const Alpine = window.Alpine;


import AOS from 'aos';
import 'aos/dist/aos.css';

// Import zustand stores
import {
    useThemeStore,
    useLoadingStore,
    useToastStore,
    useModalStore,
    useNavigationStore,
    useVisitorStore
} from './stores';

// Initialize AOS for animations
AOS.init({
    duration: 800,
    offset: 100,
    once: true,
    easing: 'ease-in-out'
});

// Initialize theme
document.addEventListener('DOMContentLoaded', function () {
    const themeStore = useThemeStore.getState();
    themeStore.initializeTheme();

    // Setup theme toggle buttons
    const themeToggleButtons = document.querySelectorAll('[data-theme-toggle]');
    themeToggleButtons.forEach(button => {
        button.addEventListener('click', () => {
            themeStore.toggleTheme();
        });
    });

    // Setup mobile menu toggles
    const mobileMenuToggles = document.querySelectorAll('[data-mobile-menu-toggle]');
    const navigationStore = useNavigationStore.getState();

    mobileMenuToggles.forEach(toggle => {
        toggle.addEventListener('click', () => {
            navigationStore.toggleMobileMenu();
            updateMobileMenuUI();
        });
    });

    // Update mobile menu UI
    function updateMobileMenuUI() {
        const { isMobileMenuOpen } = useNavigationStore.getState();
        const mobileMenu = document.querySelector('[data-mobile-menu]');
        if (mobileMenu) {
            mobileMenu.classList.toggle('hidden', !isMobileMenuOpen);
        }
    }

    // Setup visitor stats button
    const visitorStatsButton = document.querySelector('[data-visitor-stats]');
    const visitorStatsModal = document.querySelector('[data-visitor-stats-modal]');

    if (visitorStatsButton && visitorStatsModal) {
        const visitorStore = useVisitorStore.getState();

        visitorStatsButton.addEventListener('click', () => {
            visitorStore.toggleStatsVisibility();
            updateVisitorStatsUI();
        });

        // Close stats when clicking outside
        document.addEventListener('click', (e) => {
            if (!visitorStatsButton.contains(e.target) && !visitorStatsModal.contains(e.target)) {
                visitorStore.hideStats();
                updateVisitorStatsUI();
            }
        });

        function updateVisitorStatsUI() {
            const { isStatsVisible } = useVisitorStore.getState();
            visitorStatsModal.classList.toggle('hidden', !isStatsVisible);
        }
    }

    // Setup toast notifications
    const toastContainer = document.querySelector('[data-toast-container]');
    if (toastContainer) {
        const toastStore = useToastStore.getState();

        // Listen for toast updates
        useToastStore.subscribe((state) => {
            updateToastsUI(state.toasts);
        });

        function updateToastsUI(toasts) {
            toastContainer.innerHTML = '';

            toasts.forEach(toast => {
                const toastElement = createToastElement(toast);
                toastContainer.appendChild(toastElement);
            });
        }

        function createToastElement(toast) {
            const div = document.createElement('div');
            div.className = `max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-gray-800 dark:border-gray-700 ${getToastStyles(toast.type)}`;

            div.innerHTML = `
                <div class="flex p-4">
                    <div class="flex-shrink-0">
                        ${getToastIcon(toast.type)}
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-gray-700 dark:text-gray-400">
                            ${toast.message}
                        </p>
                    </div>
                    <div class="ml-auto">
                        <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" onclick="this.parentElement.parentElement.parentElement.remove()">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            `;

            return div;
        }

        function getToastStyles(type) {
            switch (type) {
                case 'success': return 'border-green-200';
                case 'error': return 'border-red-200';
                case 'warning': return 'border-yellow-200';
                default: return 'border-blue-200';
            }
        }

        function getToastIcon(type) {
            const iconClasses = 'w-4 h-4';
            switch (type) {
                case 'success':
                    return `<svg class="${iconClasses} text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
                case 'error':
                    return `<svg class="${iconClasses} text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>`;
                case 'warning':
                    return `<svg class="${iconClasses} text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>`;
                default:
                    return `<svg class="${iconClasses} text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;
            }
        }
    }

    // Setup skeleton loading
    function showSkeletonLoading() {
        const skeletons = document.querySelectorAll('[data-skeleton]');
        const content = document.querySelectorAll('[data-content]');

        skeletons.forEach(skeleton => skeleton.classList.remove('hidden'));
        content.forEach(item => item.classList.add('hidden'));
    }

    function hideSkeletonLoading() {
        const skeletons = document.querySelectorAll('[data-skeleton]');
        const content = document.querySelectorAll('[data-content]');

        skeletons.forEach(skeleton => skeleton.classList.add('hidden'));
        content.forEach(item => item.classList.remove('hidden'));
    }

    // Show loading on page navigation
    window.addEventListener('beforeunload', showSkeletonLoading);

    // Hide loading when page is fully loaded
    window.addEventListener('load', () => {
        setTimeout(hideSkeletonLoading, 500); // Small delay for smooth transition
    });

    // SPA Navigation using fetch
    function setupSPANavigation() {
        const links = document.querySelectorAll('a[href^="/"]');

        links.forEach(link => {
            if (link.hasAttribute('data-spa-ignore')) return;

            link.addEventListener('click', async (e) => {
                e.preventDefault();

                const href = link.getAttribute('href');
                const loadingStore = useLoadingStore.getState();

                try {
                    loadingStore.setLoading(true, 'Memuat halaman...');
                    showSkeletonLoading();

                    const response = await fetch(href, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (response.ok) {
                        const html = await response.text();

                        // Update page content
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newContent = doc.querySelector('[data-spa-content]');
                        const currentContent = document.querySelector('[data-spa-content]');

                        if (newContent && currentContent) {
                            currentContent.innerHTML = newContent.innerHTML;

                            // Update page title
                            const newTitle = doc.querySelector('title');
                            if (newTitle) {
                                document.title = newTitle.textContent;
                            }

                            // Update URL
                            history.pushState({}, '', href);

                            // Reinitialize AOS for new content
                            AOS.refresh();
                        }
                    }
                } catch (error) {
                    console.error('SPA Navigation error:', error);
                    // Fallback to normal navigation
                    window.location.href = href;
                } finally {
                    loadingStore.clearLoading();
                    setTimeout(hideSkeletonLoading, 300);
                }
            });
        });
    }

    // Initialize SPA navigation
    setupSPANavigation();

    // Handle browser back/forward buttons
    window.addEventListener('popstate', () => {
        window.location.reload();
    });
});

// Toast notification system
window.showToast = function (message, type = 'info', duration = 5000) {
    const toastStore = useToastStore.getState();
    toastStore.addToast({
        message,
        type,
        duration
    });
};

// Global error handler
window.addEventListener('error', (event) => {
    console.error('Global error:', event.error);
    showToast('Terjadi kesalahan tak terduga. Silakan muat ulang halaman.', 'error');
});

// AJAX error handler
window.addEventListener('unhandledrejection', (event) => {
    console.error('Unhandled promise rejection:', event.reason);
    showToast('Terjadi kesalahan pada permintaan. Silakan coba lagi.', 'error');
});

// Form submission with toast
function setupFormSubmissions() {
    const forms = document.querySelectorAll('form[data-toast-submit]');

    forms.forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;

            try {
                submitButton.disabled = true;
                submitButton.textContent = 'Memproses...';
                showToast('Mengirim data...', 'info');

                const response = await fetch(form.action, {
                    method: form.method,
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                    }
                });

                if (response.ok) {
                    const result = await response.json();
                    showToast(result.message || 'Data berhasil disimpan!', 'success');

                    // Reset form if successful
                    form.reset();
                } else {
                    throw new Error('Request failed');
                }

            } catch (error) {
                showToast('Terjadi kesalahan saat mengirim data.', 'error');
            } finally {
                submitButton.disabled = false;
                submitButton.textContent = originalText;
            }
        });
    });
}

// Initialize form submissions on page load
document.addEventListener('DOMContentLoaded', setupFormSubmissions);

// Copy to clipboard functionality
window.copyToClipboard = async function (text, successMessage = 'Berhasil disalin!') {
    try {
        await navigator.clipboard.writeText(text);
        showToast(successMessage, 'success');
    } catch (err) {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        showToast(successMessage, 'success');
    }
};

// Auto-hide alerts
function setupAutoHideAlerts() {
    const alerts = document.querySelectorAll('[data-auto-hide]');

    alerts.forEach(alert => {
        const delay = parseInt(alert.getAttribute('data-auto-hide')) || 5000;

        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-20px)';

            setTimeout(() => {
                alert.remove();
            }, 300);
        }, delay);
    });
}

// Initialize auto-hide alerts
document.addEventListener('DOMContentLoaded', setupAutoHideAlerts);

// Global helper functions
window.showLoading = function (message = 'Memuat...') {
    const loadingStore = useLoadingStore.getState();
    loadingStore.setLoading(true, message);
};

window.hideLoading = function () {
    const loadingStore = useLoadingStore.getState();
    loadingStore.clearLoading();
};
