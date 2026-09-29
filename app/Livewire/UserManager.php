<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UserManager extends Component
{
    use WithPagination;

    public bool $showModal = false;

    public ?int $userId = null;

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $role = 'Wali Kelas';

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$this->userId,
            'password' => $this->userId ? 'nullable|min:8' : 'required|min:8',
            'role' => 'required|exists:roles,name',
        ];
    }

    public function create(): void
    {
        $this->resetValidation();
        $this->reset(['userId', 'name', 'email', 'password']);
        $this->role = 'Wali Kelas';
        $this->showModal = true;
    }

    public function edit(User $user): void
    {
        $this->resetValidation();
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->role = $user->roles->first()?->name ?? 'Wali Kelas';
        $this->showModal = true;
    }

    public function save(): void
    {
        $validated = $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if (! empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        if (! $this->userId) {
            $data['email_verified_at'] = now();
        }

        $user = User::updateOrCreate(['id' => $this->userId], $data);
        $user->syncRoles([$this->role]);

        $this->showModal = false;
        session()->flash('message', 'Data akun pengguna berhasil disimpan.');
    }

    public function delete(User $user): void
    {
        if ($user->id === auth()->id()) {
            session()->flash('error', 'Tidak dapat menghapus akun yang sedang digunakan.');

            return;
        }

        $user->delete();
        session()->flash('message', 'Akun pengguna berhasil dihapus.');
    }

    public function render()
    {
        $users = User::with('roles')->orderBy('name', 'asc')->paginate(10);
        $roles = Role::orderBy('name', 'asc')->get();

        return view('livewire.user-manager', [
            'users' => $users,
            'roles' => $roles,
        ])->layout('layouts.app', ['title' => 'Manajemen Pengguna & Role']);
    }
}
