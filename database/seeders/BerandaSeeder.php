<?php

namespace Database\Seeders;

use App\Models\Beranda;
use App\Models\Desa;
use Illuminate\Database\Seeder;

class BerandaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mendapatkan semua desa
        $desas = Desa::all();

        foreach ($desas as $desa) {
            // Cek apakah desa sudah memiliki beranda
            if (!$desa->beranda()->exists()) {
                $this->command->info("Membuat data beranda untuk {$desa->jenis} {$desa->nama}");

                Beranda::create([
                    'desa_id' => $desa->id,
                    'judul_welcome' => "Selamat Datang di Situs Resmi {$desa->jenis} {$desa->nama}",
                    'deskripsi_welcome' => "<p>{$desa->jenis} {$desa->nama} adalah {$desa->jenis} yang terletak di {$desa->alamat}.</p><p>Website ini merupakan sarana publikasi untuk memberikan informasi dan layanan bagi masyarakat.</p>",
                    'show_berita' => true,
                    'judul_berita' => 'Berita Terbaru',
                    'jumlah_berita' => 6,
                    'show_lokasi' => true,
                    'judul_lokasi' => 'Lokasi ' . ucfirst($desa->jenis),
                    'embed_map' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31750.28514079922!2d122.60335517265627!3d-5.52080380000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2da475606ae32639%3A0x82e99d0c5a5b8b44!2sButon%20Selatan!5e0!3m2!1sid!2sid!4v1688917155318!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                    'show_struktur' => true,
                    'judul_struktur' => 'Struktur Pemerintahan',
                    'show_penduduk' => true,
                    'judul_penduduk' => 'Data Penduduk',
                    'total_penduduk' => rand(1000, 5000),
                    'penduduk_laki' => rand(500, 2500),
                    'penduduk_perempuan' => rand(500, 2500),
                    'tanggal_data_penduduk' => now(),
                    'show_apbdes' => true,
                    'judul_apbdes' => 'APBDesa 2025',
                    'pendapatan_desa' => rand(500000000, 1500000000),
                    'belanja_desa' => rand(400000000, 1400000000),
                    'target_pendapatan' => 1500000000,
                    'target_belanja' => 1500000000,
                    'show_galeri' => true,
                    'judul_galeri' => 'Galeri ' . ucfirst($desa->jenis),
                    'jumlah_galeri' => 6,
                ]);

                $this->command->info("Data beranda untuk {$desa->jenis} {$desa->nama} berhasil dibuat");
            } else {
                $this->command->info("{$desa->jenis} {$desa->nama} sudah memiliki data beranda");
            }
        }
    }
}
