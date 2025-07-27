<?php

namespace App\Livewire\Kepsek\Absensi;

use Livewire\Component;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Absensi;
use Carbon\Carbon;
use Livewire\WithPagination; // <-- Tambahkan ini

class Create extends Component
{
    use WithPagination; // <-- Tambahkan ini

    public $tanggal;
    public $kehadiran = [];

    // Properti baru untuk filter dan pencarian
    public $search = '';
    public $filterKelas = '';
    public $filterStatus = ''; // Filter status kehadiran

    /**
     * Method ini berjalan saat component pertama kali dimuat.
     */
    public function mount($tanggal)
    {
        $this->tanggal = $tanggal;

        // Mengambil semua siswa yang aktif untuk mengisi nilai default
        $semuaSiswaAktif = Siswa::where('status', 'aktif')
            ->with(['absensi' => fn($q) => $q->where('tanggal_absensi', $this->tanggal)])
            ->get();

        foreach ($semuaSiswaAktif as $siswa) {
            $this->kehadiran[$siswa->id] = $siswa->absensi->first()->status ?? 'Hadir';
        }
    }
    
    // Reset halaman saat melakukan pencarian atau filter
    public function updatingSearch() { $this->resetPage(); }
    public function updatedFilterKelas() { $this->resetPage(); }
    public function updatedFilterStatus() { $this->resetPage(); }

    public function resetFilters()
    {
        $this->search = '';
        $this->filterKelas = '';
        $this->filterStatus = '';
        $this->resetPage();
    }
    
    /**
     * Menyimpan semua data absensi ke database.
     */
    public function save()
    {
        foreach ($this->kehadiran as $siswaId => $status) {
            Absensi::updateOrCreate(
                ['siswa_id' => $siswaId, 'tanggal_absensi' => $this->tanggal],
                ['status' => $status]
            );
        }
        $this->dispatch('notify', 'Absensi untuk tanggal ' . Carbon::parse($this->tanggal)->format('d F Y') . ' berhasil disimpan!');
    }

    public function render()
    {
        // Query siswa dengan filter dan paginasi
        $siswas = Siswa::where('status', 'aktif')
            ->with('kelas')
            ->when($this->search, fn($q) => $q->where('nama_lengkap', 'like', '%' . $this->search . '%'))
            ->when($this->filterKelas, fn($q) => $q->whereHas('kelas', fn($sq) => $sq->where('nama_kelas', $this->filterKelas)))
            ->when($this->filterStatus, function ($query) {
                // Filter berdasarkan status kehadiran yang sudah dipilih
                $siswaIds = collect($this->kehadiran)->filter(fn($status) => $status == $this->filterStatus)->keys();
                $query->whereIn('id', $siswaIds);
            })
            ->orderBy('nama_lengkap', 'asc')
            ->paginate(10); // Menampilkan 10 siswa per halaman

        return view('livewire.kepsek.absensi.create', [
            'siswas' => $siswas,
            'listKelas' => Kelas::all(),
        ]);
    }
}