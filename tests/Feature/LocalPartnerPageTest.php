<?php

namespace Tests\Feature;

use Tests\TestCase;

class LocalPartnerPageTest extends TestCase
{
    public function test_local_partners_page_loads(): void
    {
        $response = $this->get('/local-partners');

        $response->assertStatus(200);
    }

    public function test_local_partners_form_loads(): void
    {
        $response = $this->get('/local-partners/form');

        $response->assertStatus(200);
    }
}
