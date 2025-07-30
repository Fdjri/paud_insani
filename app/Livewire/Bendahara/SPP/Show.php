<?php

namespace App\Livewire\Bendahara\SPP;

use Livewire\Component;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    public $tahun;
    public $bulan;
    public $namaBulan;

    public $statusPembayaran = [];

    // Properti untuk filter dan pencarian
    public $search = '';
    public $filterKelas = '';
    public $filterStatus = ''; // Lunas / Belum Lunas / Cicil

    public function mount($tahun, $bulan)
    {
        $this->tahun = $tahun;
        $this->bulan = (int) $bulan;
        $this->namaBulan = Carbon::create()->month($this->bulan)->translatedFormat('F');
        
        // Buat nama bulan dalam Bahasa Inggris KHUSUS untuk query
        $englishMonthName = Carbon::create()->month($this->bulan)->format('F');

        $semuaSiswaAktif = Siswa::where('status', 'aktif')
            ->with(['pembayaran' => fn($q) => $q->where('tahun_ajaran', $this->tahun)->where('bulan_pembayaran', $englishMonthName)])
            ->get();

        foreach ($semuaSiswaAktif as $siswa) {
            $this->statusPembayaran[$siswa->id] = $siswa->pembayaran->isNotEmpty() ? 'Lunas' : 'Belum Lunas';
        }
    }
    
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

    public function save()
    {
        foreach ($this->statusPembayaran as $siswaId => $status) {
            if ($status == 'Lunas' || $status == 'Cicil') {
                Pembayaran::updateOrCreate(
                    [
                        'siswa_id' => $siswaId,
                        'tahun_ajaran' => $this->tahun,
                        'bulan_pembayaran' => $this->namaBulan,
                    ],
                    [
                        'user_id' => auth()->id(),
                        'jumlah_bayar' => 300000, // Nominal default
                        'tanggal_bayar' => now(),
                        'status' => $status, // Simpan status yang dipilih
                    ]
                );
            } else { // Jika status adalah 'Belum Lunas'
                Pembayaran::where('siswa_id', $siswaId)
                    ->where('tahun_ajaran', $this->tahun)
                    ->where('bulan_pembayaran', $this->namaBulan)
                    ->delete();
            }
        }
        $this->dispatch('notify', 'Status pembayaran SPP berhasil disimpan!');
    }

    public function render()
    {
        // Buat nama bulan dalam Bahasa Inggris KHUSUS untuk query
        $englishMonthName = Carbon::create()->month($this->bulan)->format('F');

        $siswas = Siswa::where('status', 'aktif')
            ->with(['kelas', 'pembayaran' => fn($q) => $q->where('tahun_ajaran', $this->tahun)->where('bulan_pembayaran', $englishMonthName)])
            ->when($this->search, fn($q) => $q->where('nama_lengkap', 'like', '%' . $this->search . '%'))
            ->when($this->filterKelas, fn($q) => $q->whereHas('kelas', fn($sq) => $sq->where('nama_kelas', $this->filterKelas)))
            ->when($this->filterStatus, function ($query) use ($englishMonthName) {
                if ($this->filterStatus == 'Lunas') {
                    $query->whereHas('pembayaran', fn($q) => $q->where('tahun_ajaran', $this->tahun)->where('bulan_pembayaran', $englishMonthName));
                } elseif ($this->filterStatus == 'Belum Lunas') {
                    $query->whereDoesntHave('pembayaran', fn($q) => $q->where('tahun_ajaran', $this->tahun)->where('bulan_pembayaran', $englishMonthName));
                }
            })
            ->orderBy('nama_lengkap', 'asc')
            ->paginate(10);

        return view('livewire.bendahara.spp.show', [
            'siswas' => $siswas,
            'listKelas' => Kelas::all(),
        ]);
    }
}