<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LelangAccessTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cannot_access_lelang_page()
    {
        // Akses halaman lelang tanpa login
        $response = $this->get('/lelang');

        // Harus redirect ke login
        $response->assertRedirect('/login');
    }
}
