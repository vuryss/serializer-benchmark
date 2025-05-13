<?php

declare(strict_types=1);

namespace Vuryss\SerializerBenchmark\Tests\Benchmarks;

use PhpBench\Attributes\BeforeMethods;
use PhpBench\Attributes\ParamProviders;
use Symfony\Component\Serializer\Serializer;
use Vuryss\SerializerBenchmark\Tests\Datasets\Generator;
use Vuryss\SerializerBenchmark\Tests\Helper\SymfonySerializer;
use Vuryss\SerializerBenchmark\Tests\Datasets;

class SerializerBench
{
    private Serializer $symfonySerializer;
    private \Vuryss\Serializer\Serializer $vuryssSerializer;

    #[ParamProviders('provideObject')]
    #[BeforeMethods('setUpSymfony')]
    public function benchSymfonySerialize(array $params): void
    {
        $this->symfonySerializer->serialize($params['object'], 'json');
    }

    #[ParamProviders('provideSerialized')]
    #[BeforeMethods('setUpSymfony')]
    public function benchSymfonyDeserialize(array $params): void
    {
        $this->symfonySerializer->deserialize($params['serialized'], $params['class'], 'json');
    }

    #[ParamProviders('provideObject')]
    #[BeforeMethods('setUpVuryss')]
    public function benchVuryssSerialize(array $params): void
    {
        $this->vuryssSerializer->serialize($params['object']);
    }

    #[ParamProviders('provideSerialized')]
    #[BeforeMethods('setUpVuryss')]
    public function benchVuryssDeserialize(array $params): void
    {
        $this->vuryssSerializer->deserialize($params['serialized'], $params['class']);
    }

    public function setUpSymfony(): void
    {
        $this->symfonySerializer = SymfonySerializer::instance();
    }

    public function setUpVuryss(): void
    {
        $this->vuryssSerializer = new \Vuryss\Serializer\Serializer();
    }

    public function provideObject(): iterable
    {
        return [
            'basic1' => [
                'object' => Generator::basic1(),
            ],
            'basic2' => [
                'object' => Generator::basic2(),
            ],
            'basic3' => [
                'object' => Generator::basic3(),
            ],
            'complex1' => [
                'object' => Generator::complex1(),
            ],
        ];
    }

    public function provideSerialized(): iterable
    {
        static $serializer = SymfonySerializer::instance();

        return [
            'basic1' => [
                'serialized' => $serializer->serialize(Generator::basic1(), 'json'),
                'class' => Datasets\Basic1\Car::class,
            ],
            'basic2' => [
                'serialized' => $serializer->serialize(Generator::basic2(), 'json'),
                'class' => Datasets\Basic2\Car::class,
            ],
            'basic3' => [
                'serialized' => $serializer->serialize(Generator::basic3(), 'json'),
                'class' => Datasets\Basic3\Car::class,
            ],
            'complex1' => [
                'serialized' => $serializer->serialize(Generator::complex1(), 'json'),
                'class' => Datasets\Complex1\RouteData::class,
            ]
        ];
    }
}
