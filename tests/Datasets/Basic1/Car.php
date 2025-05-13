<?php

declare(strict_types=1);

namespace Vuryss\SerializerBenchmark\Tests\Datasets\Basic1;

class Car
{
    public string $bodyType;

    public int $cargoVolume;

    public \DateTimeImmutable $dateVehicleFirstRegistered;

    public float $fuelConsumption;
}
