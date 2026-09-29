<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $waliKelasRole = Role::firstOrCreate(['name' => 'Wali Kelas']);
        $kepalaSekolahRole = Role::firstOrCreate(['name' => 'Kepala Sekolah']);

        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@sdnjarak2.sch.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole($adminRole);

        // Create Wali Kelas User
        $waliKelas = User::firstOrCreate(
            ['email' => 'walikelas@sdnjarak2.sch.id'],
            [
                'name' => 'Wali Kelas VI-A',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $waliKelas->assignRole($waliKelasRole);

        // Create Kepala Sekolah User
        $kepalaSekolah = User::firstOrCreate(
            ['email' => 'kepsek@sdnjarak2.sch.id'],
            [
                'name' => 'Kepala Sekolah',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $kepalaSekolah->assignRole($kepalaSekolahRole);
    }
}
