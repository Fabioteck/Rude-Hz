<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('messages.auth.email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('messages.auth.password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Checkbox Remember Me -->
        <div class="flex items-center mt-6 mb-6">
            <input id="remember_me" name="remember" type="checkbox" 
                   style="background-color: #27272a !important; border-color: #3f3f46 !important; color: #d2ff00 !important;"
                   class="h-4 w-4 rounded focus:ring-[#d2ff00] focus:ring-offset-zinc-900 checked:bg-[#d2ff00]">
            <label for="remember_me" class="ml-2 text-sm text-zinc-400 select-none">
                {{ __('messages.auth.remember_me') }}
            </label>
        </div>

        <!-- Bottone LOG IN (Giallo Acido originale e Testo Nero) -->
        <div class="mb-4">
            <button type="submit" 
                    style="background-color: #d2ff00 !important; color: #000000 !important;"
                    class="w-full font-extrabold py-3 px-4 rounded uppercase tracking-wider block text-center transition-all duration-200 hover:opacity-90">
                {{ __('messages.auth.login') }}
            </button>
        </div>

        <!-- Link Forgot Password -->
        <div class="text-center mb-8">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" 
                   class="text-xs text-zinc-500 hover:text-zinc-300 underline transition-colors">
                    {{ __('messages.auth.forgot_password') }}
                </a>
            @endif
        </div>

        <!-- Sezione Registrati (Verde Smeraldo, Testo Bianco per Leggibilità) -->
        <div class="text-center mb-12">
            <span class="text-xs text-zinc-600 block mb-3 tracking-widest uppercase">Non hai ancora un account?</span>
            <a href="{{ route('register') }}" 
               style="background-color: #10b981 !important; color: #ffffff !important;"
               class="w-full block font-extrabold py-3 px-4 rounded uppercase tracking-wider text-center transition-all duration-200 hover:opacity-90">
                {{ __('messages.auth.register') }}
            </a>
        </div>
    </form>
</x-guest-layout>
