<?php

namespace Tests\Feature;

use Tests\TestCase;
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
}
