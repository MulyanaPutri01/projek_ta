<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Takmir;
use App\Models\ProfilMasjid;
use App\Models\Keuangan;
use App\Models\Kegiatan;

class DisplayMasjidTest extends TestCase
{
    /** Test that display tv pages are accessible publicly */
    public function test_display_pages_accessible()
    {
        $response = $this->get('/display');
        $response->assertStatus(200);
        $response->assertSee('Display Digital Masjid');
        $response->assertSee('WAKTU ADZAN');
        $response->assertSee('HITUNG MUNDUR IQOMAH');
        $response->assertSee('LURUS DAN RAPATKAN SHAF');

        $responseTv = $this->get('/tv-masjid');
        $responseTv->assertStatus(200);
    }

    /** Test display api data endpoint returns json */
    public function test_display_api_data_endpoint()
    {
        $response = $this->getJson('/api/display-data');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'timestamp',
            'saldo',
            'saldo_formatted',
            'kegiatan_count',
            'nama_masjid'
        ]);
        $response->assertJson([
            'status' => 'success'
        ]);
    }

    /** Test that authenticated admin can access and update smart tv settings */
    public function test_admin_can_access_and_update_smart_tv_settings()
    {
        $admin = Takmir::whereHas('role', function($q) {
            $q->where('nama_role', 'admin');
        })->first() ?? Takmir::first();

        $this->actingAs($admin);

        $response = $this->get('/smart-tv/setting');
        $response->assertStatus(200);
        $response->assertSee('Pengaturan Smart TV Digital Signage');

        $postResponse = $this->post('/smart-tv/setting', [
            'khotib' => 'Ustadz Penguji TA',
            'imam' => 'Ustadz Imam Masjid',
            'muadzin' => 'Ustadz Bilal',
            'bilal' => 'Ustadz Muroqi',
            'tema_khutbah' => 'Keutamaan Sholat Berjamaah',
            'theme' => 'theme-emerald',
            'slide_interval' => 10,
            'iqomah_subuh' => 12,
            'iqomah_dzuhur' => 10,
            'iqomah_ashar' => 8,
            'iqomah_maghrib' => 7,
            'iqomah_isya' => 10,
            'running_texts_html' => "<p>Selamat datang di <strong>Masjid Al-Ikhlas</strong>.</p><p>Harap senyapkan HP saat sholat.</p>"
        ]);

        $postResponse->assertRedirect('/smart-tv/setting');
        $postResponse->assertSessionHas('success');
    }
}
