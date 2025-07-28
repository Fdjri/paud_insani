<?php

namespace App\Livewire\Kepsek\Guru;

use Livewire\Component;
use App\Models\User;
use App\Models\Kelas;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $showDetailModal = false, $showEditModal = false, $showCreateModal = false;
    public ?User $currentUser;
    public $foto;

    public $form = [
        'nama' => '', 'nik' => '', 'username' => '', 'password' => '', 'tanggal_lahir' => '',
        'nomor_anggota' => '', 'pendidikan' => '', 'npwp' => '', 'periode' => '', 'role' => 'guru',
        'kelas_id' => null,
    ];

    protected function rules()
    {
        $userId = $this->currentUser?->id;
        return [
            'foto' => 'nullable|image|max:1024',
            'form.nama' => 'required|string|max:255',
            'form.nik' => ['required', 'string', 'digits:16', Rule::unique('users', 'nik')->ignore($userId)],
            'form.username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($userId)],
            'form.password' => [$this->showCreateModal ? 'required' : 'nullable', 'string', 'min:8'],
            'form.tanggal_lahir' => 'required|date',
            'form.nomor_anggota' => ['nullable', 'string', Rule::unique('users', 'nomor_anggota')->ignore($userId)],
            'form.pendidikan' => 'nullable|string|max:255',
            'form.npwp' => 'nullable|string|max:25',
            'form.periode' => 'nullable|string|max:20',
            'form.role' => 'required|in:guru,operator,bendahara,kepala sekolah',
            'form.kelas_id' => 'nullable|exists:kelas,id',
        ];
    }

    public function showDetail(User $user) { $this->currentUser = $user->load('kelas'); $this->showDetailModal = true; }
    public function create() { $this->reset('form', 'foto'); $this->currentUser = new User(); $this->showCreateModal = true; }
    public function edit(User $user) { $this->currentUser = $user; $this->form = $user->toArray(); $this->showEditModal = true; }

    public function store()
    {
        $validated = $this->validate();
        $createData = $this->form;
        $createData['password'] = Hash::make($validated['form']['password']);

        if ($this->foto) {
            $createData['foto'] = $this->foto->store('user-photos', 'public');
        }

        $user = User::create($createData);
        if ($this->form['role'] === 'guru' && !empty($this->form['kelas_id'])) {
            Kelas::where('id', $this->form['kelas_id'])->update(['guru_id' => $user->id]);
        }
        
        $this->closeCreateModal();
        $this->dispatch('notify', 'Data baru berhasil ditambahkan!');
    }

    public function update()
    {
        $validated = $this->validate();
        $updateData = $this->form;

        if (!empty($updateData['password'])) {
            $updateData['password'] = Hash::make($validated['form']['password']);
        } else {
            unset($updateData['password']);
        }

        if ($this->foto) {
            if ($this->currentUser->foto) { Storage::disk('public')->delete($this->currentUser->foto); }
            $updateData['foto'] = $this->foto->store('user-photos', 'public');
        }
        
        $this->currentUser->update($updateData);

        if ($this->form['role'] === 'guru') {
            // Lepaskan dari kelas lama jika ada, lalu pasang ke kelas baru jika dipilih
            Kelas::where('guru_id', $this->currentUser->id)->update(['guru_id' => null]);
            if (!empty($this->form['kelas_id'])) {
                Kelas::where('id', $this->form['kelas_id'])->update(['guru_id' => $this->currentUser->id]);
            }
        }
        
        $this->closeEditModal();
        $this->dispatch('notify', 'Data berhasil diperbarui!');
    }

    #[On('delete-confirmed')]
    public function destroy($id) { User::find($id)->delete(); $this->dispatch('notify', 'Data berhasil dihapus.'); }
    
    public function closeCreateModal() { $this->showCreateModal = false; }
    public function closeEditModal() { $this->showEditModal = false; }
    public function closeDetailModal() { $this->showDetailModal = false; }

    public function render()
    {
        $roleOrder = "FIELD(role, 'kepala sekolah', 'operator', 'bendahara', 'guru')";
        $users = User::query()
            ->with('kelas')
            ->when($this->search, fn($q) => $q->where('nama', 'like', '%' . $this->search . '%'))
            ->orderByRaw($roleOrder)
            ->latest('id')
            ->paginate(6);

        return view('livewire.kepsek.guru.index', [
            'users' => $users,
            'listKelas' => Kelas::all(),
        ]);
    }
}