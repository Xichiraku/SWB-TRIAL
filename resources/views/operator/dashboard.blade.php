@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Dashboard Operator</h1>

    {{-- CARD 3 KOLOM --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        {{-- Homebase --}}
        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-gray-500">Total Homebase</p>
            <p class="text-4xl font-bold text-blue-600">{{ $total_homebase }}</p>
        </div>

        {{-- Vacuum --}}
        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-gray-500">Total Vacuum</p>
            <p class="text-4xl font-bold text-green-600">{{ $total_vacuum }}</p>
        </div>

        {{-- Peringatan --}}
        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-gray-500">Total Peringatan</p>
            <p class="text-4xl font-bold text-red-600">{{ $total_peringatan }}</p>
        </div>

    </div>

    {{-- TABLE LIST HOMEBASE --}}
    <div class="bg-white shadow rounded-xl p-6">
        <h2 class="text-xl font-semibold mb-4">List Homebase</h2>

        <table class="min-w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 border">Nama Homebase</th>
                    <th class="p-3 border">Lokasi</th>
                    <th class="p-3 border">Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($homebases as $hb)
                    <tr>
                        <td class="p-3 border">{{ $hb->nama }}</td>
                        <td class="p-3 border">{{ $hb->lokasi }}</td>
                        <td class="p-3 border">
                            <span class="px-3 py-1 rounded-full text-white 
                                {{ $hb->status == 'aktif' ? 'bg-green-600' : 'bg-gray-500' }}">
                                {{ ucfirst($hb->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="p-3 text-center">Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection