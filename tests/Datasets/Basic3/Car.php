<?php

declare(strict_types=1);

namespace Vuryss\SerializerBenchmark\Tests\Datasets\Basic3;

readonly class Car
{
    public function __construct(
        public string $bodyType,

        public int $cargoVolume,

        public \DateTimeImmutable $dateVehicleFirstRegistered,

        public float $fuelConsumption,
    ) {
    }
}
