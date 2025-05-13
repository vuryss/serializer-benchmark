<?php

declare(strict_types=1);

namespace Vuryss\SerializerBenchmark\Tests\Helper;

use Faker\Factory;
use Faker\Generator;

class Faker
{
    private static Generator $faker;

    public static function instance(): Generator
    {
        if (!isset(self::$faker)) {
            self::$faker = Factory::create();
        }

        return self::$faker;
    }
}
