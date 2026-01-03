<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #333; }
        .header p { margin: 5px 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #4CAF50; color: white; padding: 10px; text-align: left; }
        td { padding: 8px; border-bottom: 1px solid #ddd; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #666; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; }
        .badge-success { background-color: #d4edda; color: #155724; }
        .badge-warning { background-color: #fff3cd; color: #856404; }
        .badge-danger { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Periode: {{ $month }} {{ $year }}</p>
        <p>Dicetak: {{ $generatedAt }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Homebase</th>
                <th>Lokasi</th>
                <th>Status</th>
                <th>Baterai (%)</th>
                <th>Kapasitas (%)</th>
                <th>Update Terakhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($vacuums as $index => $vacuum)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $vacuum->code }}</td>
                <td>{{ $vacuum->homebase->name ?? 'N/A' }}</td>
                <td>{{ $vacuum->homebase->location ?? 'N/A' }}</td>
                <td>
                    <span class="badge 
                        @if($vacuum->status === 'active') badge-success
                        @elseif($vacuum->status === 'maintenance') badge-warning
                        @else badge-danger
                        @endif">
                        {{ ucfirst($vacuum->status) }}
                    </span>
                </td>
                <td>{{ $vacuum->battery_level }}%</td>
                <td>{{ $vacuum->capacity }}%</td>
                <td>{{ $vacuum->updated_at->format('d/m/Y H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 20px;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Smart Waste Bin - Politeknik Batam</p>
        <p>Dokumen ini digenerate otomatis oleh sistem</p>
    </div>
</body>
</html>