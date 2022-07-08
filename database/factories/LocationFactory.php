<?php

namespace Database\Factories;

use Domains\Customer\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;
use JustSteveKing\LaravelPostcodes\Service\PostcodeService;
use Illuminate\Support\Str;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition(): array
    {
        $service = resolve(PostcodeService::class);
        $location = $service->getRandomPostCode();
        $stressAddress = $this->faker->streetAddress;


        return [
            'house' => Str::of($stressAddress)->before(search:' '),
            'street' => Str::of($stressAddress)->after(search:' '),
            'parish' => data_get(target: $location, key:'parish'),
            'ward' => data_get(target: $location, key:'admin_ward'),
            'district' => data_get(target: $location, key: 'admin_district'),
            'county' => data_get(target: $location, key:'admin_county'),
            'postcode' => data_get(target:$location, key:'postcode'),
            'country' => data_get(target:$location, key:'country')
        ];
    }
}
