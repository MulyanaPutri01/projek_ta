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

    /** Test that a user cannot delete or edit records uploaded/created by other users */
    public function test_user_ownership_deletion_and_edit_restriction()
    {
        if (!$this->bendaharaUser) {
            $this->markTestSkipped('Need bendahara user to test ownership restrictions');
        }

        // 1. Create a second Bendahara user who has 'keuangan-delete' & 'keuangan-edit' permissions
        $bendahara2 = Takmir::updateOrCreate(
            ['username' => 'bendahara_test2'],
            [
                'nama_takmir' => 'Bendahara Kedua Test',
                'password' => bcrypt('password123'),
                'status' => 'active',
                'role_id' => 2,
            ]
        );
        $bendahara2->syncRoles(['bendahara']);

        // 2. Create a Keuangan transaction as Bendahara 1
        $this->actingAs($this->bendaharaUser);
        $keuangan = Keuangan::create([
            'tanggal' => now()->toDateString(),
            'sumber_keuangan' => 'Kas Bendahara 1 Test Ownership',
            'keterangan' => 'Uji kepemilikan data',
            'nominal' => 100000,
            'kategori_id' => 1,
            'takmir_id' => $this->bendaharaUser->id,
        ]);

        // 3. Switch login to Bendahara 2 (same role, but not the creator)
        $this->actingAs($bendahara2);

        // Bendahara 2 attempts to delete Bendahara 1's transaction -> MUST BE BLOCKED
        $deleteResponse = $this->delete("/keuangan/{$keuangan->id}");
        $deleteResponse->assertRedirect(route('keuangan.index'));
        $deleteResponse->assertSessionHas('error');

        // Verify record still exists in database
        $this->assertNotNull(Keuangan::find($keuangan->id), 'Data transaksi milik orang lain tidak boleh terhapus oleh user lain!');

        // Bendahara 2 attempts to edit Bendahara 1's transaction -> MUST BE BLOCKED
        $editResponse = $this->get("/keuangan/{$keuangan->id}/edit");
        $editResponse->assertRedirect(route('keuangan.index'));
        $editResponse->assertSessionHas('error');

        // 4. Creator (Bendahara 1) can delete their own record
        $this->actingAs($this->bendaharaUser);
        $this->delete("/keuangan/{$keuangan->id}")->assertRedirect(route('keuangan.index'));
        $this->assertNull(Keuangan::find($keuangan->id));

        // Cleanup test user
        $bendahara2->delete();
    }

    /** Test Registration as Bendahara and proper dashboard redirection */
    public function test_registration_as_bendahara_assigns_correct_role_and_dashboard()
    {
        Takmir::where('username', 'bendahara_reg_test')->delete();

        $response = $this->post('/register', [
            'nama_takmir' => 'Bendahara Register Test',
            'username' => 'bendahara_reg_test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role_id' => 2, // Bendahara
        ]);

        $response->assertRedirect('/dashboard');

        $user = Takmir::where('username', 'bendahara_reg_test')->first();
        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('bendahara'));

        // Follow redirect to /dashboard
        $dashResponse = $this->actingAs($user)->get('/dashboard');
        $dashResponse->assertRedirect(route('bendahara.dashboard'));

        // Check sidebar on bendahara dashboard
        $bendaharaPage = $this->actingAs($user)->get('/bendahara-dashboard');
        $bendaharaPage->assertStatus(200);
        $bendaharaPage->assertSee('Dashboard Bendahara');
        $bendaharaPage->assertDontSee('Dashboard Sekretaris');

        // Cleanup
        $user->delete();
    }

    /** Test Full Permission CRUD Operations */
    public function test_permission_crud_operations()
    {
        if (!$this->adminUser) {
            $this->markTestSkipped('No admin user found');
        }

        $this->actingAs($this->adminUser);

        // 1. Index and DataTables
        $this->get('/permissions')->assertStatus(200)->assertSee('Kelola Hak Akses');
        $this->getJson('/permissions', ['X-Requested-With' => 'XMLHttpRequest'])->assertStatus(200);

        // 2. Create form
        $this->get('/permissions/create')->assertStatus(200)->assertSee('Formulir Hak Akses Baru');

        // 3. Store new permission
        \Spatie\Permission\Models\Permission::where('name', 'test-custom-permission')->delete();

        $storeResponse = $this->post('/permissions', [
            'name' => 'test-custom-permission',
            'roles' => [2], // Bendahara
        ]);

        $storeResponse->assertRedirect(route('permissions.index'));
        $created = \Spatie\Permission\Models\Permission::where('name', 'test-custom-permission')->first();
        $this->assertNotNull($created);

        // 4. Edit form
        $this->get("/permissions/{$created->id}/edit")->assertStatus(200)->assertSee('Edit Hak Akses');

        // 5. Update permission
        $updateResponse = $this->put("/permissions/{$created->id}", [
            'name' => 'test-custom-permission-updated',
            'roles' => [2, 3], // Bendahara & Sekretaris
        ]);

        $updateResponse->assertRedirect(route('permissions.index'));
        $updated = \Spatie\Permission\Models\Permission::where('name', 'test-custom-permission-updated')->first();
        $this->assertNotNull($updated);

        // 6. Delete permission
        $deleteResponse = $this->delete("/permissions/{$updated->id}");
        $deleteResponse->assertRedirect(route('permissions.index'));
        $this->assertNull(\Spatie\Permission\Models\Permission::find($updated->id));
    }

    /** Test SoftDelete, Trash Center, and Restore Functionality */
    public function test_soft_delete_and_restore_cycle()
    {
        if (!$this->adminUser) {
            $this->markTestSkipped('No admin user found');
        }

        $this->actingAs($this->adminUser);

        // 1. Create a Keuangan transaction
        $transaksi = Keuangan::create([
            'tanggal' => now()->toDateString(),
            'sumber_keuangan' => 'Kas Test SoftDelete & Restore',
            'keterangan' => 'Uji coba softdelete',
            'nominal' => 250000,
            'kategori_id' => 1,
            'takmir_id' => $this->adminUser->id,
        ]);

        $this->assertNotNull(Keuangan::find($transaksi->id));

        // 2. Perform delete -> Should trigger soft delete
        $deleteResp = $this->delete("/keuangan/{$transaksi->id}");
        $deleteResp->assertRedirect(route('keuangan.index'));

        // Normal query should not find the record
        $this->assertNull(Keuangan::find($transaksi->id));

        // withTrashed query should still find the record with deleted_at set
        $trashed = Keuangan::withTrashed()->find($transaksi->id);
        $this->assertNotNull($trashed);
        $this->assertNotNull($trashed->deleted_at);

        // 3. Access Trash Center page
        $trashPage = $this->get('/trash?tab=keuangan');
        $trashPage->assertStatus(200);
        $trashPage->assertSee('Kas Test SoftDelete & Restore');

        // 4. Restore the transaction via TrashController
        $restoreResp = $this->post("/trash/keuangan/{$transaksi->id}/restore");
        $restoreResp->assertStatus(302);

        // Record should now be back and visible to normal queries
        $restored = Keuangan::find($transaksi->id);
        $this->assertNotNull($restored);
        $this->assertNull($restored->deleted_at);

        // 5. Delete again and permanently force-delete via TrashController
        $this->delete("/keuangan/{$transaksi->id}");
        $this->assertNull(Keuangan::find($transaksi->id));

        $forceDeleteResp = $this->delete("/trash/keuangan/{$transaksi->id}/force-delete");
        $forceDeleteResp->assertStatus(302);

        // Record should be completely gone from database
        $this->assertNull(Keuangan::withTrashed()->find($transaksi->id));
    }
}
