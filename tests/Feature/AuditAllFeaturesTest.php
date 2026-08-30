<?php

namespace Tests\Feature;


use Tests\TestCase;
use App\Models\Takmir;
use App\Models\Kegiatan;

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

    /** Test public frontend routes */
    public function test_public_routes_accessible()
    {
        $this->get('/')->assertStatus(200);
        $this->get('/kegiatan-calendar')->assertStatus(200);
        $this->get('/api/kegiatan')->assertStatus(200);
        $this->get('/login')->assertStatus(200);
        $this->get('/register')->assertStatus(200);
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

    /** Test Bendahara Dashboard & Permissions */
    public function test_bendahara_dashboard()
    {
        if (!$this->bendaharaUser) {
            $this->markTestSkipped('No bendahara user found');
        }

        $this->actingAs($this->bendaharaUser);

        $this->get('/bendahara-dashboard')->assertStatus(200);
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

        $this->get('/sekretaris-dashboard')->assertStatus(200);
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

    /** Test CRUD operations for key modules */
    public function test_crud_operations()
    {
        if (!$this->adminUser) {
            $this->markTestSkipped('No admin user found');
        }

        $this->actingAs($this->adminUser);

        // 1. Test Donatur CRUD
        $donaturResponse = $this->post('/donatur', [
            'tanggal' => now()->toDateString(),
            'nama_donatur' => 'Test Audit Donatur',
            'alamat' => 'Jl. Test Audit No. 123',
        ]);
        $donaturResponse->assertRedirect('/donatur');

        $donatur = \App\Models\Donatur::where('nama_donatur', 'Test Audit Donatur')->first();
        $this->assertNotNull($donatur);

        $updateDonatur = $this->put("/donatur/{$donatur->id}", [
            'tanggal' => now()->toDateString(),
            'nama_donatur' => 'Test Audit Donatur Updated',
            'alamat' => 'Jl. Test Audit No. 456',
        ]);
        $updateDonatur->assertRedirect('/donatur');

        // 2. Test Keuangan CRUD
        $keuanganResponse = $this->post('/keuangan', [
            'tanggal' => now()->toDateString(),
            'sumber_keuangan' => 'Infaq Audit Test',
            'keterangan' => 'Keterangan Infaq Test',
            'nominal' => 500000,
            'kategori_id' => 1,
            'donatur_id' => $donatur->id,
        ]);
        $keuanganResponse->assertRedirect(route('keuangan.index'));

        $keuangan = \App\Models\Keuangan::where('sumber_keuangan', 'Infaq Audit Test')->first();
        $this->assertNotNull($keuangan);

        // Cleanup test data
        $this->delete("/keuangan/{$keuangan->id}");
        $this->delete("/donatur/{$donatur->id}");
    }
}
