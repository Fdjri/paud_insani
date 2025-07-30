<?php

namespace App\Livewire\Bendahara\Keuangan;

use Livewire\Component;
use App\Models\Keuangan;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;

    public $search = '', $filterBulan = '', $filterTipe = '';
    public $showCreateModal = false, $showEditModal = false;
    public ?Keuangan $currentKeuangan;

    public $form = [
        'deskripsi' => '',
        'tipe' => 'pemasukan',
        'tanggal' => '',
        'jumlah' => 1,
        'biaya' => 0,
    ];

    protected function rules()
    {
        return [
            'form.deskripsi' => 'required|string|max:255',
            'form.tipe' => 'required|in:pemasukan,pengeluaran',
            'form.tanggal' => 'required|date',
            'form.jumlah' => 'required|integer|min:1',
            'form.biaya' => 'required|numeric|min:0',
        ];
    }
    
    public function create() 
    { 
        $this->reset('form');
        $this->form['tanggal'] = now()->format('Y-m-d');
        $this->showCreateModal = true; 
    }

    public function store() 
    {
        $validated = $this->validate();
        Keuangan::create($validated['form']);
        $this->closeCreateModal();
        $this->dispatch('notify', 'Data keuangan baru berhasil ditambahkan!');
    }

    public function edit(Keuangan $keuangan) 
    {
        $this->currentKeuangan = $keuangan;
        $this->form = $keuangan->only(['deskripsi', 'tipe', 'tanggal', 'jumlah', 'biaya']);
        $this->showEditModal = true;
    }

    public function update() 
    {
        $validated = $this->validate();
        $this->currentKeuangan->update($validated['form']);
        $this->closeEditModal();
        $this->dispatch('notify', 'Data keuangan berhasil diperbarui!');
    }

    #[On('delete-confirmed')]
    public function destroy($id) 
    { 
        Keuangan::find($id)->delete();
        $this->dispatch('notify', 'Data keuangan berhasil dihapus.');
    }

    public function closeCreateModal() { $this->showCreateModal = false; }
    public function closeEditModal() { $this->showEditModal = false; }

    public function render()
    {
        $pemasukan = Keuangan::where('tipe', 'pemasukan')->sum(DB::raw('jumlah * biaya'));
        $pengeluaran = Keuangan::where('tipe', 'pengeluaran')->sum(DB::raw('jumlah * biaya'));
        $totalDana = $pemasukan - $pengeluaran;

        $keuangans = Keuangan::query()
            ->when($this->search, fn($q) => $q->where('deskripsi', 'like', '%' . $this->search . '%'))
            ->when($this->filterBulan, fn($q) => $q->whereMonth('tanggal', $this->filterBulan))
            ->when($this->filterTipe, fn($q) => $q->where('tipe', $this->filterTipe))
            ->latest('tanggal')
            ->paginate(10);
            
        return view('livewire.bendahara.keuangan.index', [
            'keuangans' => $keuangans,
            'totalDana' => $totalDana,
        ]);
    }
}