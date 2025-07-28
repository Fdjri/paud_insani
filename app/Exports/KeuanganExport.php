<?php

namespace App\Exports;

use App\Models\Keuangan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class KeuanganExport implements FromCollection, WithHeadings, WithMapping
{
    protected $tahun;
    protected $bulan;

    public function __construct($tahun = null, $bulan = null)
    {
        $this->tahun = $tahun;
        $this->bulan = $bulan;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Keuangan::query()
            ->when($this->tahun, fn($q) => $q->whereYear('tanggal', $this->tahun))
            ->when($this->bulan, fn($q) => $q->whereMonth('tanggal', $this->bulan))
            ->orderBy('tanggal', 'asc')
            ->get();
    }

    /**
     * Mendefinisikan header untuk kolom Excel.
     */
    public function headings(): array
    {
        return [
            'No.',
            'Deskripsi',
            'Tipe',
            'Tanggal',
            'Jumlah',
            'Biaya Satuan',
            'Total Biaya'
        ];
    }

    /**
     * Memetakan data dari collection ke format yang diinginkan.
     */
    public function map($keuangan): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        return [
            $rowNumber,
            $keuangan->deskripsi,
            ucfirst($keuangan->tipe),
            \Carbon\Carbon::parse($keuangan->tanggal)->format('d-m-Y'),
            $keuangan->jumlah,
            $keuangan->biaya,
            $keuangan->jumlah * $keuangan->biaya,
        ];
    }
}