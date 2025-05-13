<?php

declare(strict_types=1);

namespace Vuryss\SerializerBenchmark\Tests\Datasets\Basic2;

use Vuryss\SerializerBenchmark\Tests\Helper\Faker;

readonly class Generator
{
    public function generate(): Car
    {
        $faker = Faker::instance();

        return new Car(
            bodyType: $faker->text(),
            cargoVolume: $faker->numberBetween(1, 100),
            dateVehicleFirstRegistered: \DateTimeImmutable::createFromInterface($faker->dateTime()),
            fuelConsumption: $faker->randomFloat(2, 1, 100),
        );
    }
}
