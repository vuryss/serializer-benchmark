<?php

declare(strict_types=1);

namespace Vuryss\SerializerBenchmark\Tests\Datasets\Complex1;

readonly class JobActivity
{
    /**
     * @param ComponentData[] $components
     */
    public function __construct(
        public string $activityCategory,
        public ?string $activityName,
        public array $components,
        public ?string $jobExternalId,
    ) {}
}
