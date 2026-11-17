<x-guest-layout>

    <div class="mb-8">
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#9A897B]">
            Account Access
        </p>

        <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-[#211D1A]">
            Masuk ke Akun
        </h2>

        <p class="mt-2 text-sm leading-6 text-[#88796D]">
            Silakan masuk menggunakan akun Restoe Boemi yang telah terdaftar.
        </p>
    </div>

    <x-auth-session-status class="mb-5" :status="session('status')" />

    @if (session('success'))
    <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
        {{ session('success') }}
    </div>
    @endif

    <div
        class="rb-login-feedback"
        data-login-feedback
        data-login-error="{{ $errors->first('email') }}"
        role="alert"
        aria-live="assertive"
        hidden></div>

    <form method="POST" action="{{ route('login') }}" class="rb-login-form" data-login-form>
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="mb-2 block text-sm font-semibold text-[#44372F]">
                Alamat Email
            </label>

            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                placeholder="nama@email.com"
                class="block w-full rounded-lg border border-[#E5D6C3] bg-white px-4 py-3 text-sm text-[#211D1A] outline-none transition placeholder:text-[#B5A697] focus:border-[#710014] focus:ring-2 focus:ring-[#710014]/10">

        </div>

        <!-- Password -->
        <div class="mt-5">
            <div class="mb-2 flex items-center justify-between">
                <label for="password" class="block text-sm font-semibold text-[#44372F]">
                    Password
                </label>

                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                    class="text-xs font-semibold text-[#710014] hover:underline">
                    Lupa password?
                </a>
                @endif
            </div>

            <div class="relative">
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Masukkan password"
                    class="block w-full rounded-lg border border-[#E5D6C3] bg-white px-4 py-3 pr-16 text-sm text-[#211D1A] outline-none transition placeholder:text-[#B5A697] focus:border-[#710014] focus:ring-2 focus:ring-[#710014]/10">

                <button
                    type="button"
                    onclick="togglePassword()"
                    class="absolute inset-y-0 right-0 px-4 text-xs font-semibold text-[#710014] hover:text-[#570010]">
                    Lihat
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="mt-5">
            <label for="remember_me" class="inline-flex cursor-pointer items-center gap-2">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="rounded border-[#D7C5B3] text-[#710014] shadow-sm focus:ring-[#710014]">

                <span class="text-sm text-[#76685E]">
                    Ingat saya
                </span>
            </label>
        </div>

        <!-- Submit -->
        <button
            type="submit"
            class="mt-7 w-full rounded-lg bg-[#710014] px-5 py-3.5 text-sm font-bold tracking-wide text-white shadow-sm transition hover:bg-[#570010] focus:outline-none focus:ring-2 focus:ring-[#710014] focus:ring-offset-2">
            Masuk ke Dashboard
        </button>

    </form>

    <div class="mt-7 border-t border-[#E5D6C3] pt-5">
        <p class="text-center text-xs leading-6 text-[#9A897B]">
            Akses akun dikelola oleh Administrator Restoe Boemi.
            <br>
            Tidak tersedia pendaftaran akun publik.
        </p>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const button = event.currentTarget;

            if (password.type === 'password') {
                password.type = 'text';
                button.textContent = 'Sembunyi';
            } else {
                password.type = 'password';
                button.textContent = 'Lihat';
            }
        }
    </script>

</x-guest-layout>