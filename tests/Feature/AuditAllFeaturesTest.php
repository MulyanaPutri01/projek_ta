<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Takmir;
use App\Models\Kegiatan;
use App\Models\ProfilMasjid;
use App\Models\Donatur;
use App\Models\Keuangan;
use App\Models\Kategori;
use App\Models\Kondisi;
use App\Models\Posisi;

class AuditAllFeaturesTest extends TestCase
{
    protected $adminUser;
    protected $bendaharaUser;
    protected $sekretarisUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = Takmir::whereHas('role', function($q) {
            $q->where('nama_role', 'admin');
        })->first() ?? Takmir::first();

        $this->bendaharaUser = Takmir::whereHas('role', function($q) {
            $q->where('nama_role', 'bendahara');
        })->first() ?? $this->adminUser;

        $this->sekretarisUser = Takmir::whereHas('role', function($q) {
            $q->where('nama_role', 'sekretaris');
        })->first() ?? $this->adminUser;
    }

    /** Test public frontend routes and dynamic infaq / bank details */
    public function test_public_routes_accessible_and_dynamic_infaq()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Infaq / Shodaqoh');

        $this->get('/kegiatan-calendar')->assertStatus(200);
        $this->get('/api/kegiatan')->assertStatus(200);
        $this->get('/login')->assertStatus(200);
        $this->get('/register')->assertStatus(200);
    }

    /** Test optimized landing page (no 24-query loop) */
    public function test_landing_page_loads_correctly()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewHas('chartPemasukan');
        $response->assertViewHas('chartPengeluaran');
        $response->assertViewHas('chartMonths');
        $response->assertViewHas('totalPemasukan');
        $response->assertViewHas('totalSaldo');
    }

    /** Test Admin Dashboard & Modules */
    public function test_admin_dashboard_and_modules()
    {
        if (!$this->adminUser) {
            $this->markTestSkipped('No admin user found');
        }

        $this->actingAs($this->adminUser);

        $this->get('/dashboard')->assertStatus(302);
        $this->get('/admin-dashboard')->assertStatus(200);
        $this->get('/takmir')->assertStatus(200);
        $this->get('/users')->assertStatus(200);
        $this->get('/roles')->assertStatus(200);
        $this->get('/keuangan')->assertStatus(200);
        $this->get('/keuangan/create')->assertStatus(200);
        $this->get('/donatur')->assertStatus(200);
        $this->get('/donatur/create')->assertStatus(200);
        $this->get('/kategori')->assertStatus(200);
        $this->get('/laporan-keuangan')->assertStatus(200);
        $this->get('/laporan-cetak')->assertStatus(200);
        $this->get('/laporan-pdf')->assertStatus(200);
        $this->get('/kegiatan')->assertStatus(200);
        $this->get('/kegiatan/create')->assertStatus(200);
        $this->get('/kepanitiaan')->assertStatus(200);
        $this->get('/posisi')->assertStatus(200);
        $this->get('/inventaris')->assertStatus(200);
        $this->get('/inventaris/create')->assertStatus(200);
        $this->get('/inventaris-pdf')->assertStatus(200);
        $this->get('/catatan')->assertStatus(200);
        $this->get('/catatan/create')->assertStatus(200);
        $this->get('/kondisi')->assertStatus(200);
        $this->get('/profilmasjid')->assertStatus(200);
        $this->get('/galeri')->assertStatus(200);
        $this->get('/galeri/create')->assertStatus(200);

        $kegiatan = Kegiatan::first();
        if ($kegiatan) {
            $this->get("/kepanitiaan/sk-pdf/{$kegiatan->id}")->assertStatus(200);
        }
    }

    /** Test Admin Dashboard has optimized chart data */
    public function test_admin_dashboard_optimized_queries()
    {
        if (!$this->adminUser) {
            $this->markTestSkipped('No admin user found');
        }

        $this->actingAs($this->adminUser);

        $response = $this->get('/admin-dashboard');
        $response->assertStatus(200);
        $response->assertViewHas('chartPemasukan');
        $response->assertViewHas('chartPengeluaran');
        $response->assertViewHas('chartSaldo');
        $response->assertViewHas('pengeluaranLabels');
        $response->assertViewHas('totalPemasukan');
        $response->assertViewHas('totalSaldo');
    }

    /** Test Bendahara Dashboard & Permissions */
    public function test_bendahara_dashboard()
    {
        if (!$this->bendaharaUser) {
            $this->markTestSkipped('No bendahara user found');
        }

        $this->actingAs($this->bendaharaUser);

        $response = $this->get('/bendahara-dashboard');
        $response->assertStatus(200);
        $response->assertViewHas('chartPemasukan');
        $response->assertViewHas('pemasukanLabels');
        $response->assertViewHas('pengeluaranLabels');
        $this->get('/keuangan')->assertStatus(200);
        $this->get('/donatur')->assertStatus(200);
        $this->get('/laporan-keuangan')->assertStatus(200);
    }

    /** Test Sekretaris Dashboard & Permissions */
    public function test_sekretaris_dashboard()
    {
        if (!$this->sekretarisUser) {
            $this->markTestSkipped('No sekretaris user found');
        }

        $this->actingAs($this->sekretarisUser);

        $response = $this->get('/sekretaris-dashboard');
        $response->assertStatus(200);
        $response->assertViewHas('chartKegiatan');
        $response->assertViewHas('kondisiInventaris');
        $this->get('/kegiatan')->assertStatus(200);
        $this->get('/kepanitiaan')->assertStatus(200);
        $this->get('/catatan')->assertStatus(200);
    }

    /** Test all DataTables AJAX endpoints */
    public function test_all_datatables_ajax_endpoints()
    {
        if (!$this->adminUser) {
            $this->markTestSkipped('No admin user found');
        }

        $this->actingAs($this->adminUser);

        $headers = ['X-Requested-With' => 'XMLHttpRequest'];

        $this->getJson('/users', $headers)->assertStatus(200);
        $this->getJson('/takmir', $headers)->assertStatus(200);
        $this->getJson('/keuangan', $headers)->assertStatus(200);
        $this->getJson('/laporan-keuangan/datatables', $headers)->assertStatus(200);
        $this->getJson('/kegiatan', $headers)->assertStatus(200);
        $this->getJson('/kepanitiaan', $headers)->assertStatus(200);
        $this->getJson('/inventaris', $headers)->assertStatus(200);
        $this->getJson('/catatan', $headers)->assertStatus(200);
        $this->getJson('/donatur', $headers)->assertStatus(200);
        $this->getJson('/kategori', $headers)->assertStatus(200);
        $this->getJson('/posisi', $headers)->assertStatus(200);
        $this->getJson('/kondisi', $headers)->assertStatus(200);
        $this->getJson('/galeri', $headers)->assertStatus(200);
    }

    /** Test CRUD operations for key modules including Donatur and Profil Masjid */
    public function test_crud_operations()
    {
        if (!$this->adminUser) {
            $this->markTestSkipped('No admin user found');
        }

        $this->actingAs($this->adminUser);

        // 1. Test Donatur CRUD with Telepon
        $donaturResponse = $this->post('/donatur', [
            'tanggal' => now()->toDateString(),
            'nama_donatur' => 'H. Hidayatullah Test',
            'alamat' => 'Jl. Merdeka No. 123',
            'telepon' => '081298765432',
        ]);
        $donaturResponse->assertRedirect('/donatur');

        $donatur = Donatur::where('nama_donatur', 'H. Hidayatullah Test')->first();
        $this->assertNotNull($donatur);
        $this->assertEquals('081298765432', $donatur->telepon);

        // Test Donatur Edit Page
        $this->get("/donatur/{$donatur->id}/edit")->assertStatus(200);

        $updateDonatur = $this->put("/donatur/{$donatur->id}", [
            'tanggal' => now()->toDateString(),
            'nama_donatur' => 'H. Hidayatullah Test Updated',
            'alamat' => 'Jl. Merdeka No. 456',
            'telepon' => '081298765999',
        ]);
        $updateDonatur->assertRedirect('/donatur');

        // Test DataTables AJAX with search query on Donatur
        $dtSearchResponse = $this->getJson('/donatur?search[value]=Hidayatullah', ['X-Requested-With' => 'XMLHttpRequest']);
        $dtSearchResponse->assertStatus(200);

        // 2. Test Keuangan CRUD with Donatur relation
        $keuanganResponse = $this->post('/keuangan', [
            'tanggal' => now()->toDateString(),
            'sumber_keuangan' => 'Infaq Donatur Test',
            'keterangan' => 'Infaq dari donatur tetap',
            'nominal' => 750000,
            'kategori_id' => 1,
            'donatur_id' => $donatur->id,
        ]);
        $keuanganResponse->assertRedirect(route('keuangan.index'));

        $keuangan = Keuangan::where('sumber_keuangan', 'Infaq Donatur Test')->first();
        $this->assertNotNull($keuangan);

        // 3. Test Profil Masjid Bank Account & Infaq Update
        $profil = ProfilMasjid::first();
        if ($profil) {
            $profilResponse = $this->put("/profilmasjid/{$profil->id}", [
                'nama_masjid' => $profil->nama_masjid,
                'alamat' => $profil->alamat,
                'telepon' => $profil->telepon,
                'nama_bank' => 'BANK SYARIAH INDONESIA (BSI)',
                'nomor_rekening' => '7145-8890-2101',
                'atas_nama' => 'Takmir Masjid Jami Al-Ikhlas',
                'judul_infaq' => 'Salurkan Infaq Terbaik Anda',
                'deskripsi_infaq' => 'Dukung kemakmuran masjid, kegiatan dakwah, santunan yatim, dan pemeliharaan fasilitas masjid.',
            ]);
            $profilResponse->assertRedirect(route('profilmasjid.index'));

            // Verify Landing Page has the updated dynamic database values
            $landingResponse = $this->get('/');
            $landingResponse->assertStatus(200);
            $landingResponse->assertSee('BANK SYARIAH INDONESIA (BSI)');
            $landingResponse->assertSee('7145-8890-2101');
            $landingResponse->assertSee('Takmir Masjid Jami Al-Ikhlas');
            $landingResponse->assertSee('Salurkan Infaq Terbaik Anda');
        }

        // 4. Test Kategori system protection (ID 1 & 2 must not be deletable)
        $deleteKategori = $this->delete('/kategori/1');
        $deleteKategori->assertRedirect('/kategori');
        $kategori1 = Kategori::find(1);
        $this->assertNotNull($kategori1, 'Kategori ID 1 (Pemasukan) harus tidak terhapus!');

        // Cleanup test data
        $this->delete("/keuangan/{$keuangan->id}");
        $this->delete("/donatur/{$donatur->id}");
    }
}
