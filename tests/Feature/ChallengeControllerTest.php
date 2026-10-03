<?php

namespace Tests\Feature;

use App\Http\Controllers\ChallengeController;
use Illuminate\Http\Request;
use Tests\TestCase;

class ChallengeControllerTest extends TestCase
{
    public function test_guest_users_are_redirected_to_login_when_accessing_challenge_pages(): void
    {
        $controller = new ChallengeController();
        $request = Request::create('/challenge');

        $response = $controller->index($request);

        $this->assertTrue($response->isRedirect());
        $this->assertSame(route('login'), $response->headers->get('Location'));
    }
}
