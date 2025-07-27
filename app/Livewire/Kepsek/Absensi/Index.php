<?php

namespace App\Livewire\Kepsek\Absensi;

use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class Index extends Component
{
    public $date;

    public function mount()
    {
        $this->date = Carbon::now();
    }

    public function previousMonth()
    {
        $this->date->subMonth();
    }

    public function nextMonth()
    {
        $this->date->addMonth();
    }

    public function goToToday()
    {
        $this->date = Carbon::now();
    }

    public function render()
    {
        $tahun = $this->date->year;

        $holidays = Cache::remember('hari_libur_' . $tahun, now()->addDay(), function () use ($tahun) {
            try {
                $response = Http::get("https://date.nager.at/api/v3/PublicHolidays/{$tahun}/ID");
                if ($response->successful()) {
                    $apiHolidays = $response->json();
                    $formattedHolidays = [];
                    foreach ($apiHolidays as $holiday) {
                        $formattedHolidays[$holiday['date']] = [
                            'name' => $holiday['localName'],
                            'color' => 'bg-orange-500'
                        ];
                    }
                    return $formattedHolidays;
                }
            } catch (\Exception $e) {
                return [];
            }
            return [];
        });

        // Kalkulasi data untuk kalender
        $namaBulan = $this->date->translatedFormat('F Y');
        $firstDayOfMonth = $this->date->copy()->firstOfMonth();
        $daysInMonth = $this->date->daysInMonth;
        $startDay = $firstDayOfMonth->dayOfWeekIso - 1;

        return view('livewire.kepsek.absensi.index', compact(
            'holidays', 
            'namaBulan', 
            'daysInMonth', 
            'startDay'
        ));
    }
}