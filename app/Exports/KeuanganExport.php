<?php

namespace App\Exports;

use App\Models\Keuangan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents; // <-- Tambahkan ini
use Maatwebsite\Excel\Events\AfterSheet;   // <-- Tambahkan ini
use Maatwebsite\Excel\Concerns\WithStyles; // <-- Tambahkan ini
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet; // <-- Tambahkan ini

class KeuanganExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithStyles
{
    protected $tahun;
    protected $bulan;
    private $totalDana = 0;

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
        $query = Keuangan::query()
            ->when($this->tahun, fn($q) => $q->whereYear('tanggal', $this->tahun))
            ->when($this->bulan, fn($q) => $q->whereMonth('tanggal', $this->bulan));

        // Hitung total dana untuk ringkasan
        $pemasukan = (clone $query)->where('tipe', 'pemasukan')->sum(DB::raw('jumlah * biaya'));
        $pengeluaran = (clone $query)->where('tipe', 'pengeluaran')->sum(DB::raw('jumlah * biaya'));
        $this->totalDana = $pemasukan - $pengeluaran;

        return $query->orderBy('tanggal', 'asc')->get();
    }

    public function headings(): array
    {
        return [
            'No.', 'Deskripsi', 'Tipe', 'Tanggal',
            'Jumlah', 'Biaya Satuan', 'Total Biaya'
        ];
    }

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

    /**
     * Menambahkan style pada sheet.
     */
    public function styles(Worksheet $sheet)
    {
        // Membuat baris header menjadi tebal (bold)
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    /**
     * Menambahkan baris ringkasan setelah semua data ditulis.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Mendapatkan baris terakhir
                $lastRow = $event->sheet->getHighestRow() + 2; // Tambah 2 baris untuk spasi

                // Mengatur style untuk baris total
                $event->sheet->getDelegate()->getStyle("F{$lastRow}:G{$lastRow}")->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT],
                ]);

                // Menulis data ringkasan
                $event->sheet->getDelegate()->setCellValue("F{$lastRow}", 'Total Dana:');
                $event->sheet->getDelegate()->setCellValue("G{$lastRow}", $this->totalDana);

                // Mengatur format angka untuk kolom total dana
                $event->sheet->getDelegate()->getStyle("G{$lastRow}")->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            },
        ];
    }
}