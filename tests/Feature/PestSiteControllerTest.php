<?php

use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function PHPUnit\Framework\assertEquals;

uses(RefreshDatabase::class);


it('can_create_site', function () {
  $user = User::factory()->create();

  actingAs($user)->post(route('sites.store', [
    'name' => 'Google',
    'url' => 'https://google.com'
  ]));

  $site = Site::first();
  assertEquals(1, Site::count());
  assertEquals('Google', $site->name);
});

// it('redirect_a_user_to_a_prev_site_if_they_try_to_add_duplicate', function () {
//   $user = User::factory()->create();
//   $site = $user->sites()->save(
//     Site::factory()->make()
//   );

//   actingAs($user)->post(route('sites.store'), [
//     'name' => 'Google 2',
//     'url' => $site->url
//   ])->assertRedirect(route('sites.show', ['site' => $site]));
// });
