<?php

declare(strict_types=1);

namespace Vuryss\SerializerBenchmark\Tests\Datasets;

class Generator
{
    private static Basic1\Car $basic1;
    private static Basic2\Car $basic2;
    private static Basic3\Car $basic3;
    private static Complex1\RouteData $complex1;

    public static function basic1(): Basic1\Car
    {
        if (!isset(self::$basic1)) {
            self::$basic1 = new Basic1\Generator()->generate();
        }

        return self::$basic1;
    }

    public static function basic2(): Basic2\Car
    {
        if (!isset(self::$basic2)) {
            self::$basic2 = new Basic2\Generator()->generate();
        }

        return self::$basic2;
    }

    public static function basic3(): Basic3\Car
    {
        if (!isset(self::$basic3)) {
            self::$basic3 = new Basic3\Generator()->generate();
        }

        return self::$basic3;
    }

    public static function complex1(): Complex1\RouteData
    {
        if (!isset(self::$complex1)) {
            self::$complex1 = new Complex1\Generator()->generate();
        }

        return self::$complex1;
    }
}
