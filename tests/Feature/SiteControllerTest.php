<?php

namespace Tests\Feature;

use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SiteControllerTest extends TestCase
{
  use RefreshDatabase;

  public function test_create_site_and_send_notification_to_user()
  {
    $user = User::factory()->create();
    // Notification::fake();

    $response = $this->followingRedirects()
      ->actingAs($user)
      ->post(route('sites.store'), [
        'name' => 'Google',
        'url' => 'https://google.com'
      ]);

    $site = Site::first();
    $this->assertEquals(1, Site::count());
    $this->assertEquals('Google', $site->name);
    $this->assertEquals('https://google.com', $site->url);
    $this->assertNull($site->is_online);
    $this->assertEquals($user->id, $site->user_id);

    $response->assertSeeText('Google');
    // $this->assertEquals(route("sites.show", $site), url()->current());

    // Notification::assertSentTo($user, SiteAdded::class);
  }

  public function test_only_allows_authenticated_users_to_create_sites()
  {
    $response = $this->followingRedirects()
      ->post(route('sites.store'), [
        'name' => 'Google',
        'url' => 'https://google.com'
      ]);

    $this->assertEquals(0, Site::count());

    $response->assertSeeText('Log in');
    $this->assertEquals(route("login"), url()->current());
  }

  public function test_required_all_fields_to_be_present()
  {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
      ->post(route('sites.store'), [
        'name' => '',
        'url' => ''
      ]);

    $this->assertEquals(0, Site::count());

    $response->assertSessionHasErrors(['name', 'url']);
  }
}
