
<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-[#710014]">Tambah Pengguna</h2>
            <p class="mt-1 text-sm text-[#756B62]">
                Buat akun baru untuk operasional Restoe Boemi.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-xl border border-[#E8DDD0] bg-white p-6 shadow-sm sm:p-8">

                <form action="{{ route('owner.users.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="mb-2 block text-sm font-semibold text-[#211D1A]">
                            Nama Lengkap
                        </label>
                        <input type="text" id="name" name="name"
                            value="{{ old('name') }}" required
                            placeholder="Masukkan nama pengguna"
                            class="w-full rounded-lg border-[#DED2C5] focus:border-[#710014] focus:ring-[#710014]">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-[#211D1A]">
                            Email
                        </label>
                        <input type="email" id="email" name="email"
                            value="{{ old('email') }}" required
                            placeholder="contoh@email.com"
                            class="w-full rounded-lg border-[#DED2C5] focus:border-[#710014] focus:ring-[#710014]">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="role" class="mb-2 block text-sm font-semibold text-[#211D1A]">
                            Role Pengguna
                        </label>
                        <select id="role" name="role" required
                            class="w-full rounded-lg border-[#DED2C5] focus:border-[#710014] focus:ring-[#710014]">
                            <option value="">Pilih role</option>
                            <option value="cashier" {{ old('role') == 'cashier' ? 'selected' : '' }}>Cashier / Kasir</option>
                            <option value="kitchen" {{ old('role') == 'kitchen' ? 'selected' : '' }}>Kitchen / Dapur</option>
                            <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer / Pelanggan</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-semibold text-[#211D1A]">
                            Password
                        </label>
                        <input type="password" id="password" name="password" required
                            placeholder="Minimal 8 karakter"
                            class="w-full rounded-lg border-[#DED2C5] focus:border-[#710014] focus:ring-[#710014]">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-[#211D1A]">
                            Konfirmasi Password
                        </label>
                        <input type="password" id="password_confirmation"
                            name="password_confirmation" required
                            placeholder="Ulangi password"
                            class="w-full rounded-lg border-[#DED2C5] focus:border-[#710014] focus:ring-[#710014]">
                    </div>

                    <div class="rounded-lg border border-[#E8DDD0] bg-[#F5EFE6] p-4">
                        <p class="text-sm font-semibold text-[#710014]">Informasi</p>
                        <p class="mt-1 text-sm text-[#756B62]">
                            Akun baru akan langsung berstatus aktif. Hak akses diberikan
                            berdasarkan role yang dipilih.
                        </p>
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-[#E8DDD0] pt-5 sm:flex-row sm:justify-end">
                        <a href="{{ route('owner.users.index') }}"
                            class="rounded-lg border border-[#DED2C5] px-5 py-2.5 text-center text-sm font-semibold text-[#51463F] hover:bg-[#F5EFE6]">
                            Batal
                        </a>

                        <button type="submit"
                            class="rounded-lg bg-[#710014] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#52000F]">
                            Simpan Pengguna
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
