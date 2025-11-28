<div class="mb-8">
  <h2 class="text-3xl font-extrabold text-slate-900 mb-1">Dashboard Monitoring</h2>
  <div class="text-slate-600 mb-6">Last updated: <span id="current-time" class="font-mono">--:--:--</span></div>

  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
    <!-- Total Bins -->
    <div class="soft-card rounded-xl p-5 bg-white">
      <div class="flex justify-between items-start">
        <div>
          <div class="text-xl font-bold text-slate-800">5</div>
          <div class="text-sm text-slate-500">Total Bins</div>
        </div>
        <div class="text-slate-400">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M9 13h6M8 7h8l1 12H7L8 7z" />
          </svg>
        </div>
      </div>
    </div>

    <!-- Full -->
    <div class="soft-card rounded-xl p-5 bg-white">
      <div class="flex justify-between items-start mb-3">
        <div>
          <div class="text-2xl font-bold text-red-600">2</div>
          <div class="text-sm text-slate-500">Full</div>
        </div>
        <div class="text-red-100 px-2 py-1 rounded-full bg-red-50">!</div>
      </div>
      <div class="progress-track w-full">
        <div class="progress-fill" style="width:45%"></div>
      </div>
    </div>

    <!-- Normal -->
    <div class="soft-card rounded-xl p-5 bg-white">
      <div class="flex justify-between items-start mb-3">
        <div>
          <div class="text-2xl font-bold text-emerald-700">2</div>
          <div class="text-sm text-slate-500">Normal</div>
        </div>
        <div class="text-emerald-300 px-2 py-1 rounded-full bg-emerald-50">✓</div>
      </div>
      <div class="progress-track w-full">
        <div class="progress-fill" style="width:75%"></div>
      </div>
    </div>

    <!-- Maintenance -->
    <div class="soft-card rounded-xl p-5 bg-white">
      <div class="flex justify-between items-start mb-3">
        <div>
          <div class="text-2xl font-bold text-orange-500">1</div>
          <div class="text-sm text-slate-500">Maintenance</div>
        </div>
        <div class="text-orange-300 px-2 py-1 rounded-full bg-orange-50">⚙</div>
      </div>
      <div class="progress-track w-full">
        <div class="progress-fill" style="width:10%"></div>
      </div>
    </div>
  </div>
</div>
