<div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
    <div class="flex items-center justify-between mb-6">
        <button wire:click="goToToday" class="px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
            Today
        </button>
        <div class="flex items-center gap-4">
            <button wire:click="previousMonth" class="p-2 rounded-full hover:bg-gray-100" title="Bulan Sebelumnya">
                <i class="las la-angle-left text-xl"></i>
            </button>
            <h2 class="text-lg font-semibold text-gray-800 w-32 text-center">{{ $namaBulan }}</h2>
            <button wire:click="nextMonth" class="p-2 rounded-full hover:bg-gray-100" title="Bulan Berikutnya">
                <i class="las la-angle-right text-xl"></i>
            </button>
        </div>
        <div class="w-24"></div>
    </div>

    <div class="grid grid-cols-7">
        @foreach (['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'] as $hari)
            <div class="text-center font-semibold text-xs text-gray-500 py-3 border-b">{{ $hari }}</div>
        @endforeach

        @for ($i = 0; $i < $startDay; $i++)
            <div class="border-r border-b border-gray-200"></div>
        @endfor

        @for ($day = 1; $day <= $daysInMonth; $day++)
            @php
                $currentDate = $date->copy()->setDay($day);
                $tanggalPenuh = $currentDate->format('Y-m-d');
                $isToday = $tanggalPenuh == now()->format('Y-m-d');
                $isWeekend = $currentDate->isWeekend();
                $isHoliday = isset($holidays[$tanggalPenuh]);
            @endphp
            
            @if (!$isWeekend)
                <a href="{{ route('guru.absensi.create', ['tanggal' => $tanggalPenuh]) }}"
                   class="relative p-2 h-28 text-sm border-r border-b border-gray-200 hover:bg-blue-50 transition-colors duration-200 @if($isToday) ring-2 ring-blue-500 z-10 @endif">
            @else
                <div class="relative p-2 h-28 text-sm border-r border-b border-gray-200 striped-bg text-gray-400">
            @endif
                <span class="{{ $isToday ? 'font-bold text-blue-600' : 'text-gray-700' }}">{{ $day }}</span>
                @if($isHoliday)
                    <div class="absolute bottom-2 left-0 right-0 px-1">
                        <div class="p-1 text-xs text-white rounded {{ $holidays[$tanggalPenuh]['color'] }} truncate">
                            {{ $holidays[$tanggalPenuh]['name'] }}
                        </div>
                    </div>
                @endif
            @if (!$isWeekend) </a> @else </div> @endif
        @endfor
    </div>
</div>