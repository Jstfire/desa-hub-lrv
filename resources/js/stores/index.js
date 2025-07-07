import { create } from 'zustand'

// Store untuk theme (dark/light mode)
export const useThemeStore = create((set, get) => ({
    isDark: false,

    toggleTheme: () => set((state) => {
        const newIsDark = !state.isDark;
        document.documentElement.classList.toggle('dark', newIsDark);
        localStorage.setItem('theme', newIsDark ? 'dark' : 'light');
        return { isDark: newIsDark };
    }),

    initializeTheme: () => {
        const savedTheme = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const isDark = savedTheme === 'dark' || (!savedTheme && prefersDark);

        document.documentElement.classList.toggle('dark', isDark);
        set({ isDark });
    }
}));

// Store untuk loading states
export const useLoadingStore = create((set) => ({
    isLoading: false,
    loadingMessage: '',

    setLoading: (loading, message = '') => set({
        isLoading: loading,
        loadingMessage: message
    }),

    clearLoading: () => set({
        isLoading: false,
        loadingMessage: ''
    })
}));

// Store untuk notifikasi toast
export const useToastStore = create((set, get) => ({
    toasts: [],

    addToast: (toast) => {
        const id = Date.now() + Math.random();
        const newToast = {
            id,
            type: 'info',
            duration: 5000,
            ...toast
        };

        set((state) => ({
            toasts: [...state.toasts, newToast]
        }));

        // Auto remove toast
        setTimeout(() => {
            get().removeToast(id);
        }, newToast.duration);

        return id;
    },

    removeToast: (id) => set((state) => ({
        toasts: state.toasts.filter(toast => toast.id !== id)
    })),

    clearToasts: () => set({ toasts: [] })
}));

// Store untuk modal/dialog
export const useModalStore = create((set) => ({
    modals: {},

    openModal: (modalId, data = {}) => set((state) => ({
        modals: {
            ...state.modals,
            [modalId]: { isOpen: true, data }
        }
    })),

    closeModal: (modalId) => set((state) => ({
        modals: {
            ...state.modals,
            [modalId]: { isOpen: false, data: {} }
        }
    })),

    isModalOpen: (modalId) => {
        const { modals } = get();
        return modals[modalId]?.isOpen || false;
    }
}));

// Store untuk navigation
export const useNavigationStore = create((set) => ({
    isMobileMenuOpen: false,
    currentPage: '',
    breadcrumbs: [],

    toggleMobileMenu: () => set((state) => ({
        isMobileMenuOpen: !state.isMobileMenuOpen
    })),

    closeMobileMenu: () => set({ isMobileMenuOpen: false }),

    setCurrentPage: (page) => set({ currentPage: page }),

    setBreadcrumbs: (breadcrumbs) => set({ breadcrumbs })
}));

// Store untuk visitor statistics
export const useVisitorStore = create((set) => ({
    stats: {
        today: 0,
        yesterday: 0,
        thisWeek: 0,
        lastWeek: 0,
        thisMonth: 0,
        lastMonth: 0,
        total: 0
    },
    isStatsVisible: false,

    setStats: (stats) => set({ stats }),

    toggleStatsVisibility: () => set((state) => ({
        isStatsVisible: !state.isStatsVisible
    })),

    hideStats: () => set({ isStatsVisible: false })
}));
