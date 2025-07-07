<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <div class="flex flex-col items-center">
                <x-authentication-card-logo />
                <h2 class="mt-4 font-bold text-gray-800 text-2xl">DesaHub Login</h2>
                <p class="mt-2 text-gray-600 text-sm">Sistema Web Desa Terintegrasi</p>
            </div>
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-green-600 text-sm">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-gray-600 text-sm">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex justify-end items-center mt-4">
                @if (Route::has('password.request'))
                    <a class="rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 text-gray-600 hover:text-gray-900 text-sm underline"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>

        <div class="mt-4 text-center">
            <div class="text-gray-500 text-xs">
                <p><strong>Sistem khusus untuk admin. Login dengan kredensial:</strong></p>
                <p><strong>SuperAdmin:</strong> superadmin@mail.com / password</p>
                <p><strong>Admin Desa:</strong> admin@mail.id / password</p>
                <p><strong>Operator:</strong> operator@mail.id / password</p>
            </div>
        </div>
    </x-authentication-card>
</x-guest-layout>
