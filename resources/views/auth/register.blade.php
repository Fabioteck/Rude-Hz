<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block font-black text-xs text-white uppercase tracking-[0.2em] mb-2">Artista / Nome</label>
            <x-text-input id="name" class="block w-full" type="text" name="name" :value="old('name')" required autofocus />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-black text-xs text-white uppercase tracking-[0.2em] mb-2">Email Privata</label>
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required />
        </div>

        <!-- Password Row -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="password" class="block font-black text-xs text-white uppercase tracking-[0.2em] mb-2">Password</label>
                <x-text-input id="password" class="block w-full" type="password" name="password" required />
            </div>
            <div>
                <label for="password_confirmation" class="block font-black text-xs text-white uppercase tracking-[0.2em] mb-2">Conferma</label>
                <x-text-input id="password_confirmation" class="block w-full" type="password" name="password_confirmation" required />
            </div>
        </div>

        <!-- Action Buttons: Gemelli ma Invertiti -->
        <div class="flex flex-col gap-4 pt-6">
            <!-- Bottone Primario -->
            <button type="submit" class="w-full h-[60px] flex items-center justify-center bg-[#d9ff00] text-black font-black uppercase text-sm tracking-[0.2em] rounded-full hover:bg-white transition-all shadow-[0_0_20px_rgba(217,255,0,0.15)]">
                {{ __('Create Account') }}
            </button>

            <!-- Bottone Secondario (Invertito) -->
            <a href="{{ route('login') }}" class="w-full h-[60px] flex items-center justify-center border-2 border-[#d9ff00] text-[#d9ff00] font-black uppercase text-sm tracking-[0.2em] rounded-full hover:bg-[#d9ff00] hover:text-black transition-all">
                {{ __('Already Registered?') }}
            </a>
        </div>
    </form>
</x-guest-layout>
