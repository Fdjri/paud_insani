<?php

namespace App\Livewire\Guru\Siswa;

use Livewire\Component;
use App\Models\Siswa;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    // Properti baru untuk modal
    public $showDetailModal = false;
    public ?Siswa $currentSiswa;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Method baru untuk menampilkan modal detail.
     */
    public function showDetail(Siswa $siswa)
    {
        $this->currentSiswa = $siswa->load('kelas');
        $this->showDetailModal = true;
    }

    public function render()
    {
        $user = Auth::user();
        $kelasWali = $user->kelas;

        $siswas = collect();

        if ($kelasWali) {
            $siswas = Siswa::where('kelas_id', $kelasWali->id)
                ->where('status', 'aktif')
                ->when($this->search, function ($query) {
                    $query->where('nama_lengkap', 'like', '%' . $this->search . '%');
                })
                ->orderBy('nama_lengkap', 'asc')
                ->paginate(10);
        }
            
        return view('livewire.guru.siswa.index', [
            'siswas' => $siswas,
            'kelasWali' => $kelasWali,
        ]);
    }
}