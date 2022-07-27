<?php

declare(strict_types=1);

use Domains\Customer\Models\User;
use Domains\Customer\Models\Wishlist;
use Illuminate\Testing\Fluent\AssertableJson;
use JustSteveKing\StatusCode\Http;

use function Pest\Laravel\get;
use function Pest\Laravel\post;

it('can list all wishlists for a user', function (User  $user) {
  // Login in a random user
  auth()->login($user);

  // create a wishlist for the login user
  Wishlist::factory()->create([
    'user_id' => auth()->id()
  ]);

  // expect the total number of wishlists for this user to be equal to 1
  expect(value: auth()->user()->wishlists()->count())->toBe(expected: 1);

  // hit an endpoint to get the wishlists
  get(
    route('api:v1:wishlists:index')
  )->assertStatus(
    status: Http::OK
  )->assertJson( //expect the returned json data equals to 1
    fn(AssertableJson $json) => $json->count(1)
  );

})->with('user');

it('can get all the public wishlists', function () {
   // create 12 public wishlists
  Wishlist::factory(12)->create([
    'public' => true
  ]);

  // create 10 wishlists that are not public
  Wishlist::factory(10)->create([
    'public' => false
  ]); 

  // hit an endpoint to get the wishlists
  get(
    route('api:v1:wishlists:index')
  )->assertStatus(
    status: Http::OK
  )->assertJson( //expect the returned json data equals to 12
    fn(AssertableJson $json) => $json->count(12)
  );
});

it('can create a new wishlist', function(User $user) {
  // login in a random user
  auth()->login($user);

  // expect that the wishlist created so far is 0
  expect(value: Wishlist::query()->count())->toBe(expected: 0);

  // hit an endpoint to create a wishlist
  post(
    route('api:v1:wishlists:store'),
    data: [
      'name' => 'wishlist test name',
    ]
  )->assertStatus(
    status: Http::CREATED
  );

  // expect that the wishlist created so far is 1
  expect(value: Wishlist::query()->count())->toBe(expected: 1);
})->with('user');

it('can show a specific wishlist', function () {
  $wishlist = Wishlist::factory()->create();

  get(
    route('api:v1:wishlists:show',$wishlist->uuid)
  )->assertStatus(
    status: Http::OK
  )->assertJson(
    fn(AssertableJson $json) => $json
      ->where('attributes.name', $wishlist->name)
      ->where('type' , 'wishlist')
      ->where('id', $wishlist->uuid)
      ->etc()
  );

});
