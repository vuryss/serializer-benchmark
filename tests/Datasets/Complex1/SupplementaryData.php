<?php

declare(strict_types=1);

namespace Vuryss\SerializerBenchmark\Tests\Datasets\Complex1;

readonly class SupplementaryData
{
    public function __construct(
        public int $orderIndex,
        public string $details,
        public bool $displayOnMain,
        public bool $emphasized,
        public string $symbol,
    ) {}
}
