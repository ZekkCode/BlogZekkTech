<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoTest extends TestCase
{
    /**
     * Test if the SVG logo is accessible.
     *
     * @return void
     */
    public function test_svg_logo_is_accessible()
    {
        $response = $this->get('/images/zekktech-logo.svg');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'image/svg+xml');
    }
}
