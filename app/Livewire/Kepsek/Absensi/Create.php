<?php

namespace App\Livewire\Kepsek\Absensi;

use Livewire\Component;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Livewire\WithPagination;

class Create extends Component
{
    use WithPagination;

    public $tanggal;
    public $kehadiran = [];
    public $search = '', 
           $filterKelas = '', 
           $filterStatus = '';
    public $isHoliday = false;
    public $holidayName = '';

    public function mount($tanggal)
    {
        $this->tanggal = $tanggal;
        $date = Carbon::parse($tanggal);
        $tahun = $date->year;

        if ($date->isWeekend()) {
            $this->isHoliday = true;
            $this->holidayName = 'Akhir Pekan';
            return;
        }

        // Ambil data libur dari cache atau API
        $holidaysData = Cache::remember('hari_libur_' . $tahun, now()->addDay(), function () use ($tahun) {
            try {
                $response = Http::get("https://date.nager.at/api/v3/PublicHolidays/{$tahun}/ID");
                if ($response->successful()) {
                    // Kembalikan array biasa, kita akan ubah ke collection nanti
                    return $response->json();
                }
            } catch (\Exception $e) {
                return []; // Kembalikan array kosong jika gagal
            }
            return [];
        });

        // PENTING: Ubah data dari cache/API menjadi Collection di sini
        $holidays = collect($holidaysData)->keyBy('date');

        if ($holidays->has($this->tanggal)) {
            $this->isHoliday = true;
            $this->holidayName = $holidays->get($this->tanggal)['localName'];
            return;
        }

        // Jika bukan hari libur, siapkan data absensi
        $semuaSiswaAktif = Siswa::where('status', 'aktif')
            ->with(['absensi' => fn($q) => $q->where('tanggal_absensi', $this->tanggal)])
            ->get();

        foreach ($semuaSiswaAktif as $siswa) {
            $this->kehadiran[$siswa->id] = $siswa->absensi->first()->status ?? 'Kosong';
        }
    }
    
    // Reset halaman saat melakukan pencarian atau filter
    public function updatingSearch() 
    { 
        $this->resetPage(); 
    }
    
    public function updatedFilterKelas() 
    { 
        $this->resetPage(); 
    }

    public function updatedFilterStatus() 
    { 
        $this->resetPage(); 
    }

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
            // Jangan simpan data jika statusnya 'Kosong'
            if ($status !== 'Kosong') {
                Absensi::updateOrCreate(
                    ['siswa_id' => $siswaId, 'tanggal_absensi' => $this->tanggal],
                    ['status' => $status]
                );
            }
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
                $siswaIds = collect($this->kehadiran)->filter(fn($status) => $status == $this->filterStatus)->keys();
                $query->whereIn('id', $siswaIds);
            })
            ->orderBy('nama_lengkap', 'asc')
            ->paginate(10);

        return view('livewire.kepsek.absensi.create', [
            'siswas' => $siswas,
            'listKelas' => Kelas::all(),
        ]);
    }
}