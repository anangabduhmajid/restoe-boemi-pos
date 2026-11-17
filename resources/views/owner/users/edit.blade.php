<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-[#710014]">
                Edit Pengguna
            </h2>
            <p class="mt-1 text-sm text-[#756B62]">
                Perbarui informasi dan hak akses pengguna Restoe Boemi.
            </p>
        </div>
    </x-slot>

    <div class="min-h-[calc(100vh-180px)] py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

            <div class="rounded-xl border border-[#E8DDD0] bg-white p-6 shadow-sm sm:p-8">

                <div class="mb-6 border-b border-[#E8DDD0] pb-5">
                    <p class="text-sm text-[#756B62]">Mengedit akun</p>
                    <h3 class="mt-1 text-lg font-bold text-[#710014]">
                        {{ $user->name }}
                    </h3>
                    <p class="mt-1 text-sm text-[#81766D]">
                        ID Pengguna: #{{ $user->id }}
                    </p>
                </div>

                <form action="{{ route('owner.users.update', $user) }}"
                    method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div>
                        <label for="name" class="mb-2 block text-sm font-semibold text-[#211D1A]">
                            Nama Lengkap
                        </label>

                        <input type="text" id="name" name="name"
                            value="{{ old('name', $user->name) }}" required
                            class="w-full rounded-lg border-[#DED2C5] focus:border-[#710014] focus:ring-[#710014]">

                        @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-[#211D1A]">
                            Email
                        </label>

                        <input type="email" id="email" name="email"
                            value="{{ old('email', $user->email) }}" required
                            class="w-full rounded-lg border-[#DED2C5] focus:border-[#710014] focus:ring-[#710014]">

                        @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Role --}}
                    <div>
                        <label for="role" class="mb-2 block text-sm font-semibold text-[#211D1A]">
                            Role Pengguna
                        </label>

                        <select id="role" name="role" required
                            class="w-full rounded-lg border-[#DED2C5] focus:border-[#710014] focus:ring-[#710014]">

                            <option value="cashier"
                                {{ old('role', $user->getRoleNames()->first()) == 'cashier' ? 'selected' : '' }}>
                                Cashier / Kasir
                            </option>

                            <option value="kitchen"
                                {{ old('role', $user->getRoleNames()->first()) == 'kitchen' ? 'selected' : '' }}>
                                Kitchen / Dapur
                            </option>

                            <option value="customer"
                                {{ old('role', $user->getRoleNames()->first()) == 'customer' ? 'selected' : '' }}>
                                Customer / Pelanggan
                            </option>
                        </select>

                        @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="rounded-lg border border-[#E8DDD0] bg-[#FCFAF7] p-5">
                        <h4 class="font-semibold text-[#710014]">
                            Ganti Password
                        </h4>

                        <p class="mt-1 text-sm text-[#756B62]">
                            Kosongkan jika tidak ingin mengganti password pengguna.
                        </p>

                        <div class="mt-4 space-y-4">
                            <div>
                                <label for="password" class="mb-2 block text-sm font-semibold text-[#211D1A]">
                                    Password Baru
                                </label>

                                <input type="password" id="password" name="password"
                                    placeholder="Minimal 8 karakter"
                                    class="w-full rounded-lg border-[#DED2C5] focus:border-[#710014] focus:ring-[#710014]">

                                @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-[#211D1A]">
                                    Konfirmasi Password Baru
                                </label>

                                <input type="password" id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="Ulangi password baru"
                                    class="w-full rounded-lg border-[#DED2C5] focus:border-[#710014] focus:ring-[#710014]">
                            </div>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="rounded-lg border border-[#E8DDD0] p-4">
                        <p class="text-sm font-semibold text-[#211D1A]">
                            Status Akun
                        </p>

                        <div class="mt-2">
                            @if ($user->is_active)
                            <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                Aktif
                            </span>
                            @else
                            <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                Nonaktif
                            </span>
                            @endif
                        </div>

                        <p class="mt-2 text-xs text-[#81766D]">
                            Status akun dapat diubah melalui tombol pada daftar pengguna.
                        </p>
                    </div>

                    {{-- Tombol --}}
                    <div class="flex flex-col-reverse gap-3 border-t border-[#E8DDD0] pt-5 sm:flex-row sm:justify-end">
                        <a href="{{ route('owner.users.index') }}"
                            class="rounded-lg border border-[#DED2C5] px-5 py-2.5 text-center text-sm font-semibold text-[#51463F] hover:bg-[#F5EFE6]">
                            Batal
                        </a>

                        <button type="submit"
                            class="rounded-lg bg-[#710014] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#52000F]">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>