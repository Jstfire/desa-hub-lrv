<template x-teleport="body">
    <div x-data="toastSystem" @notify.window="add($event.detail)" class="top-4 right-4 z-50 fixed flex flex-col gap-2">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="toast.visible" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-2"
                :class="{
                    'bg-green-500': toast.type === 'success',
                    'bg-red-500': toast.type === 'error',
                    'bg-yellow-500': toast.type === 'warning',
                    'bg-blue-500': toast.type === 'info',
                    'dark:text-white': true
                }"
                class="flex justify-between items-center shadow-lg p-4 rounded-lg min-w-[300px] text-white">
                <div class="flex items-center space-x-2">
                    <div x-show="toast.type === 'success'" class="flex-shrink-0">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div x-show="toast.type === 'error'" class="flex-shrink-0">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div x-show="toast.type === 'warning'" class="flex-shrink-0">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div x-show="toast.type === 'info'" class="flex-shrink-0">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span x-text="toast.message"></span>
                </div>
                <button @click="remove(toast.id)" class="ml-4 text-white hover:text-gray-100">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </template>
    </div>
</template>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('toastSystem', () => ({
            toasts: [],
            nextId: 1,

            add(toast) {
                const id = this.nextId++;
                const newToast = {
                    id,
                    message: toast.message,
                    type: toast.type || 'info',
                    visible: true,
                    timeout: toast.timeout || 5000
                };

                this.toasts.push(newToast);

                if (newToast.timeout) {
                    setTimeout(() => this.remove(id), newToast.timeout);
                }
            },

            remove(id) {
                const index = this.toasts.findIndex(toast => toast.id === id);
                if (index !== -1) {
                    this.toasts[index].visible = false;
                    setTimeout(() => {
                        this.toasts = this.toasts.filter(toast => toast.id !== id);
                    }, 300);
                }
            }
        }));
    });

    // Helper function to dispatch toast notifications
    window.notify = function(message, type = 'info', timeout = 5000) {
        window.dispatchEvent(new CustomEvent('notify', {
            detail: {
                message,
                type,
                timeout
            }
        }));
    };
</script>
