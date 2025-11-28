@props(['binNumber', 'location', 'status' => 'normal', 'capacity' => 45, 'fillPercent' => 78])

@php
    $statusMap = [
      'normal' => ['label' => 'Normal', 'bg' => 'bg-sky-100 text-sky-800', 'dot' => 'bg-sky-500'],
      'full' => ['label' => 'Full', 'bg' => 'bg-red-100 text-red-800', 'dot' => 'bg-red-500'],
      'maintenance' => ['label' => 'Maintenance', 'bg' => 'bg-orange-100 text-orange-800', 'dot' => 'bg-orange-500'],
      'warning' => ['label' => 'Warning', 'bg' => 'bg-yellow-100 text-yellow-800', 'dot' => 'bg-yellow-500'],
    ];
    $s = $statusMap[$status] ?? $statusMap['normal'];
@endphp

<div class="soft-card rounded-2xl p-4 mb-4 bin-pressable cursor-pointer">
  <div class="flex items-center gap-4">
    <!-- left icon and text -->
    <div class="w-1/3 md:w-2/5">
      <div class="flex items-start gap-3">
        <div class="p-3 rounded-lg bg-sky-50">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-sky-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M9 13h6M8 7h8l1 12H7L8 7z" /></svg>
        </div>
        <div>
          <div class="font-bold text-lg text-slate-800">Bin #{{ $binNumber }}</div>
          <div class="text-sm text-slate-500 mt-1"> <svg xmlns="http://www.w3.org/2000/svg" class="inline h-4 w-4 mr-1 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" d="M12 2c4 0 7 3 7 7 0 8-7 13-7 13S5 17 5 9c0-4 3-7 7-7z"/></svg> {{ $location }}</div>
        </div>
      </div>
    </div>

    <!-- center: status + capacity -->
    <div class="flex-1 px-4">
      <div class="flex items-center justify-between">
        <div>
          <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $s['bg'] }}">
            @if($status === 'full')
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M10 14l2-2 2 2m-2-2v6" /></svg>
            @endif
            {{ $s['label'] }}
          </span>
        </div>
        <div class="text-sm text-slate-600 font-medium">Capacity <span class="ml-2">{{ $capacity }}%</span></div>
      </div>

      <div class="mt-3">
        <div class="progress-track">
          <div class="progress-fill" style="width: {{ $capacity }}%"></div>
        </div>
      </div>
    </div>

    <!-- right: fill indicator -->
    <div class="w-36 text-right">
      <div class="flex items-center justify-end gap-3">
        <div class="h-4 w-4 rounded-full {{ $s['dot'] }}"></div>
        <div class="text-sky-700 font-medium">{{ $fillPercent }}%</div>
      </div>
    </div>
  </div>
</div>
