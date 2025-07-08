<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Desa;
use App\Models\ProfilDesa;

class ProfilDesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $desas = Desa::all();

        foreach ($desas as $desa) {
            $this->createProfilForDesa($desa);
        }
    }

    private function createProfilForDesa($desa)
    {
        // Tentang Desa
        ProfilDesa::create([
            'desa_id' => $desa->id,
            'jenis' => 'tentang',
            'judul' => 'Tentang ' . $desa->nama,
            'konten' => '<p>' . $desa->nama . ' adalah ' . $desa->jenis . ' yang terletak di wilayah Kabupaten Buton Selatan, Provinsi Sulawesi Tenggara. Dengan keindahan alam yang menawan dan kekayaan budaya yang masih terjaga, ' . $desa->nama . ' menjadi salah satu destinasi menarik di kawasan ini.</p>
                        <p>Sebagai bagian dari wilayah administratif Kabupaten Buton Selatan, ' . $desa->nama . ' memiliki komitmen untuk terus berkembang menjadi daerah yang mandiri, sejahtera, dan berkelanjutan. Melalui potensi sumber daya alam dan sumber daya manusia yang ada, kami terus berupaya meningkatkan taraf hidup masyarakat.</p>',
            'is_published' => true,
            'urutan' => 1,
        ]);

        // Visi Misi
        ProfilDesa::create([
            'desa_id' => $desa->id,
            'jenis' => 'visi_misi',
            'judul' => 'Visi dan Misi ' . $desa->nama,
            'konten' => '<h3>VISI</h3>
                        <p>"Terwujudnya ' . $desa->nama . ' yang Mandiri, Sejahtera, dan Berkelanjutan Berbasis Potensi Lokal"</p>
                        
                        <h3>MISI</h3>
                        <ol>
                            <li>Mengembangkan potensi ekonomi lokal melalui pemberdayaan masyarakat</li>
                            <li>Meningkatkan kualitas pelayanan publik yang prima dan transparan</li>
                            <li>Melestarikan nilai-nilai budaya dan kearifan lokal</li>
                            <li>Membangun infrastruktur yang mendukung kesejahteraan masyarakat</li>
                            <li>Menciptakan tata kelola pemerintahan yang baik dan akuntabel</li>
                        </ol>',
            'is_published' => true,
            'urutan' => 2,
        ]);

        // Struktur Organisasi
        ProfilDesa::create([
            'desa_id' => $desa->id,
            'jenis' => 'struktur',
            'judul' => 'Struktur Pemerintahan ' . $desa->nama,
            'konten' => '<p>Struktur pemerintahan ' . $desa->nama . ' terdiri dari berbagai jabatan dan unit kerja yang saling mendukung dalam menjalankan roda pemerintahan dan pelayanan kepada masyarakat.</p>
                        <h4>Struktur Organisasi:</h4>
                        <ul>
                            <li><strong>Kepala ' . ucfirst($desa->jenis) . '</strong> - Pemimpin tertinggi dalam struktur pemerintahan</li>
                            <li><strong>Sekretaris ' . ucfirst($desa->jenis) . '</strong> - Koordinator administrasi dan tata usaha</li>
                            <li><strong>Kepala Urusan Pemerintahan</strong> - Menangani administrasi kependudukan</li>
                            <li><strong>Kepala Urusan Pembangunan</strong> - Mengelola program pembangunan</li>
                            <li><strong>Kepala Urusan Kesejahteraan Rakyat</strong> - Fokus pada kesejahteraan masyarakat</li>
                            <li><strong>Kepala Dusun/RW/RT</strong> - Koordinator di tingkat wilayah</li>
                        </ul>',
            'is_published' => true,
            'urutan' => 3,
        ]);

        echo "Profil desa untuk {$desa->nama} berhasil dibuat.\n";
    }
}
