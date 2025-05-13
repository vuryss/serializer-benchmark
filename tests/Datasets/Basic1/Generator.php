<?php

declare(strict_types=1);

namespace Vuryss\SerializerBenchmark\Tests\Datasets\Basic1;

use Vuryss\SerializerBenchmark\Tests\Helper\Faker;

readonly class Generator
{
    public function generate(): Car
    {
        $faker = Faker::instance();

        $car = new Car();
        $car->bodyType = $faker->text();
        $car->cargoVolume = $faker->numberBetween(1, 100);
        $car->dateVehicleFirstRegistered = \DateTimeImmutable::createFromInterface($faker->dateTime());
        $car->fuelConsumption = $faker->randomFloat(2, 1, 100);

        return $car;
    }
}
