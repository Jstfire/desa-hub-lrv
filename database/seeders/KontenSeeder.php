<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\DataSektoral;
use App\Models\Desa;
use App\Models\Footer;
use App\Models\Galeri;
use App\Models\Metadata;
use App\Models\Pengaduan;
use App\Models\Ppid;
use App\Models\Publikasi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class KontenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createBerita();
        $this->createPublikasi();
        $this->createDataSektoral();
        $this->createMetadata();
        $this->createPpid();
        $this->createGaleri();
        $this->createFooter();
        $this->createPengaduan();
    }

    /**
     * Seed sample berita
     */
    private function createBerita(): void
    {
        // Get all desa IDs
        $desaIds = Desa::pluck('id')->toArray();
        $adminId = User::where('email', 'admin@example.com')->value('id');

        if (empty($desaIds) || !$adminId) {
            return;
        }

        $kategoriBerita = ['berita', 'pengumuman', 'kegiatan', 'program'];

        // Create some sample berita
        for ($i = 0; $i < 20; $i++) {
            $desaId = $desaIds[array_rand($desaIds)];
            $kategori = $kategoriBerita[array_rand($kategoriBerita)];
            $isPublished = rand(0, 10) > 2; // 80% chance to be published
            $isHighlight = rand(0, 10) > 7; // 30% chance to be highlight

            $berita = Berita::create([
                'desa_id' => $desaId,
                'user_id' => $adminId,
                'judul' => "Berita {$kategori} " . ($i + 1),
                'slug' => "berita-{$kategori}-" . ($i + 1) . "-" . time(),
                'kategori' => $kategori,
                'konten' => "<p>Ini adalah konten {$kategori} " . ($i + 1) . ". Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl sit amet nisl. Sed vitae nisl euismod, aliquam nisl sit amet, aliquam nisl.</p>",
                'is_published' => $isPublished,
                'is_highlight' => $isHighlight,
                'published_at' => now()->subDays(rand(0, 30)),
                'view_count' => rand(0, 1000),
                'tags' => implode(',', ['tag1', 'tag2', 'tag' . rand(3, 10)]),
            ]);
        }
    }

    /**
     * Seed sample publikasi
     */
    private function createPublikasi(): void
    {
        // Get all desa IDs
        $desaIds = Desa::pluck('id')->toArray();
        $adminId = User::where('email', 'admin@example.com')->value('id');

        if (empty($desaIds) || !$adminId) {
            return;
        }

        $kategoriPublikasi = ['laporan_keuangan', 'laporan_kegiatan', 'rencana_kerja', 'peraturan_desa', 'transparansi', 'lainnya'];

        // Create some sample publikasi
        for ($i = 0; $i < 15; $i++) {
            $desaId = $desaIds[array_rand($desaIds)];
            $kategori = $kategoriPublikasi[array_rand($kategoriPublikasi)];
            $isPublished = rand(0, 10) > 2; // 80% chance to be published
            $tahun = rand(2020, 2025);

            $publikasi = Publikasi::create([
                'desa_id' => $desaId,
                'user_id' => $adminId,
                'judul' => "Publikasi {$kategori} tahun {$tahun}",
                'slug' => "publikasi-{$kategori}-{$tahun}-" . ($i + 1) . "-" . time(),
                'kategori' => $kategori,
                'tahun' => $tahun,
                'deskripsi' => "Ini adalah deskripsi untuk publikasi {$kategori} tahun {$tahun}. Dokumen ini berisi informasi penting untuk referensi masyarakat.",
                'is_published' => $isPublished,
                'published_at' => now()->subDays(rand(0, 30)),
                'download_count' => rand(0, 500),
            ]);
        }
    }

    /**
     * Seed sample data sektoral
     */
    private function createDataSektoral(): void
    {
        // Get all desa IDs
        $desaIds = Desa::pluck('id')->toArray();
        $adminId = User::where('email', 'admin@example.com')->value('id');

        if (empty($desaIds) || !$adminId) {
            return;
        }

        $sektorData = ['kependudukan', 'kesehatan', 'pendidikan', 'ekonomi', 'pertanian', 'infrastruktur', 'lainnya'];

        // Create some sample data sektoral
        for ($i = 0; $i < 15; $i++) {
            $desaId = $desaIds[array_rand($desaIds)];
            $sektor = $sektorData[array_rand($sektorData)];
            $isPublished = rand(0, 10) > 2; // 80% chance to be published
            $tahun = rand(2020, 2025);

            // Generate sample data based on sektor
            $data = [];

            if ($sektor == 'kependudukan') {
                $data = [
                    ['label' => 'Jumlah Penduduk', 'value' => rand(1000, 5000), 'satuan' => 'jiwa'],
                    ['label' => 'Jumlah Laki-laki', 'value' => rand(500, 2500), 'satuan' => 'jiwa'],
                    ['label' => 'Jumlah Perempuan', 'value' => rand(500, 2500), 'satuan' => 'jiwa'],
                    ['label' => 'Kepadatan Penduduk', 'value' => rand(100, 500), 'satuan' => 'jiwa/km²'],
                ];
            } elseif ($sektor == 'kesehatan') {
                $data = [
                    ['label' => 'Jumlah Posyandu', 'value' => rand(1, 10), 'satuan' => 'unit'],
                    ['label' => 'Jumlah Puskesmas', 'value' => rand(0, 3), 'satuan' => 'unit'],
                    ['label' => 'Jumlah Tenaga Kesehatan', 'value' => rand(5, 20), 'satuan' => 'orang'],
                ];
            } elseif ($sektor == 'pendidikan') {
                $data = [
                    ['label' => 'Jumlah SD/MI', 'value' => rand(1, 5), 'satuan' => 'unit'],
                    ['label' => 'Jumlah SMP/MTs', 'value' => rand(0, 3), 'satuan' => 'unit'],
                    ['label' => 'Jumlah SMA/MA', 'value' => rand(0, 2), 'satuan' => 'unit'],
                    ['label' => 'Angka Melek Huruf', 'value' => rand(90, 100), 'satuan' => '%'],
                ];
            }

            DataSektoral::create([
                'desa_id' => $desaId,
                'user_id' => $adminId,
                'judul' => "Data {$sektor} tahun {$tahun}",
                'slug' => "data-{$sektor}-{$tahun}-" . ($i + 1) . "-" . time(),
                'sektor' => $sektor,
                'tahun' => $tahun,
                'deskripsi' => "Data {$sektor} Desa tahun {$tahun}. Data ini bersumber dari pendataan resmi yang dilakukan oleh perangkat desa.",
                'data' => $data,
                'is_published' => $isPublished,
                'published_at' => now()->subDays(rand(0, 30)),
                'view_count' => rand(0, 300),
            ]);
        }
    }

    /**
     * Seed sample metadata
     */
    private function createMetadata(): void
    {
        // Get all desa IDs
        $desaIds = Desa::pluck('id')->toArray();
        $adminId = User::where('email', 'admin@example.com')->value('id');

        if (empty($desaIds) || !$adminId) {
            return;
        }

        $jenisMetadata = [
            'profil' => 'Profil Desa',
            'struktur_organisasi' => 'Struktur Organisasi',
            'visi_misi' => 'Visi & Misi',
            'sejarah' => 'Sejarah',
            'demografi' => 'Demografi',
            'potensi' => 'Potensi',
            'lainnya' => 'Lainnya'
        ];

        foreach ($desaIds as $desaId) {
            $urutan = 1;
            foreach ($jenisMetadata as $jenis => $label) {
                Metadata::create([
                    'desa_id' => $desaId,
                    'jenis' => $jenis,
                    'judul' => $label,
                    'konten' => "<h2>{$label}</h2><p>Ini adalah konten untuk {$label} di Desa " . Desa::find($desaId)->nama . ".</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, nisl eget ultricies aliquam, nunc nisl aliquet nunc, eget ultricies nisl nunc eget nunc.</p>",
                    'is_active' => true,
                    'urutan' => $urutan,
                ]);
                $urutan++;
            }
        }
    }

    /**
     * Seed sample PPID
     */
    private function createPpid(): void
    {
        // Get all desa IDs
        $desaIds = Desa::pluck('id')->toArray();
        $adminId = User::where('email', 'admin@example.com')->value('id');

        if (empty($desaIds) || !$adminId) {
            return;
        }

        $kategoriPpid = [
            'informasi_berkala',
            'informasi_serta_merta',
            'informasi_setiap_saat',
            'informasi_dikecualikan'
        ];

        for ($i = 0; $i < 15; $i++) {
            $desaId = $desaIds[array_rand($desaIds)];
            $kategori = $kategoriPpid[array_rand($kategoriPpid)];
            $isPublished = rand(0, 10) > 2; // 80% chance to be published

            Ppid::create([
                'desa_id' => $desaId,
                'user_id' => $adminId,
                'judul' => "Dokumen PPID {$kategori} " . ($i + 1),
                'slug' => "ppid-{$kategori}-" . ($i + 1) . "-" . time(),
                'kategori' => $kategori,
                'deskripsi' => "Dokumen informasi publik kategori {$kategori}. Dokumen ini berisi informasi resmi yang dikeluarkan oleh Pemerintah Desa.",
                'is_published' => $isPublished,
                'published_at' => now()->subDays(rand(0, 30)),
                'download_count' => rand(0, 200),
            ]);
        }
    }

    /**
     * Seed sample galeri
     */
    private function createGaleri(): void
    {
        // Get all desa IDs
        $desaIds = Desa::pluck('id')->toArray();
        $adminId = User::where('email', 'admin@example.com')->value('id');

        if (empty($desaIds) || !$adminId) {
            return;
        }

        $kategoriGaleri = ['kegiatan', 'infrastruktur', 'wisata', 'budaya', 'umum'];

        for ($i = 0; $i < 20; $i++) {
            $desaId = $desaIds[array_rand($desaIds)];
            $kategori = $kategoriGaleri[array_rand($kategoriGaleri)];
            $isPublished = rand(0, 10) > 2; // 80% chance to be published
            $jenis = rand(0, 10) > 2 ? 'foto' : 'video'; // 80% chance to be photo

            Galeri::create([
                'desa_id' => $desaId,
                'user_id' => $adminId,
                'judul' => "Galeri {$kategori} " . ($i + 1),
                'deskripsi' => "Dokumentasi {$kategori} Desa " . Desa::find($desaId)->nama . ". Foto ini diambil pada kegiatan yang dilaksanakan oleh Pemerintah Desa.",
                'jenis' => $jenis,
                'kategori' => $kategori,
                'is_published' => $isPublished,
                'published_at' => now()->subDays(rand(0, 60)),
                'view_count' => rand(0, 500),
            ]);
        }
    }

    /**
     * Seed sample footer
     */
    private function createFooter(): void
    {
        // Get all desa IDs
        $desaIds = Desa::pluck('id')->toArray();

        if (empty($desaIds)) {
            return;
        }

        $sections = [
            'section1' => 'Logo & Lokasi',
            'section2' => 'Hubungi Kami',
            'section3' => 'Nomor Telepon Penting',
            'section4' => 'Jelajahi',
            'copyright' => 'Copyright',
        ];

        foreach ($desaIds as $desaId) {
            $desa = Desa::find($desaId);

            // Section 1 - Logo & Lokasi
            Footer::create([
                'desa_id' => $desaId,
                'section' => 'section1',
                'judul' => 'Logo & Lokasi',
                'konten' => [
                    'alamat' => "Kantor Desa {$desa->nama}, Kecamatan " . ucfirst(substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 8)) . ", Kabupaten Buton Selatan, Sulawesi Tenggara",
                    'maps_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15819.804810817273!2d122.5450192!3d-5.5095269!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2da46f9ab50c32bd%3A0xf7c68a7e56f7a99f!2sBau-Bau%2C%20Murhum%2C%20Kota%20Bau-Bau%2C%20Sulawesi%20Tenggara!5e0!3m2!1sid!2sid!4v1624267089815!5m2!1sid!2sid',
                ],
                'is_active' => true,
            ]);

            // Section 2 - Hubungi Kami
            Footer::create([
                'desa_id' => $desaId,
                'section' => 'section2',
                'judul' => 'Hubungi Kami',
                'konten' => [
                    'kontak' => [
                        [
                            'tipe' => 'telepon',
                            'nilai' => '0821' . rand(10000000, 99999999),
                            'aktif' => true,
                        ],
                        [
                            'tipe' => 'email',
                            'nilai' => 'info@desa' . strtolower($desa->nama) . '.id',
                            'aktif' => true,
                        ],
                    ],
                    'sosmed' => [
                        [
                            'tipe' => 'facebook',
                            'url' => 'https://facebook.com/desa' . strtolower($desa->nama),
                            'aktif' => true,
                        ],
                        [
                            'tipe' => 'instagram',
                            'url' => 'https://instagram.com/desa' . strtolower($desa->nama),
                            'aktif' => true,
                        ],
                        [
                            'tipe' => 'twitter',
                            'url' => 'https://twitter.com/desa' . strtolower($desa->nama),
                            'aktif' => rand(0, 1) == 1,
                        ],
                        [
                            'tipe' => 'youtube',
                            'url' => 'https://youtube.com/@desa' . strtolower($desa->nama),
                            'aktif' => rand(0, 1) == 1,
                        ],
                    ],
                ],
                'is_active' => true,
            ]);

            // Section 3 - Nomor Telepon Penting
            Footer::create([
                'desa_id' => $desaId,
                'section' => 'section3',
                'judul' => 'Nomor Telepon Penting',
                'konten' => [
                    'nomor_penting' => [
                        [
                            'nama' => 'Puskesmas',
                            'nomor' => '0821' . rand(10000000, 99999999),
                            'aktif' => true,
                        ],
                        [
                            'nama' => 'Polsek',
                            'nomor' => '0821' . rand(10000000, 99999999),
                            'aktif' => true,
                        ],
                        [
                            'nama' => 'Damkar',
                            'nomor' => '0821' . rand(10000000, 99999999),
                            'aktif' => true,
                        ],
                        [
                            'nama' => 'Kepala Desa',
                            'nomor' => '0821' . rand(10000000, 99999999),
                            'aktif' => true,
                        ],
                    ],
                ],
                'is_active' => true,
            ]);

            // Section 4 - Jelajahi
            Footer::create([
                'desa_id' => $desaId,
                'section' => 'section4',
                'judul' => 'Jelajahi',
                'konten' => [
                    'link_penting' => [
                        [
                            'nama' => 'Website Kabupaten',
                            'url' => 'https://butonsela.go.id',
                            'aktif' => true,
                        ],
                        [
                            'nama' => 'Website Kecamatan',
                            'url' => 'https://kecamatan.butonsela.go.id',
                            'aktif' => true,
                        ],
                        [
                            'nama' => 'Website BPS',
                            'url' => 'https://bps.go.id',
                            'aktif' => true,
                        ],
                    ],
                ],
                'is_active' => true,
            ]);

            // Copyright
            Footer::create([
                'desa_id' => $desaId,
                'section' => 'copyright',
                'judul' => 'Copyright',
                'konten' => [
                    'text' => '© 2025. Made with ☕ by Jstfire.',
                ],
                'is_active' => true,
            ]);
        }
    }

    /**
     * Seed sample pengaduan
     */
    private function createPengaduan(): void
    {
        // Get all desa IDs
        $desaIds = Desa::pluck('id')->toArray();
        $adminId = User::where('email', 'admin@example.com')->value('id');

        if (empty($desaIds) || !$adminId) {
            return;
        }

        $kategoriPengaduan = ['umum', 'sosial', 'keamanan', 'kesehatan', 'kebersihan', 'permintaan'];
        $statusPengaduan = ['baru', 'diproses', 'selesai', 'ditolak'];
        $namaPengirim = ['Ahmad Ridwan', 'Siti Nurhaliza', 'Budi Santoso', 'Dewi Lestari', 'Eko Prasetyo'];

        for ($i = 0; $i < 20; $i++) {
            $desaId = $desaIds[array_rand($desaIds)];
            $kategori = $kategoriPengaduan[array_rand($kategoriPengaduan)];
            $status = $statusPengaduan[array_rand($statusPengaduan)];
            $nama = $namaPengirim[array_rand($namaPengirim)];
            $isPublic = rand(0, 10) > 6; // 40% chance to be public

            $createdAt = now()->subDays(rand(0, 60));
            $responAt = $status !== 'baru' ? $createdAt->copy()->addHours(rand(1, 48)) : null;

            Pengaduan::create([
                'desa_id' => $desaId,
                'nama' => $nama,
                'email' => strtolower(str_replace(' ', '', $nama)) . '@gmail.com',
                'telepon' => '0821' . rand(10000000, 99999999),
                'judul' => "Pengaduan {$kategori} " . ($i + 1),
                'isi' => "Saya ingin melaporkan masalah terkait {$kategori} yang terjadi di desa kita. Mohon untuk segera ditindaklanjuti oleh aparatur desa yang berwenang.",
                'status' => $status,
                'respon' => $status !== 'baru' ? "Terima kasih atas laporan yang disampaikan. Kami akan segera menindaklanjuti pengaduan Anda dan memberikan informasi perkembangannya." : null,
                'responder_id' => $status !== 'baru' ? $adminId : null,
                'respon_at' => $responAt,
                'is_public' => $isPublic,
                'created_at' => $createdAt,
                'updated_at' => $responAt ?: $createdAt,
            ]);
        }
    }
}
