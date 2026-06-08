<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PublicPagesGetTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function landing_page_can_be_accessed()
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertViewIs('landingpage');
    }

    /** @test */
    public function about_page_can_be_accessed()
    {
        $this->get('/about')
            ->assertStatus(200)
            ->assertViewIs('about');
    }

    /** @test */
    public function faq_page_can_be_accessed()
    {
        $this->get('/faq')
            ->assertStatus(200)
            ->assertViewIs('faq');
    }

    /** @test */
    public function contact_page_can_be_accessed()
    {
        $this->get('/contact')
            ->assertStatus(200)
            ->assertViewIs('contact');
    }

    /** @test */
    public function dashboard_requires_authentication()
    {
        $this->get('/dashboard')
            ->assertRedirect('/login');
    }

    /** @test */
    public function dashboard_can_be_accessed_when_logged_in()
    {
        $user = User::factory()->create();
        
        $this->actingAs($user)
            ->get('/dashboard')
            ->assertStatus(200)
            ->assertViewIs('dashboard');
    }
}
