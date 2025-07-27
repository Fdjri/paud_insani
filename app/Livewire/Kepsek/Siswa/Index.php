<?php

namespace App\Livewire\Kepsek\Siswa;

use App\Models\Siswa;
use App\Models\Kelas;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '', $filterKelas = '', $filterStatus = '';
    public $showDetailModal = false, $showEditModal = false, $showCreateModal = false;
    public ?Siswa $currentSiswa;
    public $foto;

    // Properti form lengkap dengan nilai default
    public $form = [
        'nama_lengkap' => '', 'nama_panggilan' => '', 'nis' => '', 'kelas_id' => null,
        'jenis_kelamin' => 'Laki-laki', 'no_kk' => '', 'nik' => '', 'tanggal_lahir' => '',
        'agama' => 'Islam', 'kewarganegaraan' => 'Indonesia', 'anak_ke' => '', 'jumlah_saudara_kandung' => '',
        'bahasa_sehari_hari' => 'Indonesia', 'berat_badan' => '', 'tinggi_badan' => '', 'golongan_darah' => '',
        'penyakit_yang_pernah_diderita' => '', 'nomor_telp' => '', 'jarak_tempat_tinggal_ke_sekolah' => '',
        'alamat_tempat_tinggal' => '', 'nama_ayah_kandung' => '', 'pendidikan_ayah' => '', 'pekerjaan_ayah' => '',
        'nama_ibu_kandung' => '', 'pendidikan_ibu' => '', 'pekerjaan_ibu' => '',
        'nama_wali' => '', 'pendidikan_wali' => '', 'pekerjaan_wali' => '', 'hubungan_wali' => '',
        'status' => 'aktif', 'tipe_murid' => 'Siswa Baru', 'tahun_masuk' => '',
    ];

    // Aturan validasi yang akan digunakan bersama
    protected function rules()
    {
        $siswaId = $this->currentSiswa?->id;
        return [
            'foto' => 'nullable|image|max:1024',
            'form.nama_lengkap' => 'required|string|max:255',
            'form.nama_panggilan' => 'nullable|string|max:50',
            'form.nis' => ['required', 'string', 'max:20', Rule::unique('siswas', 'nis')->ignore($siswaId)],
            'form.jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'form.no_kk' => ['nullable', 'string', 'max:20', Rule::unique('siswas', 'no_kk')->ignore($siswaId)],
            'form.nik' => ['required', 'string', 'max:20', Rule::unique('siswas', 'nik')->ignore($siswaId)],
            'form.tanggal_lahir' => 'required|date',
            'form.agama' => 'nullable|string|max:20',
            'form.kewarganegaraan' => 'nullable|string|max:50',
            'form.anak_ke' => 'nullable|integer',
            'form.jumlah_saudara_kandung' => 'nullable|integer',
            'form.bahasa_sehari_hari' => 'nullable|string|max:50',
            'form.berat_badan' => 'nullable|numeric',
            'form.tinggi_badan' => 'nullable|numeric',
            'form.golongan_darah' => 'nullable|string|max:2',
            'form.penyakit_yang_pernah_diderita' => 'nullable|string',
            'form.nomor_telp' => 'nullable|string|max:20',
            'form.jarak_tempat_tinggal_ke_sekolah' => 'nullable|string|max:10',
            'form.alamat_tempat_tinggal' => 'required|string',
            'form.nama_ayah_kandung' => 'nullable|string|max:255',
            'form.pendidikan_ayah' => 'nullable|string|max:50',
            'form.pekerjaan_ayah' => 'nullable|string|max:100',
            'form.nama_ibu_kandung' => 'nullable|string|max:255',
            'form.pendidikan_ibu' => 'nullable|string|max:50',
            'form.pekerjaan_ibu' => 'nullable|string|max:100',
            'form.nama_wali' => 'nullable|string|max:255',
            'form.pendidikan_wali' => 'nullable|string|max:50',
            'form.pekerjaan_wali' => 'nullable|string|max:100',
            'form.hubungan_wali' => 'nullable|string|max:50',
            'form.status' => 'required|in:aktif,lulus,keluar',
            'form.tipe_murid' => 'required|in:Siswa Baru,Mutasi',
            'form.tahun_masuk' => 'required|integer|digits:4',
        ];
    }
    
    public function create()
    {
        $this->reset('form', 'foto');
        $this->currentSiswa = new Siswa();
        $this->showCreateModal = true;
    }
    public function store()
    {
        $validated = $this->validate();
        $createData = $validated['form'];
        if ($this->foto) {
            $createData['foto'] = $this->foto->store('siswa-photos', 'public');
        }
        Siswa::create($createData);
        $this->closeCreateModal();
        $this->dispatch('notify', 'Data siswa baru berhasil ditambahkan!');
    }

    public function showDetail(Siswa $siswa) 
    { 
        $this->currentSiswa = $siswa->load('kelas'); 
        $this->showDetailModal = true; 
    }
    public function edit(Siswa $siswa)
    {
        $this->currentSiswa = $siswa;
        $this->form = $siswa->toArray();
        $this->showEditModal = true;
    }
    public function update()
    {
        $validated = $this->validate();
        $updateData = $validated['form'];
        if ($this->foto) {
            if ($this->currentSiswa->foto) { Storage::disk('public')->delete($this->currentSiswa->foto); }
            $updateData['foto'] = $this->foto->store('siswa-photos', 'public');
        }
        $this->currentSiswa->update($updateData);
        $this->closeEditModal();
        $this->dispatch('notify', 'Data siswa berhasil diperbarui!');
    }

    #[On('delete-confirmed')]
    public function destroy($id) 
    { 
        Siswa::find($id)->delete(); 
        $this->dispatch('notify', 'Data siswa berhasil dihapus.'); 
    }

    public function closeCreateModal() 
    { 
        $this->showCreateModal = false; 
        $this->reset('form', 'foto'); 
    }

    public function closeDetailModal() 
    { 
        $this->showDetailModal = false; 
    }

    public function closeEditModal() 
    { 
        $this->showEditModal = false; 
        $this->reset('form', 'currentSiswa', 'foto'); 
    }
    
    public function render()
    {
        $siswas = Siswa::with('kelas')->when($this->search, fn($q) => $q->where('nama_lengkap', 'like', '%'.$this->search.'%'))->when($this->filterKelas, fn($q) => $q->whereHas('kelas', fn($sq) => $sq->where('nama_kelas', $this->filterKelas)))->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))->latest('id')->paginate(10);
        return view('livewire.kepsek.siswa.index', ['siswas' => $siswas, 'listKelas' => Kelas::all()]);
    }
}