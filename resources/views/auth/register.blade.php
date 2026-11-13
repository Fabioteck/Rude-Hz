<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- 1. ARTISTA / NOME (Input con sfondo Nero, pronto per il testo) -->
        <div>
            <x-input-label for="name" :value="__('Artista / Nome')" />
            <x-text-input id="name" 
                          style="background-color: #000000 !important; color: #ffffff !important; border-color: #d2ff00 !important;"
                          class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- 2. EMAIL PRIVATA (Sfondo Bianco forzato, pronto per il testo) -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email Privata')" />
            <x-text-input id="email" 
                          style="background-color: #ffffff !important; color: #000000 !important;"
                          class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- 3. PASSWORD & CONFERMA (Sfondi Bianchi forzati) -->
        <div class="mt-4 grid grid-cols-2 gap-4">
            <div>
                <x-input-label for="password" :value="__('messages.auth.password')" />
                <x-text-input id="password" 
                              style="background-color: #ffffff !important; color: #000000 !important;"
                              class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('messages.auth.confirm_password')" />
                <x-text-input id="password_confirmation" 
                              style="background-color: #ffffff !important; color: #000000 !important;"
                              class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <!-- 4. BOTTONE CREATE ACCOUNT (Giallo Acido Originale - Invariato) -->
        <div class="mt-8 mb-4">
            <button type="submit" 
                    style="background-color: #d2ff00 !important; color: #000000 !important;"
                    class="w-full font-extrabold py-3 px-4 rounded uppercase tracking-wider block text-center transition-all duration-200 hover:opacity-90">
                {{ __('messages.auth.register') }}
            </button>
        </div>

        <!-- 5. BOTTONE ALREADY REGISTERED? (Allineato con Login: Verde Acido, Testo Nero) -->
        <div class="text-center">
            <a href="{{ route('login') }}" 
               style="background-color: #39ff14 !important; color: #000000 !important;"
               class="w-full block font-extrabold py-3 px-4 rounded uppercase tracking-wider text-center transition-all duration-200 hover:opacity-90">
                {{ __('messages.auth.already_registered') }}
            </a>
        </div>
    </form>
</x-guest-layout>
