@extends('layouts.app')

@section('title', 'Peta Sebaran Pencari Kerja')

@section('content')
<div class="space-y-4">
    <h1 class="text-2xl font-bold text-gray-800">Peta Sebaran Pencari Kerja</h1>
    <p class="text-gray-600">Marker merah = prioritas tinggi, kuning = sedang, hijau = rendah</p>
    
    <!-- Container dengan overflow hidden dan z-index rendah -->
    <div class="bg-white rounded-lg shadow overflow-hidden" style="height: 550px; width: 100%;">
        <div id="map" style="height: 100%; width: 100%; z-index: 1;"></div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi map
        var map = L.map('map').setView([-6.2, 106.8], 11);
        
        // Simpan ke window agar bisa diakses dari layout
        window.petaMap = map;
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        // Mock data markers
        const markers = [
            { nama: 'Ahmad Subekti', lat: -6.2, lng: 106.8, skor: 92, alamat: 'Jakarta Pusat' },
            { nama: 'Siti Aminah', lat: -6.25, lng: 106.85, skor: 88, alamat: 'Jakarta Timur' },
            { nama: 'Budi Santoso', lat: -6.18, lng: 106.82, skor: 85, alamat: 'Jakarta Selatan' }
        ];
        
        function getColor(skor) {
            if (skor > 75) return 'red';
            if (skor > 50) return 'gold';
            return 'green';
        }
        
        markers.forEach(m => {
            const color = getColor(m.skor);
            const icon = L.divIcon({
                html: `<div style="background-color: ${color}; width: 14px; height: 14px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 4px black;"></div>`,
                iconSize: [18, 18],
                className: 'custom-marker'
            });
            
            L.marker([m.lat, m.lng], { icon: icon })
                .addTo(map)
                .bindPopup(`
                    <b>${m.nama}</b><br>
                    Alamat: ${m.alamat}<br>
                    Skor: <strong>${m.skor}</strong><br>
                    Status: ${m.skor > 75 ? 'Prioritas Tinggi 🔴' : (m.skor > 50 ? 'Prioritas Sedang 🟡' : 'Prioritas Rendah 🟢')}
                `);
        });
        
        // Fix resize issue
        setTimeout(function() {
            map.invalidateSize();
        }, 200);
    });
</script>
@endsection