<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class OwnerSeeder extends Seeder
{
    public function run(): void
    {
        $ownerRoleExists = \Spatie\Permission\Models\Role::where('name', 'owner')
            ->where('guard_name', 'web')
            ->exists();

        if (! $ownerRoleExists) {
            throw new RuntimeException('Role owner belum tersedia.');
        }

        if (\Spatie\Permission\Models\Role::where('name', 'owner')
            ->where('guard_name', 'web')
            ->first()
            ->users()
            ->exists()) {
            $this->command->warn('Akun Owner sudah tersedia. Tidak ada perubahan.');
            return;
        }

        $firstUser = User::orderBy('id')->first();

        if (! $firstUser) {
            throw new RuntimeException('Belum ada akun pengguna. Daftarkan akun terlebih dahulu.');
        }

        $firstUser->assignRole('owner');

        $this->command->info('Akun pertama berhasil ditetapkan sebagai Owner.');
        $this->command->info('Email: ' . $firstUser->email);
    }
}