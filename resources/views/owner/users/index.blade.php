<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-[#710014]">
                User Management
            </h2>
            <p class="mt-1 text-sm text-[#756B62]">
                Kelola akun dan hak akses pengguna Restoe Boemi.
            </p>
        </div>
    </x-slot>

    <div class="min-h-[calc(100vh-180px)] py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">

            {{-- Notifikasi --}}
            @if (session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                {{ session('success') }}
            </div>
            @endif

            @if (session('error'))
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                {{ session('error') }}
            </div>
            @endif

            {{-- Ringkasan dan Pencarian --}}
            <div class="rounded-xl border border-[#E8DDD0] bg-white p-5 shadow-sm">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-[#756B62]">Total pengguna</p>
                        <p class="mt-1 text-3xl font-bold text-[#710014]">
                            {{ $users->total() }}
                        </p>
                    </div>

                    <form action="{{ route('owner.users.index') }}" method="GET"
                        class="flex w-full gap-2 sm:max-w-md">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama atau email..."
                            class="w-full rounded-lg border-[#DED2C5] text-sm focus:border-[#710014] focus:ring-[#710014]">

                        <button type="submit"
                            class="rounded-lg bg-[#710014] px-5 py-2 text-sm font-semibold text-white hover:bg-[#52000F]">
                            Cari
                        </button>

                        @if (request('search'))
                        <a href="{{ route('owner.users.index') }}"
                            class="rounded-lg border border-[#DED2C5] px-4 py-2 text-sm text-[#51463F] hover:bg-[#F5EFE6]">
                            Reset
                        </a>
                        @endif
                    </form>
                </div>
            </div>

            {{-- Tabel Pengguna --}}
            <div class="overflow-hidden rounded-xl border border-[#E8DDD0] bg-white shadow-sm">

                {{-- Header Tabel --}}
                <div class="flex flex-col gap-4 border-b border-[#E8DDD0] px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="font-bold text-[#710014]">
                            Daftar Pengguna
                        </h3>
                        <p class="mt-1 text-sm text-[#756B62]">
                            Informasi akun, role, dan status pengguna.
                        </p>
                    </div>

                    <a href="{{ route('owner.users.create') }}"
                        class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg bg-[#710014] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#52000F]">
                        <span class="text-lg leading-none">+</span>
                        Tambah Pengguna
                    </a>
                </div>

                {{-- Isi Tabel --}}
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[850px] text-left text-sm">
                        <thead class="bg-[#F5EFE6] text-xs uppercase tracking-wider text-[#756B62]">
                            <tr>
                                <th class="px-6 py-4">Pengguna</th>
                                <th class="px-6 py-4">Role</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Terdaftar</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#F0E8DF]">
                            @forelse ($users as $user)
                            <tr class="transition hover:bg-[#FCFAF7]">
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-[#211D1A]">
                                        {{ $user->name }}
                                    </p>
                                    <p class="mt-1 text-xs text-[#81766D]">
                                        {{ $user->email }}
                                    </p>
                                </td>

                                <td class="px-6 py-4">
                                    @forelse ($user->roles as $role)
                                    <span class="inline-flex rounded-full bg-[#F5EFE6] px-3 py-1 text-xs font-semibold capitalize text-[#710014]">
                                        {{ $role->name }}
                                    </span>
                                    @empty
                                    <span class="text-xs text-gray-400">
                                        Belum ada role
                                    </span>
                                    @endforelse
                                </td>

                                <td class="px-6 py-4">
                                    @if ($user->is_active)
                                    <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                        Aktif
                                    </span>
                                    @else
                                    <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                        Nonaktif
                                    </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-[#756B62]">
                                    {{ $user->created_at?->format('d M Y') ?? '-' }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        @if (!$user->hasRole('owner'))
                                        <a href="{{ route('owner.users.edit', $user) }}"
                                            class="rounded-lg border border-[#DED2C5] px-3 py-2 text-xs font-semibold text-[#710014] hover:bg-[#F5EFE6]">
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('owner.users.toggle-status', $user) }}"
                                            method="POST"
                                            data-confirm-title="{{ $user->is_active ? 'Nonaktifkan akun?' : 'Aktifkan akun?' }}"
                                            data-confirm-message="Yakin ingin {{ $user->is_active ? 'menonaktifkan' : 'mengaktifkan' }} akun '{{ $user->name }}'?"
                                            data-confirm-action="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                            data-confirm-type="{{ $user->is_active ? 'danger' : 'default' }}">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                class="rounded-lg px-3 py-2 text-xs font-semibold transition {{ $user->is_active ? 'bg-red-50 text-red-700 hover:bg-red-100' : 'bg-green-50 text-green-700 hover:bg-green-100' }}">
                                                {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                        @else
                                        <span class="text-xs font-medium text-[#81766D]">
                                            Akun utama
                                        </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <p class="font-semibold text-[#710014]">
                                        Pengguna tidak ditemukan
                                    </p>
                                    <p class="mt-1 text-sm text-[#81766D]">
                                        Coba gunakan kata kunci pencarian lain.
                                    </p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($users->hasPages())
                <div class="border-t border-[#E8DDD0] px-6 py-4">
                    {{ $users->links() }}
                </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>